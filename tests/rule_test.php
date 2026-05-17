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
 * Unit tests for the quizaccess_attemptpassword plugin.
 *
 * @package    quizaccess_attemptpassword
  * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace quizaccess_attemptpassword;

use advanced_testcase;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/mod/quiz/accessrule/attemptpassword/rule.php');

/**
 * Unit tests for the quizaccess_attemptpassword plugin.
 *
  * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class rule_test extends advanced_testcase {
    public function test_rule_creation_and_validation() {
        global $CFG;

        $this->resetAfterTest();

        // Setup course and user.
        $generator = $this->getDataGenerator();
        $course = $generator->create_course();
        $user = $generator->create_user();
        $this->setUser($user);

        $quizgenerator = $generator->get_plugin_generator('mod_quiz');

        // Test 1: Rule not applied if passwords string is empty.
        $quiz = $quizgenerator->create_instance([
            'course' => $course->id,
            'attempts' => 3,
            'attemptpassword_passwords' => '',
        ]);
        $quizobj = \quiz::create($quiz->id, $user->id);

        $rule = \quizaccess_attemptpassword::make($quizobj, 0, false);
        $this->assertNull($rule);

        // Test 2: Rule applied if passwords are provided.
        $quiz = $quizgenerator->create_instance([
            'course' => $course->id,
            'attempts' => 3,
            'attemptpassword_passwords' => 'pass1,pass2,pass3',
        ]);
        $quizobj = \quiz::create($quiz->id, $user->id);

        $rule = \quizaccess_attemptpassword::make($quizobj, 0, false);
        $this->assertInstanceOf(\quizaccess_attemptpassword::class, $rule);

        // Validate preflight check for Attempt 1.
        $errors = $rule->validate_preflight_check(['attemptpassword_entry' => 'wrong'], [], [], null);
        $this->assertArrayHasKey('attemptpassword_entry', $errors);

        $errors = $rule->validate_preflight_check(['attemptpassword_entry' => 'pass1'], [], [], null);
        $this->assertArrayNotHasKey('attemptpassword_entry', $errors);
    }
}
