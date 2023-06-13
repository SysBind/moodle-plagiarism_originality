<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * plagiarism_originality resubmit documents.
 *
 * @package    plagiarism_originality
 * @copyright  2023 mattandor <mattan@centricapp.co>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace plagiarism_originality\task;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/plagiarism/originality/lib.php');
require_once($CFG->dirroot . '/plagiarism/originality/locallib.php');

class resubmit_submissions extends \core\task\scheduled_task {

    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string
     */
    public function get_name() {
        return get_string('pluginname', 'plagiarism_originality');
    }

    /**
     * Execute the task.
     */
    public function execute() {
        global $DB;

        $lib = new \plagiarism_plugin_originality();
        $updated = time() - 3600;
        $submissions = $DB->get_records_sql('SELECT * FROM {originality_submissions}
                                                            WHERE parent = 1 AND
                                                                  updated >= ? AND
                                                                  status = 0', array($updated));
        $tmp = [];
        if (!$submissions) {
            mtrace('Error Task: there is no any submissions to resubmit.');
        }

        foreach ($submissions as $submission) {

            if (!is_array($tmp[$submission->userid])) {
                $tmp[$submission->userid] = [];
            }

            if (in_array($submission->assignment, $tmp[$submission->userid])) {
                continue;
            }

            array_push($tmp[$submission->userid], $submission->assignment);

            $course = $lib->utils->get_course($submission->assignment);
            if (!$course) {
                mtrace('Error Task: there is no any course for this submission ID: ' . $submission->id);
                return true;
            }

            $submissionid = $lib->utils->get_submission_id($submission->assignment, $submission->userid);
            if (!$submissionid) {
                return true;
            }

            $moduleassign = $DB->get_record('modules', array('name' => 'assign'));
            $cm = $DB->get_record('course_modules',
                    array('instance' => $submission->assignment, 'course' => $course->id, 'module' => $moduleassign->id));

            if (!$cm) {
                return true;
            }

            $eventdata = array();
            $eventdata['eventname'] = '\mod_assign\event\assessable_submitted';
            $eventdata['contextinstanceid'] = $cm->id;
            $eventdata['objectid'] = $submission->objectid;
            $eventdata['courseid'] = $course->id;
            $eventdata['userid'] = $submission->userid;
            $eventdata['assignNum'] = $submission->assignment;

            if ($submission->moodle_file_id < 0) {
                $onlinetext = $DB->get_record('assignsubmission_onlinetext',
                        array('assignment' => $submission->assignment, 'submission' => $submissionid[0]));

                if ($onlinetext) {
                    $eventdata['other']['content'] = $onlinetext->onlinetext;
                }

                $upload = $lib->originality_event_onlinetext_submitted($eventdata, true);
            } else {
                $upload = $lib->originality_event_file_uploaded($eventdata, true);
            }

            $submission->attempts++;
            $submission->updated = time();
            if ($upload) {
                $submission->status = 1;
            }

            $lib->utils->update_submission($submission);
            mtrace('Resubmit >>> submission id: ' . $submission->id . ', assignment: ' . $submission->assignment .
                    ', ghostwriter: ' . $submission->ghostwriter . ', user:' . $submission->userid . ', status: ' .
                    $submission->status);
        }

        return true;
    }
}
