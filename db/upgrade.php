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
 * @param int $oldversion The old version of the plugin.
 * @return bool Returns true if the upgrade is successful, false otherwise.
 */
function xmldb_plagiarism_originality_upgrade($oldversion = 0) {
    global $DB, $CFG;
    $dbman = $DB->get_manager();

    if ($oldversion < 2023051500) {

        // Define table plagiarism_originality_mod to be created.
        $table = new xmldb_table('plagiarism_originality_mod');
        if ($dbman->table_exists($table)) {
            $dbman->rename_table($table, 'plagiarism_originality_mod_old');
        }

        // Adding fields to table plagiarism_originality_mod.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('cm', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('ischeck', XMLDB_TYPE_INTEGER, '2', null, null, null, '0');
        $table->add_field('ischeckgw', XMLDB_TYPE_INTEGER, '2', null, null, null, '0');

        // Adding keys to table plagiarism_originality_mod.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('cm', XMLDB_KEY_FOREIGN, ['cm'], 'course_modules', ['id']);

        // Conditionally launch create table for plagiarism_originality_mod.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table plagiarism_orginality_sub to be created.
        $table = new xmldb_table('originality_submissions');
        if ($dbman->table_exists($table)) {
            $dbman->rename_table($table, 'originality_submissions_old');
        }

        // Adding fields to table originality_submissions.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('assignment', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('actual_userid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('docid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('ghostwriter', XMLDB_TYPE_INTEGER, '2', null, null, null, '0');
        $table->add_field('file', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('file_report', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('moodle_file_id', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('status', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('grade', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('attempts', XMLDB_TYPE_INTEGER, '5', null, null, null, '0');
        $table->add_field('created', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('updated', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('objectid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('parent', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');

        // Adding keys to table originality_submissions.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for originality_submissions.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table originality_groups to be created.
        $table = new xmldb_table('originality_groups');
        if ($dbman->table_exists($table)) {
            $dbman->rename_table($table, 'originality_groups_old');
        }

        // Adding fields to table originality_groups.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('assignment', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('groupid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('token', XMLDB_TYPE_CHAR, '255', null, null, null, null);

        // Adding keys to table originality_groups.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for originality_groups.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Originality savepoint reached.
        upgrade_plugin_savepoint(true, 2023051500, 'plagiarism', 'originality');
    }

    return true;
}
