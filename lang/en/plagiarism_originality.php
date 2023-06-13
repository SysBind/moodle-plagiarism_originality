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
 * plagiarism_originality EN
 *
 * @package    plagiarism_originality
 * @copyright  2023 mattandor <mattan@centricapp.co>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Originality - Plagiarism Detection';
$string['originality'] = 'Originality - Document Plagiarism Detection';
$string['originality_help'] = 'Enable plagiarism detection for text-based assignments. Do not use it for assignments in different languages or for engineering assignments, as the mechanism is not designed for that.';
$string['originality_shortname'] = 'Originality';
$string['plugin_server_type'] = 'Originality Server';
$string['plugin_settings'] = 'Originality Settings';
$string['plugin_enabled'] = 'Enable the plugin';
$string['plugin_connected'] = 'Valid API key, connected to the Originality system';
$string['student_disclosure'] = "You must mark √ in the appropriate place to submit the assignment for originality check. Without marking this, the submission of this assignment will not be possible.<br>This submission is original, it belongs to me, was prepared by me, and I take responsibility for the originality of the content written in it.<br><br>Except for the places where I have indicated that the work was done by others and there is a relevant link in the bibliography or in the required place.<br><br>I am aware and agree that this assignment will be checked for literary theft detection by the company Originality, and I agree to the <a rel='external' href='https://www.originality.co.il/termsOfUse.html' target='_blank' style='text-decoration:underline'>Terms of Use</a>.";
$string['secret'] = 'Access Key';
$string['key'] = 'Access Key';
$string['key_help'] = 'To use this plugin, you need an access key.';
$string['saved_failed'] = 'Invalid access key entered, the plugin is not active.';
$string['checking_inprocessmsg'] = 'In progress';
$string['checking_unprocessable'] = 'Unprocessable';
$string['submitted_before_activation'] = 'Submitted before plugin activation';
$string['service_is_inactive'] = 'Originality plugin is inactive. Please contact your Moodle administrator.';
$string['warning_message'] = "You must check the consent box ('I am aware and agree') to enable the submit button.";
$string['previous_submissions'] = 'Existing submissions already made. These students need to resubmit for their work to be checked for originality.';
$string['production_endpoint'] = '<b>Production Server</b>&nbsp;&nbsp;<span style="font-size:14px;">Submit assignments to the Originality production server.</span>';
$string['test_endpoint'] = '<b>Test Server</b>&nbsp;&nbsp;<span style="font-size:14px;">Submit assignments to the Originality test server. Select this option only after coordinating with Originality.</span>';
$string['check_ghostwriter'] = 'Ghostwriter Detection for Large Assignments';
$string['check_ghostwriter_help'] = 'You can enable this component only after coordinating with Originality. Without prior coordination, the component will not function.';
$string['check_ghostwriter_label'] = 'Ghostwriter Detection';
$string['ghostwriter_enabled'] = 'Enable ghostwriter detection';
$string['ghostwriter_failed_message'] = 'Ghostwriter detection cannot be performed for online text.';
$string['pdf:filename'] = 'PDF';
$string['default_settings_assignments'] = 'Enable detection for new assignments';
