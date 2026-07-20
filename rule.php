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
 * Implementation of the quizaccess_attemptpassword plugin.
 *
 * @package    quizaccess_attemptpassword
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// This work-around is required until Moodle 4.2 is the lowest version we support.
if (class_exists('\mod_quiz\local\access_rule_base')) {
    // Use aliases at class_loader level to maintain compatibility.
    \class_alias('\mod_quiz\local\access_rule_base', 'quiz_access_rule_base');
    \class_alias('\mod_quiz\quiz_settings', 'quiz');
} else {
    require_once($CFG->dirroot . '/mod/quiz/accessrule/accessrulebase.php');
}

// Ensure quiz library functions are available in all Moodle versions.
require_once($CFG->dirroot . '/mod/quiz/locallib.php');

/**
 * A rule enforcing attempt-specific passwords.
 *
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class quizaccess_attemptpassword extends quiz_access_rule_base {
    /**
     * Return an appropriately configured instance of this rule, if it is applicable
     * to the given quiz, otherwise return null.
     *
     * @param quiz $quizobj information about the quiz in question.
     * @param int $timenow the time that should be considered as 'now'.
     * @param bool $canignoretimelimits whether the current user is exempt.
     * @return quiz_access_rule_base|null the rule, if applicable, else null.
     */
    public static function make(quiz $quizobj, $timenow, $canignoretimelimits) {
        if (empty($quizobj->get_quiz()->attemptpassword_passwords)) {
            return null;
        }

        return new self($quizobj, $timenow);
    }

    /**
     * Add any fields that this rule requires to the quiz settings form.
     *
     * @param \mod_quiz\form\setup $quizform the quiz settings form that is being built.
     * @param \MoodleQuickForm $mform the wrapped MoodleQuickForm.
     */
    public static function add_settings_form_fields(
        $quizform,
        \MoodleQuickForm $mform
    ) {
        $mform->addElement(
            'select',
            'attemptpassword_genmethod',
            get_string('genmethod', 'quizaccess_attemptpassword'),
            [
                'manual' => get_string('genmethod_manual', 'quizaccess_attemptpassword'),
                'random' => get_string('genmethod_random', 'quizaccess_attemptpassword'),
            ]
        );
        $mform->setDefault('attemptpassword_genmethod', 'manual');

        $mform->addElement(
            'text',
            'attemptpassword_passwords',
            get_string('attemptpassword', 'quizaccess_attemptpassword'),
            ['size' => 60, 'id' => 'id_attemptpassword_passwords']
        );
        $mform->setType('attemptpassword_passwords', PARAM_RAW);
        $mform->addHelpButton('attemptpassword_passwords', 'attemptpassword', 'quizaccess_attemptpassword');

        // Add the Copy to Clipboard button right after the text field.
        $buttonhtml = '<div class="form-group row"><div class="col-md-3"></div><div class="col-md-9">' .
            '<button type="button" class="btn btn-secondary btn-sm" id="copy-attempt-passwords-btn" onclick="' .
            'var f = document.getElementById(\'id_attemptpassword_passwords\');' .
            'if(f && f.value){' .
                'navigator.clipboard.writeText(f.value).then(function(){' .
                    'var b = document.getElementById(\'copy-attempt-passwords-btn\');' .
                    'var t = b.innerText;' .
                    'b.innerText = ' . json_encode(get_string('copied', 'quizaccess_attemptpassword')) . ';' .
                    'setTimeout(function(){ b.innerText = t; }, 2000);' .
                '});' .
            '}' .
            '">' . get_string('copytoclipboard', 'quizaccess_attemptpassword') . '</button></div></div>';
        $mform->addElement('html', $buttonhtml);
    }

    /**
     * Save any submitted settings when the quiz settings form is submitted.
     *
     * @param object $quiz the data from the quiz form.
     */
    public static function save_settings($quiz) {
        global $DB;

        $genmethod = isset($quiz->attemptpassword_genmethod) ? $quiz->attemptpassword_genmethod : 'manual';
        $passwords = isset($quiz->attemptpassword_passwords) ? trim($quiz->attemptpassword_passwords) : '';

        // If random generation method is chosen and passwords field is empty, auto-generate them.
        if ($genmethod === 'random' && empty($passwords)) {
            $numattempts = (!empty($quiz->attempts) && $quiz->attempts > 0) ? (int)$quiz->attempts : 10;
            $generated = [];
            for ($i = 0; $i < $numattempts; $i++) {
                // Use random_int() for cryptographically secure random generation.
                $generated[] = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            }
            $passwords = implode(',', $generated);
        }

        // Strip whitespace and remove any empty entries from the comma-separated list.
        if (!empty($passwords)) {
            $parts = array_filter(array_map('trim', explode(',', $passwords)));
            $passwords = implode(',', $parts);
        }

        if (empty($passwords)) {
            $DB->delete_records('quizaccess_attemptpassword', ['quizid' => $quiz->id]);
        } else {
            $record = $DB->get_record('quizaccess_attemptpassword', ['quizid' => $quiz->id]);
            if ($record) {
                $record->genmethod = $genmethod;
                $record->passwords = $passwords;
                $DB->update_record('quizaccess_attemptpassword', $record);
            } else {
                $record = new stdClass();
                $record->quizid = $quiz->id;
                $record->genmethod = $genmethod;
                $record->passwords = $passwords;
                $DB->insert_record('quizaccess_attemptpassword', $record);
            }
        }
    }

    /**
     * Validate the quiz settings form fields added by this rule.
     *
     * Warns the teacher if the number of passwords provided does not match
     * the number of allowed attempts configured for the quiz.
     *
     * @param array $errors  Existing errors array (may already contain entries).
     * @param array $data    Submitted form data.
     * @param array $files   Submitted files (unused).
     * @param object $quizform The quiz settings form object.
     * @return array Updated errors array.
     */
    public static function validate_settings_form_fields(array $errors, array $data, $files, $quizform) {
        $genmethod = isset($data['attemptpassword_genmethod']) ? $data['attemptpassword_genmethod'] : 'manual';
        $passwords = isset($data['attemptpassword_passwords']) ? trim($data['attemptpassword_passwords']) : '';

        // Only validate manual entry — random passwords are auto-generated to match.
        if ($genmethod !== 'manual' || empty($passwords)) {
            return $errors;
        }

        $parts = array_filter(array_map('trim', explode(',', $passwords)));
        $numpasswords = count($parts);

        // Retrieve the configured attempt limit (0 = unlimited).
        $maxattempts = isset($data['attempts']) ? (int) $data['attempts'] : 0;

        if ($maxattempts > 0 && $numpasswords !== $maxattempts) {
            $errors['attemptpassword_passwords'] = get_string(
                'passwordcountmismatch',
                'quizaccess_attemptpassword',
                ['passwords' => $numpasswords, 'attempts' => $maxattempts]
            );
        }

        return $errors;
    }

    /**
     * Delete any rule-specific settings when the quiz is deleted.
     *
     * @param object $quiz the data from the database.
     */
    public static function delete_settings($quiz) {
        global $DB;
        $DB->delete_records('quizaccess_attemptpassword', ['quizid' => $quiz->id]);
    }

    /**
     * Return the bits of SQL needed to load all the settings from the DB.
     *
     * @param int $quizid the id of the quiz we are loading settings for.
     * @return array SQL query fragments.
     */
    public static function get_settings_sql($quizid) {
        return [
            'attpass.genmethod AS attemptpassword_genmethod, attpass.passwords AS attemptpassword_passwords',
            'LEFT JOIN {quizaccess_attemptpassword} attpass ON attpass.quizid = quiz.id',
            [],
        ];
    }

    /**
     * Determine the current attempt number for the user.
     *
     * @param int|null $attemptid
     * @return int
     */
    protected function get_attempt_number($attemptid) {
        global $USER, $DB;
        if ($attemptid) {
            $attempt = $DB->get_record('quiz_attempts', ['id' => $attemptid]);
            if ($attempt) {
                return (int)$attempt->attempt;
            }
        }

        // Calculate next attempt number based on existing user attempts.
        $attempts = quiz_get_user_attempts($this->quiz->id, $USER->id, 'all', true);
        $lastattempt = end($attempts);
        if ($lastattempt) {
            return (int)$lastattempt->attempt + 1;
        }

        return 1;
    }

    /**
     * Whether or not a user should be allowed to start a new attempt at this quiz now.
     *
     * @param int $numprevattempts the number of previous attempts this user has made.
     * @param object $lastattempt information about the user's last completed attempt.
     * @return string|false false if access should be allowed, a message explaining the
     * reason if access should be prevented.
     */
    public function prevent_new_attempt($numprevattempts, $lastattempt) {
        global $DB, $USER;

        if (empty($this->quiz->attemptpassword_passwords)) {
            return false;
        }

        $attemptnum = $this->get_attempt_number($lastattempt ? $lastattempt->id : null);
        $record = $DB->get_record('quizaccess_attemptpassword_log', [
            'quizid' => $this->quiz->id,
            'userid' => $USER->id,
            'attemptnum' => $attemptnum,
        ]);

        if ($record && $record->lockouttime > time()) {
            $minutes = ceil(($record->lockouttime - time()) / 60);
            return get_string('lockoutmessage', 'quizaccess_attemptpassword', $minutes);
        }

        return false;
    }

    /**
     * Whether or not the user needs to do a preflight check before starting this attempt.
     *
     * @param int|null $attemptid
     * @return bool
     */
    public function is_preflight_check_required($attemptid) {
        if (empty($this->quiz->attemptpassword_passwords)) {
            return false;
        }

        $attemptnum = $this->get_attempt_number($attemptid);

        $passwords = explode(',', $this->quiz->attemptpassword_passwords);
        $index = $attemptnum - 1;
        if (!isset($passwords[$index]) || trim($passwords[$index]) === '') {
            return false;
        }

        global $SESSION;
        $sesskey = 'quizaccess_attemptpassword_' . $this->quiz->id . '_attempt_' . $attemptnum;
        if (!empty($SESSION->$sesskey)) {
            return false;
        }

        return true;
    }

    /**
     * Add any fields required by this rule to the preflight check form.
     *
     * @param \mod_quiz\form\preflight_check $quizform
     * @param \MoodleQuickForm $mform
     * @param int|null $attemptid
     */
    public function add_preflight_check_form_fields($quizform, \MoodleQuickForm $mform, $attemptid) {
        $attemptnum = $this->get_attempt_number($attemptid);

        $mform->addElement(
            'passwordunmask',
            'attemptpassword_entry',
            get_string('enterpasswordforattempt', 'quizaccess_attemptpassword', $attemptnum)
        );
        $mform->setType('attemptpassword_entry', PARAM_RAW);
    }

    /**
     * Validate the preflight check form submission.
     *
     * @param array $data
     * @param array $files
     * @param array $errors
     * @param int|null $attemptid
     * @return array
     */
    public function validate_preflight_check($data, $files, $errors, $attemptid) {
        global $DB, $USER;
        $attemptnum = $this->get_attempt_number($attemptid);

        $passwords = explode(',', $this->quiz->attemptpassword_passwords);
        $index = $attemptnum - 1;
        $expected = isset($passwords[$index]) ? trim($passwords[$index]) : '';

        $entered = isset($data['attemptpassword_entry']) ? trim($data['attemptpassword_entry']) : '';

        if ($expected !== '') {
            if ($entered !== $expected) {
                // Wrong password - increment failed count and trigger lockout if reached.
                $record = $DB->get_record('quizaccess_attemptpassword_log', [
                    'quizid' => $this->quiz->id,
                    'userid' => $USER->id,
                    'attemptnum' => $attemptnum,
                ]);

                if ($record) {
                    $record->failedcount++;
                    if ($record->failedcount >= 5) {
                        $record->lockouttime = time() + 300; // 5 minutes lockout
                    }
                    $DB->update_record('quizaccess_attemptpassword_log', $record);
                    $failedcount = $record->failedcount;
                } else {
                    $record = new \stdClass();
                    $record->quizid = $this->quiz->id;
                    $record->userid = $USER->id;
                    $record->attemptnum = $attemptnum;
                    $record->failedcount = 1;
                    $record->lockouttime = 0;
                    $DB->insert_record('quizaccess_attemptpassword_log', $record);
                    $failedcount = 1;
                }

                // Log failed security event.
                $event = \quizaccess_attemptpassword\event\password_failed::create([
                    'context' => \context_module::instance($this->quizobj->get_cmid()),
                    'objectid' => $this->quizobj->get_quizid(),
                    'relateduserid' => $USER->id,
                    'other' => [
                        'attemptnum' => $attemptnum,
                        'failedcount' => $failedcount,
                    ],
                ]);
                $event->trigger();

                if ($failedcount >= 5) {
                    $errors['attemptpassword_entry'] = get_string('lockoutmessage', 'quizaccess_attemptpassword', 5);
                } else {
                    $errors['attemptpassword_entry'] = get_string('wrongpassword', 'quizaccess_attemptpassword') . ' ' .
                        get_string('lockoutwarning', 'quizaccess_attemptpassword', ['failed' => $failedcount, 'max' => 5]);
                }
            } else {
                // Correct password - clear log and trigger verified event.
                $DB->delete_records('quizaccess_attemptpassword_log', [
                    'quizid' => $this->quiz->id,
                    'userid' => $USER->id,
                    'attemptnum' => $attemptnum,
                ]);

                $event = \quizaccess_attemptpassword\event\password_verified::create([
                    'context' => \context_module::instance($this->quizobj->get_cmid()),
                    'objectid' => $this->quizobj->get_quizid(),
                    'relateduserid' => $USER->id,
                    'other' => [
                        'attemptnum' => $attemptnum,
                    ],
                ]);
                $event->trigger();

                // Mark session key as passed on successful validation.
                global $SESSION;
                $sesskey = 'quizaccess_attemptpassword_' . $this->quiz->id . '_attempt_' . $attemptnum;
                $SESSION->$sesskey = true;
            }
        }

        return $errors;
    }

    /**
     * Notify the rule that the preflight check has passed.
     *
     * @param int|null $attemptid
     */
    public function notify_preflight_check_passed($attemptid) {
        global $SESSION, $DB, $USER;
        $attemptnum = $this->get_attempt_number($attemptid);
        $sesskey = 'quizaccess_attemptpassword_' . $this->quiz->id . '_attempt_' . $attemptnum;
        $SESSION->$sesskey = true;

        // Also clear failed password attempts for safety.
        $DB->delete_records('quizaccess_attemptpass_log', [
            'quizid' => $this->quiz->id,
            'userid' => $USER->id,
            'attemptnum' => $attemptnum,
        ]);
    }
}
