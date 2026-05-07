<?php

declare(strict_types=1);

function db_connect(array $config): mysqli
{
    if (!isset($config['host'], $config['user'], $config['password'], $config['database'], $config['port'])) {
        exit('Ошибка конфигурации базы данных');
    }

    $connection = mysqli_connect(
        $config['host'],
        $config['user'],
        $config['password'],
        $config['database'],
        $config['port']
    );

    if ($connection === false) {
        exit('Ошибка подключения: ' . mysqli_connect_error());
    }

    if (!mysqli_set_charset($connection, 'utf8mb4')) {
        exit('Ошибка установки кодировки: ' . mysqli_error($connection));
    }

    return $connection;
}

function get_all_categories(mysqli $connection): array
{
    $sql = 'SELECT `id`, `name`, `slug` FROM `categories`';

    $result = mysqli_query($connection, $sql);

    if ($result === false) {
        exit('Ошибка SQL-запроса: ' . mysqli_error($connection));
    }

    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $rows;
}

function get_recent_lots(mysqli $connection, int $limit = LIMIT_RECENT_LOTS): array
{
    $limit = max(1, $limit);

    $sql = <<<EOT
SELECT
  lots.`id`,
  lots.`title`,
  lots.`start_price`,
  lots.`image_url`,
  IFNULL(lot_bets.`max_amount`, lots.`start_price`) AS `price`,
  categories.`name` AS `category`
FROM `lots`
JOIN `categories` ON lots.`category_id` = categories.`id`
LEFT JOIN (
  SELECT `lot_id`, MAX(`amount`) AS `max_amount`
  FROM `bets`
  GROUP BY `lot_id`
) AS lot_bets ON lot_bets.`lot_id` = lots.`id`
WHERE lots.`expire_date` > CURRENT_DATE
ORDER BY lots.`created_at` DESC
LIMIT $limit;
EOT;

    $result = mysqli_query($connection, $sql);

    if ($result === false) {
        exit('Ошибка SQL-запроса: ' . mysqli_error($connection));
    }

    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $rows;
}
