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
 * plagiarism_originality external webservice
 *
 * @package    plagiarism_originality
 * @copyright  2023 mattandor <mattan@centricapp.co>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

global $CFG;

require_once($CFG->libdir . '/externallib.php');
require_once($CFG->dirroot . '/plagiarism/originality/locallib.php');

class plagiarism_originality_external extends external_api {
    public static function create_report_parameters() {
        return new external_function_parameters([
                'docId' => new external_value(PARAM_ALPHANUM, 'A document ID value for ordering the entries.'),
                'content' => new external_value(PARAM_RAW, 'The main content of the entry.'),
                'grade' => new external_value(PARAM_INT, 'The grade or rating associated with the entry.'),
        ]);
    }

    public static function create_report($docid, $content, $grade) {
        global $DB;

        $params = self::validate_parameters(self::execute_parameters(), [
                'docid' => $docid,
                'content' => $content,
                'grade' => $grade,
        ]);

        $context = context_system::instance();
        self::validate_context($context);
        require_capability('plagiarism/originality:manage', $context);

        $output = new stdClass();
        $output->utils = new plagiarism_plugin_originality_utils;
        $output->error = false;

        $submission = $DB->get_record('originality_submissions', array(
                'docid' => $params['docid']
        ));

        if (!$submission) {
            $output->error = true;
        } else {
            unset($submission->file);
            $submission->status = 2;
            $submission->updated = time();
            $submission->grade = $params['grade'];

            $output->utils->update_submission($submission);

            $file = new stdClass();
            $file->content = base64_decode($params['content']);
            $file->itemid = $submission->id;
            $output->utils->save_file($file);
        }

        return $output;
    }

    public static function create_report_returns() {
        return new external_single_structure([
                'error' => new external_value(PARAM_BOOL, 'Indicates whether an error occurred during the operation.', true)
        ]);
    }
}
