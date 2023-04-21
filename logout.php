<?php

session_start();
require_once('helpers.php');
require_once('init_db.php');

$_SESSION = [];

$page_content = include_template('guest.php');

$layout_content = include_template(
    'layout.php',
    [
        'content' => $page_content,
        'title'   => $config['title'],
    ]
);

print ($layout_content);


