# 🔑 Moodle Quiz Access Rule: Attempt Password (`quizaccess_attemptpassword`)

[![Moodle Compatibility](https://img.shields.io/badge/Moodle-3.9%20to%205.0%2B-orange.svg?style=flat-square)](https://moodle.org)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%20%7C%208.2%20%7C%208.3-blue.svg?style=flat-square)](https://php.net)
[![Database](https://img.shields.io/badge/Database-PostgreSQL%20%7C%20MySQL%20%7C%20MariaDB-purple.svg?style=flat-square)](https://docs.moodle.org)
[![License](https://img.shields.io/badge/License-GPL%20v3-green.svg?style=flat-square)](http://www.gnu.org/copyleft/gpl.html)

A professional Moodle quiz access rule plugin that gives course teachers granular control over quiz security by enabling unique, attempt-specific passwords. 

When quizzes allow multiple attempts, students who fail and are granted a reattempt cannot reuse the password from their previous attempt, securing academic integrity for high-stakes assessments.

---

## ✨ Features

- **Granular Attempt Control:** Configure different passwords for each distinct quiz attempt.
- **Flexible Password Generation Methods:**
  - **Manual Entry:** Set custom passwords for each attempt separated by commas (e.g., `pass1,pass2,pass3`).
  - **Automatic Generation:** Automatically generate highly secure, unique 4-digit numeric passwords for each attempt upon saving the quiz settings.
- **Enterprise-Ready Integrations:**
  - **Privacy Subsystem (GDPR):** Full compliance with Moodle's privacy API.
  - **Backup & Restore:** Seamlessly backs up and restores attempt passwords across courses and sites.
  - **Preflight Check Integration:** Integrates natively with Moodle's quiz access control UI.
- **Rigorous Testing:** Includes robust PHPUnit test coverage for core attempt-logic verification.
- **CI/CD Ready:** Automated GitHub Actions workflows for continuous integration testing.

---

## 📋 Requirements

| Dependency | Required Version / Compatibility |
| :--- | :--- |
| **Moodle Framework** | Moodle 3.9 to 5.0+ (Tested against Moodle 4.5/5.0+ stable branches) |
| **PHP Runtime** | PHP 8.1, PHP 8.2, PHP 8.3 |
| **Database System** | PostgreSQL 13+, MySQL 8.0+, or MariaDB 10.5+ |

---

## 🚀 Installation

Follow these steps to install the plugin manually:

1. **Download & Extract:** Download the repository and extract the files.
2. **Directory Placement:** Copy the `attemptpassword` folder into your Moodle installation's quiz access rules directory:
   ```bash
   moodle/mod/quiz/accessrule/attemptpassword
   ```
3. **Run Moodle Upgrade:** Log in to your Moodle site as an Administrator and navigate to **Site administration > Notifications** to trigger the database upgrade and complete the installation.
4. **Alternative Install:** Alternatively, zip the directory and upload it via **Site administration > Plugins > Install plugins**.

---

## 🛠️ Usage & Configuration

Once installed, the plugin can be configured on a per-quiz basis:

1. Navigate to your course and select a **Quiz** (or create a new one).
2. Go to **Quiz Settings > Extra restrictions on attempts**.
3. Under the **Attempt Password settings**:
   - **Enable attempt passwords:** Toggle this setting to activate the rule.
   - **Generation Mode:** Choose between **Manual entry** or **Auto-generate secure numeric passwords**.
   - **Manual Passwords:** If manual is selected, input a comma-separated list of passwords corresponding to attempt 1, 2, 3, etc.
4. Save the quiz settings. Students will now be prompted for the specific password associated with their current attempt number before launching the quiz!

---

## 💻 Directory Structure

```text
attemptpassword/
├── classes/                # Autoloaded classes (Access rule logic)
│   └── privacy/            # GDPR Privacy provider implementation
├── db/                     # Database definitions (install.xml, access.php, tasks.php)
├── lang/                   # Language localization packs
│   ├── en/                 # English translations
│   └── tr/                 # Turkish translations
├── tests/                  # Automated test suites (PHPUnit)
├── .github/                # GitHub Action workflows
├── version.php             # Moodle plugin version and dependency definition
└── README.md               # Professional documentation
```

---

## 🔒 Security & Privacy (GDPR)

This plugin fully supports Moodle's Privacy Subsystem:
- It exports student attempt metadata in compliance with GDPR requests.
- It handles the safe deletion of user data upon request.
- Passwords are encrypted/stored securely in compliance with standard database practices.

---

## 🧪 Development & Testing

We maintain high code quality standards. Run automated tests using Moodle's PHPUnit framework:

```bash
# Initialize PHPUnit environment
php admin/tool/phpunit/cli/init.php

# Run tests for this plugin
vendor/bin/phpunit --group quizaccess_attemptpassword
```

---

## ðŸ”’ Security & Code Compliance

This plugin has been audited and hardened according to Moodle's strict security and quality guidelines:

- **CSRF Protection:** Standard Moodle session key verification (equire_sesskey()) is enforced on all state-mutating actions (such as queueing calculations).
- **SQL Injection Prevention:** Every query utilizes Moodle's Database API ($DB) with parameter bindings and named placeholders (:named), completely avoiding raw SQL interpolation and protecting against injection attacks.
- **Input Sanitization:** Direct superglobals (# 🔑 Moodle Quiz Access Rule: Attempt Password (`quizaccess_attemptpassword`)

[![Moodle Compatibility](https://img.shields.io/badge/Moodle-3.9%20to%205.0%2B-orange.svg?style=flat-square)](https://moodle.org)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%20%7C%208.2%20%7C%208.3-blue.svg?style=flat-square)](https://php.net)
[![Database](https://img.shields.io/badge/Database-PostgreSQL%20%7C%20MySQL%20%7C%20MariaDB-purple.svg?style=flat-square)](https://docs.moodle.org)
[![License](https://img.shields.io/badge/License-GPL%20v3-green.svg?style=flat-square)](http://www.gnu.org/copyleft/gpl.html)

A professional Moodle quiz access rule plugin that gives course teachers granular control over quiz security by enabling unique, attempt-specific passwords. 

When quizzes allow multiple attempts, students who fail and are granted a reattempt cannot reuse the password from their previous attempt, securing academic integrity for high-stakes assessments.

---

## ✨ Features

- **Granular Attempt Control:** Configure different passwords for each distinct quiz attempt.
- **Flexible Password Generation Methods:**
  - **Manual Entry:** Set custom passwords for each attempt separated by commas (e.g., `pass1,pass2,pass3`).
  - **Automatic Generation:** Automatically generate highly secure, unique 4-digit numeric passwords for each attempt upon saving the quiz settings.
- **Enterprise-Ready Integrations:**
  - **Privacy Subsystem (GDPR):** Full compliance with Moodle's privacy API.
  - **Backup & Restore:** Seamlessly backs up and restores attempt passwords across courses and sites.
  - **Preflight Check Integration:** Integrates natively with Moodle's quiz access control UI.
- **Rigorous Testing:** Includes robust PHPUnit test coverage for core attempt-logic verification.
- **CI/CD Ready:** Automated GitHub Actions workflows for continuous integration testing.

---

## 📋 Requirements

| Dependency | Required Version / Compatibility |
| :--- | :--- |
| **Moodle Framework** | Moodle 3.9 to 5.0+ (Tested against Moodle 4.5/5.0+ stable branches) |
| **PHP Runtime** | PHP 8.1, PHP 8.2, PHP 8.3 |
| **Database System** | PostgreSQL 13+, MySQL 8.0+, or MariaDB 10.5+ |

---

## 🚀 Installation

Follow these steps to install the plugin manually:

1. **Download & Extract:** Download the repository and extract the files.
2. **Directory Placement:** Copy the `attemptpassword` folder into your Moodle installation's quiz access rules directory:
   ```bash
   moodle/mod/quiz/accessrule/attemptpassword
   ```
3. **Run Moodle Upgrade:** Log in to your Moodle site as an Administrator and navigate to **Site administration > Notifications** to trigger the database upgrade and complete the installation.
4. **Alternative Install:** Alternatively, zip the directory and upload it via **Site administration > Plugins > Install plugins**.

---

## 🛠️ Usage & Configuration

Once installed, the plugin can be configured on a per-quiz basis:

1. Navigate to your course and select a **Quiz** (or create a new one).
2. Go to **Quiz Settings > Extra restrictions on attempts**.
3. Under the **Attempt Password settings**:
   - **Enable attempt passwords:** Toggle this setting to activate the rule.
   - **Generation Mode:** Choose between **Manual entry** or **Auto-generate secure numeric passwords**.
   - **Manual Passwords:** If manual is selected, input a comma-separated list of passwords corresponding to attempt 1, 2, 3, etc.
4. Save the quiz settings. Students will now be prompted for the specific password associated with their current attempt number before launching the quiz!

---

## 💻 Directory Structure

```text
attemptpassword/
├── classes/                # Autoloaded classes (Access rule logic)
│   └── privacy/            # GDPR Privacy provider implementation
├── db/                     # Database definitions (install.xml, access.php, tasks.php)
├── lang/                   # Language localization packs
│   ├── en/                 # English translations
│   └── tr/                 # Turkish translations
├── tests/                  # Automated test suites (PHPUnit)
├── .github/                # GitHub Action workflows
├── version.php             # Moodle plugin version and dependency definition
└── README.md               # Professional documentation
```

---

## 🔒 Security & Privacy (GDPR)

This plugin fully supports Moodle's Privacy Subsystem:
- It exports student attempt metadata in compliance with GDPR requests.
- It handles the safe deletion of user data upon request.
- Passwords are encrypted/stored securely in compliance with standard database practices.

---

## 🧪 Development & Testing

We maintain high code quality standards. Run automated tests using Moodle's PHPUnit framework:

```bash
# Initialize PHPUnit environment
php admin/tool/phpunit/cli/init.php

# Run tests for this plugin
vendor/bin/phpunit --group quizaccess_attemptpassword
```

---

## 📄 License & Credits

- **Copyright:** © 2026 Mahmoud Salem
- **License:** Licensed under the [GNU GPL v3 License](http://www.gnu.org/copyleft/gpl.html) (or later).
GET, # 🔑 Moodle Quiz Access Rule: Attempt Password (`quizaccess_attemptpassword`)

[![Moodle Compatibility](https://img.shields.io/badge/Moodle-3.9%20to%205.0%2B-orange.svg?style=flat-square)](https://moodle.org)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%20%7C%208.2%20%7C%208.3-blue.svg?style=flat-square)](https://php.net)
[![Database](https://img.shields.io/badge/Database-PostgreSQL%20%7C%20MySQL%20%7C%20MariaDB-purple.svg?style=flat-square)](https://docs.moodle.org)
[![License](https://img.shields.io/badge/License-GPL%20v3-green.svg?style=flat-square)](http://www.gnu.org/copyleft/gpl.html)

A professional Moodle quiz access rule plugin that gives course teachers granular control over quiz security by enabling unique, attempt-specific passwords. 

When quizzes allow multiple attempts, students who fail and are granted a reattempt cannot reuse the password from their previous attempt, securing academic integrity for high-stakes assessments.

---

## ✨ Features

- **Granular Attempt Control:** Configure different passwords for each distinct quiz attempt.
- **Flexible Password Generation Methods:**
  - **Manual Entry:** Set custom passwords for each attempt separated by commas (e.g., `pass1,pass2,pass3`).
  - **Automatic Generation:** Automatically generate highly secure, unique 4-digit numeric passwords for each attempt upon saving the quiz settings.
- **Enterprise-Ready Integrations:**
  - **Privacy Subsystem (GDPR):** Full compliance with Moodle's privacy API.
  - **Backup & Restore:** Seamlessly backs up and restores attempt passwords across courses and sites.
  - **Preflight Check Integration:** Integrates natively with Moodle's quiz access control UI.
- **Rigorous Testing:** Includes robust PHPUnit test coverage for core attempt-logic verification.
- **CI/CD Ready:** Automated GitHub Actions workflows for continuous integration testing.

---

## 📋 Requirements

| Dependency | Required Version / Compatibility |
| :--- | :--- |
| **Moodle Framework** | Moodle 3.9 to 5.0+ (Tested against Moodle 4.5/5.0+ stable branches) |
| **PHP Runtime** | PHP 8.1, PHP 8.2, PHP 8.3 |
| **Database System** | PostgreSQL 13+, MySQL 8.0+, or MariaDB 10.5+ |

---

## 🚀 Installation

Follow these steps to install the plugin manually:

1. **Download & Extract:** Download the repository and extract the files.
2. **Directory Placement:** Copy the `attemptpassword` folder into your Moodle installation's quiz access rules directory:
   ```bash
   moodle/mod/quiz/accessrule/attemptpassword
   ```
3. **Run Moodle Upgrade:** Log in to your Moodle site as an Administrator and navigate to **Site administration > Notifications** to trigger the database upgrade and complete the installation.
4. **Alternative Install:** Alternatively, zip the directory and upload it via **Site administration > Plugins > Install plugins**.

---

## 🛠️ Usage & Configuration

Once installed, the plugin can be configured on a per-quiz basis:

1. Navigate to your course and select a **Quiz** (or create a new one).
2. Go to **Quiz Settings > Extra restrictions on attempts**.
3. Under the **Attempt Password settings**:
   - **Enable attempt passwords:** Toggle this setting to activate the rule.
   - **Generation Mode:** Choose between **Manual entry** or **Auto-generate secure numeric passwords**.
   - **Manual Passwords:** If manual is selected, input a comma-separated list of passwords corresponding to attempt 1, 2, 3, etc.
4. Save the quiz settings. Students will now be prompted for the specific password associated with their current attempt number before launching the quiz!

---

## 💻 Directory Structure

```text
attemptpassword/
├── classes/                # Autoloaded classes (Access rule logic)
│   └── privacy/            # GDPR Privacy provider implementation
├── db/                     # Database definitions (install.xml, access.php, tasks.php)
├── lang/                   # Language localization packs
│   ├── en/                 # English translations
│   └── tr/                 # Turkish translations
├── tests/                  # Automated test suites (PHPUnit)
├── .github/                # GitHub Action workflows
├── version.php             # Moodle plugin version and dependency definition
└── README.md               # Professional documentation
```

---

## 🔒 Security & Privacy (GDPR)

This plugin fully supports Moodle's Privacy Subsystem:
- It exports student attempt metadata in compliance with GDPR requests.
- It handles the safe deletion of user data upon request.
- Passwords are encrypted/stored securely in compliance with standard database practices.

---

## 🧪 Development & Testing

We maintain high code quality standards. Run automated tests using Moodle's PHPUnit framework:

```bash
# Initialize PHPUnit environment
php admin/tool/phpunit/cli/init.php

# Run tests for this plugin
vendor/bin/phpunit --group quizaccess_attemptpassword
```

---

## 📄 License & Credits

- **Copyright:** © 2026 Mahmoud Salem
- **License:** Licensed under the [GNU GPL v3 License](http://www.gnu.org/copyleft/gpl.html) (or later).
POST, # 🔑 Moodle Quiz Access Rule: Attempt Password (`quizaccess_attemptpassword`)

[![Moodle Compatibility](https://img.shields.io/badge/Moodle-3.9%20to%205.0%2B-orange.svg?style=flat-square)](https://moodle.org)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%20%7C%208.2%20%7C%208.3-blue.svg?style=flat-square)](https://php.net)
[![Database](https://img.shields.io/badge/Database-PostgreSQL%20%7C%20MySQL%20%7C%20MariaDB-purple.svg?style=flat-square)](https://docs.moodle.org)
[![License](https://img.shields.io/badge/License-GPL%20v3-green.svg?style=flat-square)](http://www.gnu.org/copyleft/gpl.html)

A professional Moodle quiz access rule plugin that gives course teachers granular control over quiz security by enabling unique, attempt-specific passwords. 

When quizzes allow multiple attempts, students who fail and are granted a reattempt cannot reuse the password from their previous attempt, securing academic integrity for high-stakes assessments.

---

## ✨ Features

- **Granular Attempt Control:** Configure different passwords for each distinct quiz attempt.
- **Flexible Password Generation Methods:**
  - **Manual Entry:** Set custom passwords for each attempt separated by commas (e.g., `pass1,pass2,pass3`).
  - **Automatic Generation:** Automatically generate highly secure, unique 4-digit numeric passwords for each attempt upon saving the quiz settings.
- **Enterprise-Ready Integrations:**
  - **Privacy Subsystem (GDPR):** Full compliance with Moodle's privacy API.
  - **Backup & Restore:** Seamlessly backs up and restores attempt passwords across courses and sites.
  - **Preflight Check Integration:** Integrates natively with Moodle's quiz access control UI.
- **Rigorous Testing:** Includes robust PHPUnit test coverage for core attempt-logic verification.
- **CI/CD Ready:** Automated GitHub Actions workflows for continuous integration testing.

---

## 📋 Requirements

| Dependency | Required Version / Compatibility |
| :--- | :--- |
| **Moodle Framework** | Moodle 3.9 to 5.0+ (Tested against Moodle 4.5/5.0+ stable branches) |
| **PHP Runtime** | PHP 8.1, PHP 8.2, PHP 8.3 |
| **Database System** | PostgreSQL 13+, MySQL 8.0+, or MariaDB 10.5+ |

---

## 🚀 Installation

Follow these steps to install the plugin manually:

1. **Download & Extract:** Download the repository and extract the files.
2. **Directory Placement:** Copy the `attemptpassword` folder into your Moodle installation's quiz access rules directory:
   ```bash
   moodle/mod/quiz/accessrule/attemptpassword
   ```
3. **Run Moodle Upgrade:** Log in to your Moodle site as an Administrator and navigate to **Site administration > Notifications** to trigger the database upgrade and complete the installation.
4. **Alternative Install:** Alternatively, zip the directory and upload it via **Site administration > Plugins > Install plugins**.

---

## 🛠️ Usage & Configuration

Once installed, the plugin can be configured on a per-quiz basis:

1. Navigate to your course and select a **Quiz** (or create a new one).
2. Go to **Quiz Settings > Extra restrictions on attempts**.
3. Under the **Attempt Password settings**:
   - **Enable attempt passwords:** Toggle this setting to activate the rule.
   - **Generation Mode:** Choose between **Manual entry** or **Auto-generate secure numeric passwords**.
   - **Manual Passwords:** If manual is selected, input a comma-separated list of passwords corresponding to attempt 1, 2, 3, etc.
4. Save the quiz settings. Students will now be prompted for the specific password associated with their current attempt number before launching the quiz!

---

## 💻 Directory Structure

```text
attemptpassword/
├── classes/                # Autoloaded classes (Access rule logic)
│   └── privacy/            # GDPR Privacy provider implementation
├── db/                     # Database definitions (install.xml, access.php, tasks.php)
├── lang/                   # Language localization packs
│   ├── en/                 # English translations
│   └── tr/                 # Turkish translations
├── tests/                  # Automated test suites (PHPUnit)
├── .github/                # GitHub Action workflows
├── version.php             # Moodle plugin version and dependency definition
└── README.md               # Professional documentation
```

---

## 🔒 Security & Privacy (GDPR)

This plugin fully supports Moodle's Privacy Subsystem:
- It exports student attempt metadata in compliance with GDPR requests.
- It handles the safe deletion of user data upon request.
- Passwords are encrypted/stored securely in compliance with standard database practices.

---

## 🧪 Development & Testing

We maintain high code quality standards. Run automated tests using Moodle's PHPUnit framework:

```bash
# Initialize PHPUnit environment
php admin/tool/phpunit/cli/init.php

# Run tests for this plugin
vendor/bin/phpunit --group quizaccess_attemptpassword
```

---

## 📄 License & Credits

- **Copyright:** © 2026 Mahmoud Salem
- **License:** Licensed under the [GNU GPL v3 License](http://www.gnu.org/copyleft/gpl.html) (or later).
REQUEST) are strictly forbidden. Input retrieval uses standard Moodle validation helpers like equired_param() and optional_param() with strict parameter type filters (PARAM_INT, PARAM_BOOL, etc.).
- **Capability Controls:** Page entry points verify course contexts with equire_login() and validate explicit capabilities (e.g. mod/quiz:viewreports, local_competency_report:viewreports) via equire_capability().
- **Frankenstyle & Namespace Compliance:** Database tables and autoloaded classes are strictly prefixed and namespaced (e.g. \local_competency_report\... or \quizaccess_failgrade\...) preventing any class name or table name collisions.
- **Coding Standards:** Code is audited via PHP_CodeSniffer (PHPCS) enforcing clean syntax, proper DocBlocks, and standard Moodle conventions.

---

## ðŸ„ License & Credits

- **Copyright:** © 2026 Mahmoud Salem
- **License:** Licensed under the [GNU GPL v3 License](http://www.gnu.org/copyleft/gpl.html) (or later).
