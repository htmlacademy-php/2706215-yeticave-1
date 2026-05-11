<?php

declare(strict_types=1);

/** @var mysqli $db_connection */

require_once __DIR__ . '/init.php';

$is_auth = (bool) rand(0, 1);
$user_name = 'Александр';

$categories = get_all_categories($db_connection);

$form_data = [];
$form_errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_data = $_POST;

    // Required fields (except image file)
    $required_fields = [
        'category_id',
        'title',
        'description',
        'start_price',
        'bet_step',
        'expire_date',
    ];

    // Validate required text fields
    $form_errors = validate_form_data($required_fields, $form_data, $form_errors);

    // Image file field
    $file_input_name = 'lot_image_file';
    $file_field = 'image_url';

    // Upload image file if exists
    if (!empty($_FILES[$file_input_name])) {
        $saved_file_name = save_uploaded_file($file_input_name);

        if ($saved_file_name) {
            $form_data[$file_field] = $saved_file_name;
            unset($form_errors[$file_input_name]);
        } else {
            $form_data[$file_field] = '';
            $form_errors[$file_input_name] = 'Ошибка при загрузке файла';
        }

    } else {
        $form_errors[$file_input_name] = 'Загрузите файл';
    }

    if (empty($form_errors)) {
        // TODO: Replace temporary author ID with current authenticated user ID.
        $author_id = 1;

        $data = [
            $author_id,
            (int) $form_data['category_id'],
            $form_data['title'],
            $form_data['description'],
            $form_data['image_url'],
            (int) $form_data['start_price'],
            (int) $form_data['bet_step'],
            $form_data['expire_date'],
        ];

        $added_lot_id = add_lot($db_connection, $data);

        if ($added_lot_id) {
            redirect('/lot.php?id=' . $added_lot_id);
        }

        // TODO: Add proper error handling if lot creation fails.
    }
}

$main_content = include_template('add-lot.php', [
    'categories' => $categories,
    'form_data' => $form_data,
    'form_errors' => $form_errors,
]);

$page_title = 'Добавление лота';

$page_content = include_template('layout.php', [
    'page_title' => $page_title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories,
    'main_content' => $main_content,
    'main_class' => '',
    'css_files' => ['/css/flatpickr.min.css'],
    'js_files' => ['/js/flatpickr.js', '/js/script.js'],
]);

echo $page_content;
