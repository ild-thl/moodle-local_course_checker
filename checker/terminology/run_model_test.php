<?php
// Server-seitige Aktion: Modellwahl prüfen und genau den Terminologie-Check starten.
require_once(__DIR__ . '/../../../../config.php');

require_login();
require_sesskey();

$courseid = required_param('courseid', PARAM_INT);
$model = required_param('model', PARAM_RAW_TRIMMED);
$course = get_course($courseid);
require_login($course);
$context = \context_course::instance($courseid);
require_capability('local/course_checker:runcheck', $context);

$models = require __DIR__ . '/models.php';
if (!array_key_exists($model, $models)) {
    throw new \moodle_exception('invalidparameter');
}

if (!\local_course_checker\plugininfo\coursechecker::is_plugin_enabled('terminology')) {
    throw new \moodle_exception('invalidparameter');
}

// Keine zweite Terminologie-Prüfung während einer bereits aktiven starten.
$activecheckid = (int)get_config('coursechecker_terminology', 'active_course_' . $courseid);
if ($activecheckid > 0) {
    redirect(new \moodle_url('/local/course_checker/index.php', ['courseid' => $courseid]),
        'Die Terminologie-Prüfung läuft bereits. Bitte keinen zweiten Lauf starten.',
        null, \core\output\notification::NOTIFY_WARNING);
}

// Für die nächste Auswahl in diesem Kurs vorbelegen.
set_config('ui_model_course_' . $courseid, $model, 'coursechecker_terminology');

// WICHTIG: Modell direkt in Moodle-Taskdaten einfrieren. Dadurch wirkt ein
// späterer UI-Wechsel nicht auf bereits eingeplante Tests.
$course->_terminology_selected_model = $model;
$task = \local_course_checker\task\queue_check_task::instance(
    $USER, $course, ['terminology' => 'terminology']);
\core\task\manager::queue_adhoc_task($task, true);

redirect(new \moodle_url('/local/course_checker/index.php', ['courseid' => $courseid]),
    'Terminologie-Prüfung mit Modell ' . $models[$model] . ' eingeplant.',
    null, \core\output\notification::NOTIFY_SUCCESS);
