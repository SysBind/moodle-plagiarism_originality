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
 * plagiarism_originality services
 *
 * @package    plagiarism_originality
 * @copyright  2023 mattandor <mattan@centricapp.co>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$services = array(
        'Originality Service' => array(
                'shortname' => 'plagiarism_originality_service',
                'functions' => array(
                        'plagiarism_originality_external_create_report',
                ),
                'restrictedusers' => 0,
                'enabled' => 1,
        )
);

$functions = array(
        'plagiarism_originality_external_create_report' => array(
                'classname' => 'plagiarism_originality_external',
                'methodname' => 'create_report',
                'description' => 'Create a new report for user.',
                'type' => 'write',
        )
);
