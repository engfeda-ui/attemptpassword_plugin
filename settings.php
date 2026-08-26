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
 * Admin settings for the quizaccess_attemptpassword plugin.
 *
 * @package    quizaccess_attemptpassword
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_heading(
        'quizaccess_attemptpassword/settings',
        get_string('settingsheader', 'quizaccess_attemptpassword'),
        ''
    ));

    $settings->add(new admin_setting_configtext(
        'quizaccess_attemptpassword/maxfailedattempts',
        get_string('maxfailedattempts', 'quizaccess_attemptpassword'),
        get_string('maxfailedattempts_desc', 'quizaccess_attemptpassword'),
        5,
        PARAM_INT
    ));

    $settings->add(new admin_setting_configtext(
        'quizaccess_attemptpassword/lockoutduration',
        get_string('lockoutduration', 'quizaccess_attemptpassword'),
        get_string('lockoutduration_desc', 'quizaccess_attemptpassword'),
        300,
        PARAM_INT
    ));
}
