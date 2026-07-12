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
 * Arabic language strings for quizaccess_attemptpassword.
 *
 * @package   quizaccess_attemptpassword
 * @copyright 2026 Mahmoud Salem <eng.feda@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'كلمة مرور المحاولة';
$string['attemptpassword'] = 'كلمات مرور المحاولات';
$string['attemptpassword_help'] = 'للإدخال اليدوي، أدخل كلمات المرور مفصولة بفواصل (مثل pass1,pass2,pass3). في حال التوليد التلقائي، سيتم إنشاء كلمات مرور عشوائية مكونة من 4 أرقام وعرضها هنا فور حفظ التغييرات.';
$string['copied'] = 'تم النسخ!';
$string['copytoclipboard'] = 'نسخ كلمات المرور إلى الحافظة';
$string['enterpasswordforattempt'] = 'لبدء المحاولة رقم {$a}، يرجى إدخال كلمة المرور المخصصة لهذه المحاولة:';
$string['genmethod'] = 'طريقة توليد كلمات المرور';
$string['genmethod_manual'] = 'إدخال يدوي (مفصولة بفواصل)';
$string['genmethod_random'] = 'توليد تلقائي لكلمات مرور عشوائية من 4 أرقام';
$string['lockoutmessage'] = 'لقد قمت بإدخال كلمة المرور بشكل خاطئ عدة مرات. تم حظرك مؤقتاً من المحاولة لمدة {$a} دقائق. يرجى المحاولة مرة أخرى لاحقاً.';
$string['lockoutwarning'] = 'تنبيه: لقد أدخلت كلمة مرور خاطئة {$a->failed} مرات من أصل {$a->max}. بعد وصولك لـ {$a->max} محاولات خاطئة سيتم حظر دخولك للاختبار لمدة 5 دقائق.';
$string['passwordcountmismatch'] = 'تحذير: لقد قمت بإدخال {$a->passwords} كلمة مرور، بينما هذا الاختبار يتيح {$a->attempts} محاولات. كل محاولة تتطلب كلمة مرور مستقلة. يرجى تصحيح كلمات المرور لتطابق عدد المحاولات.';
$string['wrongpassword'] = 'كلمة المرور التي قمت بإدخالها غير صحيحة لهذه المحاولة.';

// Privacy metadata.
$string['privacy:metadata'] = 'تخزين إعدادات كلمات مرور محاولات الاختبار وسجلات حظر دخول الطلاب.';
$string['privacy:metadata:quizid'] = 'معرف الاختبار المرتبط بالسجل.';
$string['privacy:metadata:userid'] = 'معرف الطالب صاحب المحاولة.';
$string['privacy:metadata:attemptnum'] = 'رقم محاولة الاختبار.';
$string['privacy:metadata:failedcount'] = 'عدد مرات إدخال كلمة المرور الخاطئة.';
$string['privacy:metadata:lockouttime'] = 'توقيت انتهاء حظر الدخول للعملية.';
$string['privacy:metadata:quizaccess_attemptpass_log'] = 'جدول قاعدة البيانات الذي يحفظ محاولات الطلاب الخاطئة وسجلات حظر الدخول المؤقت.';
$string['event_password_failed'] = 'فشل إدخال كلمة مرور الاختبار';
$string['event_password_verified'] = 'تم التحقق من كلمة مرور الاختبار بنجاح';
