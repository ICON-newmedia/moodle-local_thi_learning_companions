<?php

require_once dirname(__DIR__, 3) . '/config.php';

$questionId = required_param('id', PARAM_INT);

global $PAGE, $CFG, $OUTPUT, $USER;
$PAGE->set_context(\context_system::instance());
$PAGE->set_url($CFG->wwwroot . '/local/thi_learning_companions/mentor/question.php');
$PAGE->set_pagelayout('base');
$PAGE->set_title(get_string('learninggroups', 'local_thi_learning_companions'));
$groupid = optional_param('groupid', null, PARAM_INT);
$PAGE->requires->js_call_amd('local_thi_learning_companions/thi_learning_companions_chat', 'init');

$PAGE->requires->js(new moodle_url('https://unpkg.com/react@18/umd/react.development.js'), true);
//$PAGE->requires->js(new moodle_url('https://unpkg.com/react@18.2.0/umd/react.production.min.js'), true);
$PAGE->requires->js(new moodle_url('https://unpkg.com/react-dom@18/umd/react-dom.development.js'), true);
//$PAGE->requires->js(new moodle_url('https://unpkg.com/react-dom@18.2.0/umd/react-dom.production.min.js'), true);
$PAGE->requires->js(new moodle_url('/local/thi_learning_companions/js/react/build/thi_learning_companions-chat.min.js'));

$chat = \local_thi_learning_companions\chat::createQuestionChat($questionId);

echo $OUTPUT->header();
echo $chat->get_question_chat_module();
echo $OUTPUT->footer();
