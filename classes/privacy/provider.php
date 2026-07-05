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
 * Privacy Subsystem implementation for quizaccess_attemptpassword.
 *
 * @package    quizaccess_attemptpassword
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace quizaccess_attemptpassword\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\userlist;
use core_privacy\local\request\approved_userlist;

/**
 * Privacy Subsystem implementation for quizaccess_attemptpassword.
 *
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\core_userlist_provider,
    \core_privacy\local\request\plugin\provider {
    /**
     * Returns meta data about this system.
     *
     * @param collection $items The set of items to be added to.
     * @return collection The updated set of items.
     */
    public static function get_metadata(collection $items): collection {
        $items->add_database_table(
            'quizaccess_attemptpass_log',
            [
                'quizid'      => 'privacy:metadata:quizid',
                'userid'      => 'privacy:metadata:userid',
                'attemptnum'  => 'privacy:metadata:attemptnum',
                'failedcount' => 'privacy:metadata:failedcount',
                'lockouttime' => 'privacy:metadata:lockouttime',
            ],
            'privacy:metadata:quizaccess_attemptpass_log'
        );

        return $items;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param int $userid The user to search.
     * @return contextlist The contextlist containing the list of contexts used by this user.
     */
    public static function get_contexts_for_userid(int $userid): contextlist {
        $contextlist = new contextlist();

        $sql = "SELECT c.id
                  FROM {context} c
                  JOIN {course_modules} cm ON cm.id = c.instanceid AND c.contextlevel = :contextlevel
                  JOIN {modules} m ON m.id = cm.module AND m.name = :modname
                  JOIN {quiz} q ON q.id = cm.instance
                  JOIN {quizaccess_attemptpass_log} log ON log.quizid = q.id
                 WHERE log.userid = :userid";

        $params = [
            'contextlevel' => CONTEXT_MODULE,
            'modname'      => 'quiz',
            'userid'       => $userid,
        ];

        $contextlist->add_from_sql($sql, $params);

        return $contextlist;
    }

    /**
     * Export all user data for the specified number of contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to export information for.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;

        $userid = $contextlist->get_user()->id;

        foreach ($contextlist as $context) {
            if ($context->contextlevel != CONTEXT_MODULE) {
                continue;
            }

            $cm = get_coursemodule_from_id('quiz', $context->instanceid);
            if (!$cm) {
                continue;
            }

            $logs = $DB->get_records('quizaccess_attemptpass_log', [
                'quizid' => $cm->instance,
                'userid' => $userid,
            ]);

            if ($logs) {
                $data = [];
                foreach ($logs as $log) {
                    $data[] = [
                        'attemptnum'  => $log->attemptnum,
                        'failedcount' => $log->failedcount,
                        'lockouttime' => $log->lockouttime ? userdate($log->lockouttime) : null,
                    ];
                }
                \core_privacy\local\request\writer::with_context($context)
                    ->export_data([get_string('pluginname', 'quizaccess_attemptpassword')], (object) ['logs' => $data]);
            }
        }
    }

    /**
     * Delete all data for all users in the specified context.
     *
     * @param \context $context The specific context to delete data for.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        global $DB;

        if ($context->contextlevel != CONTEXT_MODULE) {
            return;
        }

        $cm = get_coursemodule_from_id('quiz', $context->instanceid);
        if (!$cm) {
            return;
        }

        $DB->delete_records('quizaccess_attemptpass_log', ['quizid' => $cm->instance]);
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts and user information to delete.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;

        $userid = $contextlist->get_user()->id;

        foreach ($contextlist as $context) {
            if ($context->contextlevel != CONTEXT_MODULE) {
                continue;
            }

            $cm = get_coursemodule_from_id('quiz', $context->instanceid);
            if (!$cm) {
                continue;
            }

            $DB->delete_records('quizaccess_attemptpass_log', [
                'quizid' => $cm->instance,
                'userid' => $userid,
            ]);
        }
    }

    /**
     * Get the list of users who have data within a given context.
     *
     * @param userlist $userlist The userlist to add the users to.
     */
    public static function get_users_in_context(userlist $userlist) {
        $context = $userlist->get_context();

        if ($context->contextlevel != CONTEXT_MODULE) {
            return;
        }

        $cm = get_coursemodule_from_id('quiz', $context->instanceid);
        if (!$cm) {
            return;
        }

        $sql = "SELECT userid
                  FROM {quizaccess_attemptpass_log}
                 WHERE quizid = :quizid";

        $userlist->add_from_sql('userid', $sql, ['quizid' => $cm->instance]);
    }

    /**
     * Delete multiple users within a single context.
     *
     * @param approved_userlist $userlist The approved context and user information to delete information for.
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
        global $DB;

        $context = $userlist->get_context();

        if ($context->contextlevel != CONTEXT_MODULE) {
            return;
        }

        $cm = get_coursemodule_from_id('quiz', $context->instanceid);
        if (!$cm) {
            return;
        }

        $userids = $userlist->get_userids();
        [$insql, $inparams] = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);

        $params = array_merge(['quizid' => $cm->instance], $inparams);
        $DB->delete_records_select('quizaccess_attemptpass_log', "quizid = :quizid AND userid {$insql}", $params);
    }
}
