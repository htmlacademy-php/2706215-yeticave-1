<?php

declare(strict_types=1);

require_once __DIR__ . '/const.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/functions.php';

$is_auth = (bool) rand(0, 1);

$user_name = 'Александр';

$categories = [
    'Доски и лыжи',
    'Крепления',
    'Ботинки',
    'Одежда',
    'Инструменты',
    'Разное'
];

$lots = [
    [
        'title' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 10999,
        'image_url' => 'img/lot-1.jpg',
        'expire_date' => '2026-04-15',
    ],
    [
        'title' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 159999,
        'image_url' => 'img/lot-2.jpg',
        'expire_date' => '2026-04-16',
    ],
    [
        'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => 8000,
        'image_url' => 'img/lot-3.jpg',
        'expire_date' => '2026-04-17',
    ],
    [
        'title' => 'Ботинки для сноуборда DC Mutiny Charcoal',
        'category' => 'Ботинки',
        'price' => 10999,
        'image_url' => 'img/lot-4.jpg',
        'expire_date' => '2026-04-18',
    ],
    [
        'title' => 'Куртка для сноуборда DC Mutiny Charcoal',
        'category' => 'Одежда',
        'price' => 7500,
        'image_url' => 'img/lot-5.jpg',
        'expire_date' => '2026-04-19',
    ],
    [
        'title' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => 5400,
        'image_url' => 'img/lot-6.jpg',
        'expire_date' => '2026-04-20',
    ],
];

$main_content = include_template('main.php', [
    'lots' => $lots,
    'categories' => $categories,
]);

$page_content = include_template('layout.php', [
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories,
    'content' => $main_content,
    'title' => 'Главная',
]);

echo $page_content;
