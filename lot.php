<?php

declare(strict_types=1);

/** @var mysqli $db_connection */

require_once __DIR__ . '/init.php';

$is_auth = (bool) rand(0, 1);
$user_name = 'Александр';

$lot_id = (int) ($_GET['id'] ?? 0);
$lot = $lot_id > 0 ? get_lot_by_id($db_connection, $lot_id) : null;

if ($lot === null) {
    http_response_code(HTTP_NOT_FOUND);
    exit('Страница не найдена');
}

$categories = get_all_categories($db_connection);

$main_content = include_template('lot.php', [
    'categories' => $categories,
    'lot' => $lot,
]);

$page_title = $lot['title'] ?? '';

$page_content = include_template('layout.php', [
    'page_title' => $page_title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories,
    'main_content' => $main_content,
    'main_class' => '',
]);

echo $page_content;
