<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';

/** @var mysqli $db_connection */

$is_auth = (bool) rand(0, 1);
$user_name = 'Александр';

$categories = get_all_categories($db_connection);
$lots = get_recent_lots($db_connection);

$main_content = include_template('main.php', [
    'categories' => $categories,
    'lots' => $lots,
]);

$page_content = include_template('layout/layout.php', [
    'page_title' => 'Главная',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories,
    'main_content' => $main_content,
    'main_class' => 'container',
]);

echo $page_content;
