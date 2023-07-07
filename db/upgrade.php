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
 * plagiarism_originality upgrade
 *
 * @package    plagiarism_originality
 * @copyright  2023 mattandor <mattan@centricapp.co>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Upgrade function for the plagiarism_originality plugin.
 * This function performs the necessary database upgrades based on the old version of the plugin.
 *
 * @param int $oldversion The old version of the plugin.
 * @return bool Returns true if the upgrade is successful, false otherwise.
 */
function xmldb_plagiarism_originality_upgrade($oldversion = 0) {
    global $DB, $CFG;
    $dbman = $DB->get_manager();

    if ($oldversion < 2023070500) {

        $accesskey = get_config('plagiarism_originality', 'originality_key');
        set_config('secret', $accesskey, 'plagiarism_originality');

        // Define table plagiarism_originality_cnf.
        $table = new xmldb_table('plagiarism_originality_cnf');
        if ($dbman->table_exists($table)) {

            // Define field name to be dropped from plagiarism_originality_cnf.
            $field = new xmldb_field('name');

            // Conditionally launch drop field name.
            if ($dbman->field_exists($table, $field)) {
                $dbman->drop_field($table, $field);
            }

            // Launch rename field ischeck.
            $field = new xmldb_field('value', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, null);
            $dbman->rename_field($table, $field, 'ischeck');

            $field = new xmldb_field('ischeckgw', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, 0, 'ischeck');

            // Conditionally launch add field ischeckgw.
            if (!$dbman->field_exists($table, $field)) {
                $dbman->add_field($table, $field);
            }

            $dbman->rename_table($table, 'plagiarism_originality_mod');
        }

        // Define table originality_submissions.
        $table = new xmldb_table('originality_submissions');
        if ($dbman->table_exists($table)) {

            // Adding fields to table originality_submissions.
            $field = new xmldb_field('cm', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');

            // Conditionally launch add field cm.
            if (!$dbman->field_exists($table, $field)) {
                $dbman->add_field($table, $field);
            }

            $field = new xmldb_field('docid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');

            // Conditionally launch add field docid.
            if (!$dbman->field_exists($table, $field)) {
                $dbman->add_field($table, $field);
            }

            // Launch rename field actualuserid.
            $field = new xmldb_field('actual_userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, 0);
            $dbman->rename_field($table, $field, 'actualuserid');

            // Launch rename field fileid.
            $field = new xmldb_field('moodle_file_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, 0);
            $dbman->rename_field($table, $field, 'fileid');

            // Launch rename field filename.
            $field = new xmldb_field('file_report', XMLDB_TYPE_TEXT, 'medium', null, null, null);
            $dbman->rename_field($table, $field, 'filename');

            $dbman->rename_table($table, 'plagiarism_originality_sub');
        }

        // Define table originality_groups.
        $table = new xmldb_table('originality_groups');
        if ($dbman->table_exists($table)) {
            $dbman->rename_table($table, 'plagiarism_originality_grp');
        }

        // Define table plagiarism_originality_conf to be dropped.
        $table = new xmldb_table('plagiarism_originality_conf');

        // Conditionally launch drop table for plagiarism_originality_conf.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }

        // Originality savepoint reached.
        upgrade_plugin_savepoint(true, 2023070500, 'plagiarism', 'originality');
    }

    return true;
}
