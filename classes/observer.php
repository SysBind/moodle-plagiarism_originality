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
 * plagiarism_originality observer.
 *
 * @package    plagiarism_originality
 * @copyright  2023 mattandor <mattan@centricapp.co>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/plagiarism/originality/lib.php');

class plagiarism_originality_observer {

    public static function assignsubmission_file_uploaded(
            \assignsubmission_file\event\assessable_uploaded $event) {
        $eventdata = $event->get_data();
        $originality = new plagiarism_plugin_originality();
        $originality->originality_event_file_uploaded($eventdata);
    }

    public static function assignsubmission_submitted(
            \mod_assign\event\assessable_submitted $event) {
        $eventdata = $event->get_data();
        $originality = new plagiarism_plugin_originality();
        $originality->originality_event_submitted($eventdata);
    }

    public static function assignsubmission_onlinetext_uploaded(
            \assignsubmission_onlinetext\event\assessable_uploaded $event) {
        $eventdata = $event->get_data();
        $originality = new plagiarism_plugin_originality();
        $originality->originality_event_onlinetext_submitted($eventdata);
    }
}

