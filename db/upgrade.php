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
 * Database upgrade steps for quizaccess_attemptpassword.
 *
 * @package    quizaccess_attemptpassword
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/**
 * Upgrade code for the quizaccess_attemptpassword plugin.
 *
 * @param int $oldversion The version we are upgrading from.
 * @return bool Always true on success.
 */
function xmldb_quizaccess_attemptpassword_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2026052400) {
        // Define table quizaccess_attemptpassword_log to be created.
        $table = new xmldb_table('quizaccess_attemptpassword_log');

        // Adding fields to table quizaccess_attemptpassword_log.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('quizid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('attemptnum', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('failedcount', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('lockouttime', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table quizaccess_attemptpassword_log.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('quizid', XMLDB_KEY_FOREIGN, ['quizid'], 'quiz', ['id']);
        $table->add_key('userid', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);

        // Adding indexes to table quizaccess_attemptpassword_log.
        $table->add_index('quiz_user_attempt_idx', XMLDB_INDEX_NOTUNIQUE, ['quizid', 'userid', 'attemptnum']);

        // Conditionally launch create table for quizaccess_attemptpassword_log.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Quizaccess savepoint reached.
        upgrade_plugin_savepoint(true, 2026052400, 'quizaccess', 'attemptpassword');
    }

    // 2026082700: Enforce one lockout-counter row per (quizid, userid, attemptnum).
    // Remove any duplicates created by historical races, then make the index UNIQUE.
    if ($oldversion < 2026082700) {
        $table = new xmldb_table('quizaccess_attemptpassword_log');

        $dupids = $DB->get_fieldset_sql("
            SELECT l.id
              FROM {quizaccess_attemptpassword_log} l
              JOIN {quizaccess_attemptpassword_log} newer
                ON newer.quizid     = l.quizid
               AND newer.userid     = l.userid
               AND newer.attemptnum = l.attemptnum
               AND newer.id > l.id
        ");
        if (!empty($dupids)) {
            foreach (array_chunk($dupids, 1000) as $chunk) {
                $DB->delete_records_list('quizaccess_attemptpassword_log', 'id', $chunk);
            }
        }

        $oldidx = new xmldb_index('quiz_user_attempt_idx', XMLDB_INDEX_NOTUNIQUE,
            ['quizid', 'userid', 'attemptnum']);
        if ($dbman->find_index_name($table, $oldidx)) {
            $dbman->drop_index($table, $oldidx);
        }

        $newidx = new xmldb_index('quiz_user_attempt_idx', XMLDB_INDEX_UNIQUE,
            ['quizid', 'userid', 'attemptnum']);
        if (!$dbman->find_index_name($table, $newidx)) {
            $dbman->add_index($table, $newidx);
        }

        // Quizaccess savepoint reached.
        upgrade_plugin_savepoint(true, 2026082700, 'quizaccess', 'attemptpassword');
    }

    return true;
}
