<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.
// Server-seitige Aktion: Modellwahl prüfen und genau den Terminologie-Check starten.

/**
 * Validates the selected AI model and queues the terminology check.
 *
 * @package    coursechecker_terminology
 * @copyright  2026 Technische Hochschule Lübeck
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');

require_login();
require_sesskey();

$courseid = required_param('courseid', PARAM_INT);
$model = required_param('model', PARAM_RAW_TRIMMED);
$course = get_course($courseid);
require_login($course);
$context = \context_course::instance($courseid);
require_capability('local/course_checker:runcheck', $context);

$models = require(__DIR__ . '/models.php');
if (!array_key_exists($model, $models)) {
    throw new \moodle_exception('invalidparameter');
}

if (!\local_course_checker\plugininfo\coursechecker::is_plugin_enabled('terminology')) {
    throw new \moodle_exception('invalidparameter');
}

// Keine zweite Terminologie-Prüfung während einer bereits aktiven starten.
$activecheckid = (int)get_config('coursechecker_terminology', 'active_course_' . $courseid);
if ($activecheckid > 0) {
    redirect(
        new \moodle_url('/local/course_checker/index.php', ['courseid' => $courseid]),
        'Die Terminologie-Prüfung läuft bereits. Bitte keinen zweiten Lauf starten.',
        null,
        \core\output\notification::NOTIFY_WARNING
    );
}

// Für die nächste Auswahl in diesem Kurs vorbelegen.
set_config('ui_model_course_' . $courseid, $model, 'coursechecker_terminology');

// WICHTIG: Modell direkt in Moodle-Taskdaten einfrieren. Dadurch wirkt ein
// späterer UI-Wechsel nicht auf bereits eingeplante Tests.
$course->_terminology_selected_model = $model;
$task = \local_course_checker\task\queue_check_task::instance(
    $USER,
    $course,
    ['terminology' => 'terminology']
);
\core\task\manager::queue_adhoc_task($task, true);

redirect(
    new \moodle_url('/local/course_checker/index.php', ['courseid' => $courseid]),
    'Terminologie-Prüfung mit Modell ' . $models[$model] . ' eingeplant.',
    null,
    \core\output\notification::NOTIFY_SUCCESS
);
