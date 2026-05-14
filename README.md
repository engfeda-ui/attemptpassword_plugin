# Moodle - Attempt Password Quiz Access Rule (quizaccess_attemptpassword)

## Description

The purpose of this plugin is to allow course teachers to configure a unique password for each distinct attempt of a Moodle Quiz. 

When quizzes allow multiple attempts, students who fail and are granted a reattempt should not be able to reuse the password from their previous attempt. This plugin provides full control over attempt-specific passwords by supporting two dynamic generation methods:
- **Manual entry**: Teachers can enter custom passwords for each attempt separated by commas (e.g., `pass1,pass2,pass3`).
- **Auto-generate random passwords**: The plugin automatically creates highly secure, unique 4-digit numeric passwords for each attempt upon saving the quiz settings.

## Installation

Please refer to the official documentation: [Installing Plugins](https://docs.moodle.org/en/Installing_plugins)

1. Unzip the plugin archive.
2. Place the `attemptpassword` directory into `mod/quiz/accessrule/`.
3. Visit **Site administration > Notifications** to complete the installation.

## Requirements

- Moodle 3.9 (2020060900) or later (fully supported up to Moodle 4.5+).

## Features & Status

- [X] Compatible with Moodle preflight check APIs.
- [X] Full Privacy Subsystem support (GDPR compliant).
- [X] Backup and Restore integration to seamlessly migrate attempt passwords across courses.
- [X] Automated PHPUnit tests for core logic verification.
- [X] GitHub Actions CI/CD workflows for rigorous continuous testing.

## License

Licensed under the [GNU GPL License](http://www.gnu.org/copyleft/gpl.html)
