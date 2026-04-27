<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/data.php';

$is_auth = (bool) rand(0, 1);
$user_name = 'Александр';
$page_title = 'Главная';

$main_content = include_template('main.php', [
    'categories' => $categories,
    'lots' => $lots,
]);

$page_content = include_template('layout.php', [
    'page_title' => $page_title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories,
    'main_content' => $main_content,
]);

echo $page_content;
