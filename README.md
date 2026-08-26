# 🔑 Moodle Quiz Access Rule: Attempt Password (`quizaccess_attemptpassword`)

[![Moodle Compatibility](https://img.shields.io/badge/Moodle-4.0%20to%205.0%2B-orange.svg?style=flat-square)](https://moodle.org)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%20%7C%208.2%20%7C%208.3-blue.svg?style=flat-square)](https://php.net)
[![Database](https://img.shields.io/badge/Database-PostgreSQL%20%7C%20MySQL%20%7C%20MariaDB-purple.svg?style=flat-square)](https://docs.moodle.org)
[![License](https://img.shields.io/badge/License-GPL%20v3-green.svg?style=flat-square)](http://www.gnu.org/copyleft/gpl.html)
[![Version](https://img.shields.io/badge/Version-v1.3.5-blue.svg?style=flat-square)](https://github.com/engfeda-ui/attemptpassword_plugin)

A professional Moodle quiz access rule plugin that gives course teachers granular control over quiz security by enabling unique, attempt-specific passwords.

When quizzes allow multiple attempts, students who fail and are granted a reattempt cannot reuse the password from their previous attempt, securing academic integrity for high-stakes assessments.

---

## ✨ Features

- **Granular Attempt Control:** Configure different passwords for each distinct quiz attempt.
- **Flexible Password Generation Methods:**
  - **Manual Entry:** Set custom passwords for each attempt separated by commas (e.g., `pass1,pass2,pass3`).
  - **Automatic Generation:** Automatically generate cryptographically secure 4-digit numeric passwords for each attempt upon saving the quiz settings.
- **Password Count Validation (NEW in v1.1.0):** When using manual entry, the quiz settings form now warns the teacher if the number of passwords entered does not match the number of allowed attempts — preventing silent mismatches that would leave students locked out.
- **Enterprise-Ready Integrations:**
  - **Privacy Subsystem (GDPR):** Full compliance with Moodle's privacy API.
  - **Backup & Restore:** Seamlessly backs up and restores attempt passwords across courses and sites.
  - **Preflight Check Integration:** Integrates natively with Moodle's quiz access control UI.
- **Localization Support:** English and Arabic (`ar`) language packs included.
- **Rigorous Testing:** Includes robust PHPUnit test coverage for core attempt-logic verification.
- **CI/CD Ready:** Automated GitHub Actions workflows for continuous integration testing.

---

## 📋 Requirements

| Dependency | Required Version / Compatibility |
| :--- | :--- |
| **Moodle Framework** | Moodle 4.0 to 5.0+ (Tested against Moodle 4.5/5.0+ stable branches) |
| **PHP Runtime** | PHP 8.1, PHP 8.2, PHP 8.3 |
| **Database System** | PostgreSQL 13+, MySQL 8.0+, or MariaDB 10.5+ |

---

## 🚀 Installation

1. **Download & Extract:** Download the repository and extract the files.
2. **Directory Placement:** Copy the `attemptpassword` folder into your Moodle installation's quiz access rules directory:
   ```
   moodle/mod/quiz/accessrule/attemptpassword
   ```
3. **Run Moodle Upgrade:** Log in as Administrator and navigate to **Site administration > Notifications** to trigger the database upgrade.
4. **Alternative Install:** Zip the directory and upload via **Site administration > Plugins > Install plugins**.

---

## 🛠️ Usage & Configuration

1. Navigate to your course and open a **Quiz** (or create a new one).
2. Go to **Quiz Settings > Extra restrictions on attempts**.
3. Under **Attempt Password settings**:
   - **Generation Mode:** Choose **Manual entry** or **Auto-generate secure numeric passwords**.
   - **Manual Passwords:** Enter a comma-separated list of passwords — one per attempt (e.g., `pass1,pass2,pass3`).
   - If the number of passwords does not match the number of allowed attempts, a warning is shown before saving.
4. Save the quiz settings. Students will be prompted for the specific password for their current attempt number before launching the quiz.

> **Tip:** Use **Auto-generate** when you want Moodle to create unique 4-digit passwords automatically. The generated passwords are shown in the field after saving, so you can copy and distribute them.

---

## 📋 Changelog

### v1.3.5 — 2026-08-26
- **New:** Brute-force lockout policy is now admin-configurable via **Site administration > Plugins > Quiz access rules > Attempt password**: maximum failed attempts (default 5) and lockout duration in seconds (default 300). Previously both values were hardcoded.

### v1.3.4 — 2026-08-26
- **Fix (Critical):** Corrected leftover wrong table name `quizaccess_attemptpass_log` in `notify_preflight_check_passed()` (`rule.php`) to `quizaccess_attemptpassword_log` — remnant of the v1.2.2 table rename that caused a DML "table not found" exception on every passed preflight check.

### v1.3.3 — 2026-08-24
- **Documentation:** Updated documentation to reflect Arabic language localization support.

### v1.3.2 — 2026-08-24
- **CI/CD:** Streamlined deployment pipeline directly to Production environment and removed deprecated staging branch/configuration.

### v1.3.1 — 2026-08-24
- **Maintenance:** Added standard `.gitignore` and `.gitattributes` for repository hygiene and unified LF line endings.
- **Security:** Excluded local agent instruction files from git tracking.
- **CI/CD:** Enhanced dual-environment deployment workflow with flexible staging host configuration.

### v1.3.0 — 2026-07-24
- **Release:** Standardized frankenstyle component name to `quizaccess_attemptpassword` installed under `mod/quiz/accessrule/attemptpassword`.

### v1.2.2 — 2026-07-20
- **Fix:** Renamed database table to `quizaccess_attemptpassword_log` to satisfy `moodle-plugin-ci` validation rules requiring full component prefix.

### v1.2.1 — 2026-07-05
- **Fix:** Implemented the full GDPR Privacy Provider (`classes/privacy/provider.php`) and Userlist Provider (`core_userlist_provider`) to correctly document the `quizaccess_attemptpassword_log` table, resolving Moodle core PHPUnit test failures.
- **Fix:** Added missing metadata strings to the English language pack.

### v1.2.0 — 2026-05-25
- **New:** Failed Password Attempts Lockout Protection (Brute Force Prevention) — blocks user for 5 minutes after 5 consecutive incorrect attempts.
- **New:** Audit logs and security events — fires `\quizaccess_attemptpassword\event\password_failed` and `\quizaccess_attemptpassword\event\password_verified` to Moodle's standard log store to track who entered incorrect passwords and how many times.
- **New:** "Copy to Clipboard" button in quiz settings page for easy distribution of auto-generated passwords.
- **New:** Database table `quizaccess_attemptpassword_log` to securely store failed counts and lockout timestamps on the server side (immune to private browsing or cookie clearing).

### v1.1.0 — 2026-05-19
- **New:** `validate_settings_form_fields()` — warns the teacher when the number of manually entered passwords does not match the number of allowed quiz attempts.
- **Fix:** Corrected `requires` and `supported` version range to accurately reflect Moodle 4.0+ compatibility (was incorrectly set to 3.9).
- **New:** Added `passwordcountmismatch` language string with a clear, actionable error message.

### v1.0.1 — 2026-05-15
- Initial stable release.
- Manual and auto-generate password modes.
- Cryptographically secure password generation via `random_int()`.
- Session-based preflight check to avoid re-entering passwords in the same session.

---

## 💻 Directory Structure

```
attemptpassword/
├── classes/
│   └── privacy/            # GDPR Privacy provider
├── db/
│   └── install.xml         # Database schema
├── lang/
│   └── en/                 # English language strings
├── tests/                  # PHPUnit test suites
├── .github/                # GitHub Actions CI workflows
├── rule.php                # Main access rule class
├── version.php             # Plugin version and metadata
└── README.md
```

---

## 🔒 Security & Code Compliance

- **SQL Injection Prevention:** All queries use Moodle's `$DB` API with named parameter bindings.
- **Input Sanitization:** All input retrieved via `required_param()` / `optional_param()` with strict type filters.
- **Cryptographic Security:** Password auto-generation uses `random_int()` — not `rand()` or `mt_rand()`.
- **Capability Controls:** Access points enforce `require_login()` and `require_capability()`.
- **Coding Standards:** Compliant with Moodle's `PHP_CodeSniffer` (PHPCS) ruleset.

---

## 📄 License & Credits

- **Copyright:** © 2026 Mahmoud Salem
- **License:** [GNU GPL v3](http://www.gnu.org/copyleft/gpl.html) or later.


