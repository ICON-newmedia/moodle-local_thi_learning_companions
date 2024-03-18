<?php

defined('MOODLE_INTERNAL') || die();

global $CFG, $DB;

if ($oldversion < 2023022701) {
    require_once __DIR__ . '/../lib.php';
    local_thi_learning_companions\db\create_status_profile_field();

    upgrade_plugin_savepoint(true, 2023022701, 'local', 'thi_learning_companions');
}
