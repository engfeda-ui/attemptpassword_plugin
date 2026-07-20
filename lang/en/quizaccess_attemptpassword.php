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
 * Strings for the quizaccess_attemptpassword plugin.
 *
 * @package    quizaccess_attemptpassword
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Attempt password';
$string['privacy:metadata'] = 'The Attempt password plugin stores quiz settings and failed attempt lockout logs.';
$string['privacy:metadata:quizid'] = 'The ID of the quiz associated with the log entry.';
$string['privacy:metadata:userid'] = 'The ID of the user who made the attempt.';
$string['privacy:metadata:attemptnum'] = 'The attempt number on the quiz.';
$string['privacy:metadata:failedcount'] = 'The count of failed password entry attempts.';
$string['privacy:metadata:lockouttime'] = 'The time when the lockout expires.';
$string['privacy:metadata:quizaccess_attemptpassword_log'] = 'Database table storing the user failed attempts and lockout timers.';

$string['genmethod'] = 'Password generation method';
$string['genmethod_manual'] = 'Manual entry (comma-separated)';
$string['genmethod_random'] = 'Auto-generate random 4-digit passwords';

$string['attemptpassword'] = 'Attempt passwords';
$string['attemptpassword_help'] = 'For manual entry, enter passwords separated by commas (e.g. pass1,pass2,pass3). If auto-generated, random 4-digit passwords will be created and displayed here upon saving.';

$string['enterpasswordforattempt'] = 'To start Attempt {$a}, please enter the password for this specific attempt:';
$string['wrongpassword'] = 'The password you entered is incorrect for this attempt.';
$string['passwordcountmismatch'] = 'Warning: you have entered {$a->passwords} password(s) but the quiz allows {$a->attempts} attempt(s). Each attempt needs its own password. Please add or remove passwords to match the number of allowed attempts.';
$string['event_password_failed'] = 'Quiz password entry failed';
$string['event_password_verified'] = 'Quiz password entry verified';
$string['lockoutmessage'] = 'Too many failed password attempts. You have been locked out for {$a} minutes. Please try again later.';
$string['lockoutwarning'] = 'Caution: you have entered an incorrect password {$a->failed} times out of {$a->max}. After {$a->max} incorrect entries, you will be locked out for 5 minutes.';
$string['copytoclipboard'] = 'Copy Passwords to Clipboard';
$string['copied'] = 'Copied!';
