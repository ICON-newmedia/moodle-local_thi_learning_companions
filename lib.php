<?phpfunction local_learningcompanions_extend_settings_navigation() {    global $PAGE;    if (!isloggedin()){        return;    }    $config = get_config('local_learningcompanions');    $params = array(        $config->button_css_selector,        $config->button_bg_color,        $config->button_text_color,        $config->button_radius,    );    $PAGE->requires->js_call_amd('local_learningcompanions/learningcompanions', 'init', $params);}function get_attachments_of_chat_comments(array $comments, string $area) {    // ICTODO: also get inline attachments    $itemids = array_keys($comments);    $filestorage = get_file_storage();    $context = \context_system::instance();    $files = $filestorage->get_area_files(        $context->id,        'local_learningcompanions',        $area,        $itemids,        'filename',        false    );    $filesbyid = array_reduce($comments, function($carry, $comment) {        $carry[$comment->id] = [];        return $carry;    }, []);    return array_reduce($files, function($carry, $file) {        $itemid = $file->get_itemid();        $carry[$itemid] = array_merge($carry[$itemid], [$file]);        return $carry;    }, $filesbyid);}function local_learningcompanions_extend_navigation(global_navigation $nav) {    if (has_capability('tool/learningcompanions:manage', context_system::instance())) {        global $CFG, $PAGE;        $rootNode = $nav->find('home', $nav::TYPE_ROOTNODE)->parent;        $url = new moodle_url('/admin/tool/learningcompanions/index.php');        $node = $rootNode->add(get_string('lcadministration', 'local_learningcompanions'), $url, $nav::TYPE_ROOTNODE, null, 'learningcompanions', new pix_icon('i/nav-icon', '', 'tool_learningcompanions'));        $subNavigationItems = array(            'comments',            'groups'        );        foreach($subNavigationItems as $subNavigationItem) {            $node->add(get_string('lcadministration_' .$subNavigationItem, 'local_learningcompanions'), new moodle_url($CFG->wwwroot . '/admin/tool/learningcompanions/'.$subNavigationItem.'/index.php'), null, null, $subNavigationItem);        }        if (strpos($PAGE->url, 'admin/tool/learningcompanions') > -1) {            $node->force_open();        }        $node->showinflatnavigation = true;    }}function local_learningcompanions_pluginfile($course, $record, $context, $filearea, $args, $forcedownload, array $options=array()) {    if ($context->contextlevel != CONTEXT_SYSTEM) {        send_file_not_found();    }    if ($filearea !== 'groupimage') {        send_file_not_found();    }    $groupid = (int)array_shift($args);    $fs = get_file_storage();    $filename = array_pop($args);    $filepath = $args ? '/'.implode('/', $args).'/' : '/';    $context = context_system::instance();    if (!$file = $fs->get_file($context->id, 'local_learningcompanions', 'groupimage', $groupid, $filepath, $filename) or $file->is_directory()) {        send_file_not_found();    }    // NOTE: it woudl be nice to have file revisions here, for now rely on standard file lifetime,    //       do not lower it because the files are dispalyed very often.    \core\session\manager::write_close();    send_stored_file($file, null, 0, $forcedownload = false, $options);}function get_user_status($userid = null) {    global $USER;    $userid = is_null($userid) ? $USER->id : $userid;    if ($userid % 2 == 0){        return 'online';    }    return 'offline';}function set_user_status($status, $userid = null) {}