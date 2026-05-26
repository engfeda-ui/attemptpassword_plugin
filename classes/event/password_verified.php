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

namespace quizaccess_attemptpassword\event;

defined('MOODLE_INTERNAL') || die();

/**
 * Event fired when a user successfully enters an attempt-specific password.
 *
 * @package    quizaccess_attemptpassword
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class password_verified extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'quiz';
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        $attemptnum = isset($this->other['attemptnum']) ? $this->other['attemptnum'] : 1;
        return "The user with id '{$this->userid}' successfully verified the password for quiz with id '{$this->objectid}' for attempt number '{$attemptnum}'.";
    }

    /**
     * Return legacy event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('event_password_verified', 'quizaccess_attemptpassword');
    }
}
