<?php
// Einbinden in local/course_checker/index.php (innerhalb von if ($checkerexists)).
// Erwartet die lokalen Variablen $courseid und $context aus index.php.
defined('MOODLE_INTERNAL') || die();

if (has_capability('local/course_checker:runcheck', $context)) {
    $models = require __DIR__ . '/models.php';
    $selected = (string)(get_config('coursechecker_terminology',
        'ui_model_course_' . (int)$courseid) ?: 'deepseek-v4.1-flash-1017');
    if (!isset($models[$selected])) {
        $selected = 'deepseek-v4.1-flash-1017';
    }
    $actionurl = new moodle_url('/local/course_checker/checker/terminology/run_model_test.php');
    echo html_writer::start_div('card my-3');
    echo html_writer::start_div('card-body');
    echo html_writer::tag('h4', 'Terminologie – KI-Modell testen', ['class' => 'h5']);
    echo html_writer::start_tag('form', [
        'method' => 'post',
        'action' => $actionurl->out(false),
        'class' => 'd-flex align-items-end flex-wrap gap-2',
    ]);
    echo html_writer::empty_tag('input', [
        'type' => 'hidden', 'name' => 'courseid', 'value' => (int)$courseid,
    ]);
    echo html_writer::empty_tag('input', [
        'type' => 'hidden', 'name' => 'sesskey', 'value' => sesskey(),
    ]);
    echo html_writer::start_div('mr-2 mb-2');
    echo html_writer::tag('label', 'KI-Modell', [
        'for' => 'terminology-model-select', 'class' => 'd-block font-weight-bold',
    ]);
    echo html_writer::select($models, 'model', $selected, false, [
        'id' => 'terminology-model-select', 'class' => 'form-control custom-select',
    ]);
    echo html_writer::end_div();
    echo html_writer::tag('button', 'Nur Terminologie prüfen', [
        'type' => 'submit', 'class' => 'btn btn-primary mb-2',
    ]);
    echo html_writer::end_tag('form');
    echo html_writer::tag('small',
        'Startet nur den Terminologie-Checker mit dem ausgewählten Modell. ' .
        'Andere Prüfungen werden nicht neu gestartet. Bitte nur einmal klicken.',
        ['class' => 'text-muted']);
    echo html_writer::end_div();
    echo html_writer::end_div();
}
