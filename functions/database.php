<?php

declare(strict_types=1);

/**
 * Creates a MySQL database connection and sets the connection charset.
 *
 * @param array{
 *     host: string,
 *     user: string,
 *     password: string,
 *     database: string,
 *     port: int
 * } $config Database connection settings.
 *
 * @return mysqli MySQL database connection.
 */
function db_connect(array $config): mysqli
{
    if (!isset($config['host'], $config['user'], $config['password'], $config['database'], $config['port'])) {
        // TODO: Replace exit() with exceptions and show the error on the error.php page.
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
        // TODO: Replace exit() with exceptions and show the error on the error.php page.
        exit('Ошибка подключения: ' . mysqli_connect_error());
    }

    if (!mysqli_set_charset($connection, 'utf8mb4')) {
        // TODO: Replace exit() with exceptions and show the error on the error.php page.
        exit('Ошибка установки кодировки: ' . mysqli_error($connection));
    }

    return $connection;
}

/**
 * Returns all lot categories.
 *
 * @param mysqli $connection MySQL database connection.
 *
 * @return array<int, array{
 *     id: string,
 *     name: string,
 *     slug: string
 * }>
 */
function get_all_categories(mysqli $connection): array
{
    $sql = 'SELECT `id`, `name`, `slug` FROM `categories`';

    $result = mysqli_query($connection, $sql);

    if ($result === false) {
        // TODO: Replace exit() with exceptions and show the error on the error.php page.
        exit('Ошибка SQL-запроса: ' . mysqli_error($connection));
    }

    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $rows;
}

/**
 * Returns recent active lots with their current price and category name.
 *
 * The current price is the highest bet amount or the start price if there are no bets.
 * The expiration date is returned in YYYY-MM-DD format.
 *
 * @param mysqli $connection MySQL database connection.
 * @param int $limit Maximum number of lots to return.
 *
 * @return array<int, array{
 *     id: string,
 *     title: string,
 *     start_price: string,
 *     image_url: string,
 *     price: string,
 *     expire_date: string,
 *     category_name: string
 * }>
 */
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
  DATE_FORMAT(lots.`expire_date`, '%Y-%m-%d') AS `expire_date`,
  categories.`name` AS `category_name`
FROM `lots`
JOIN `categories` ON lots.`category_id` = categories.`id`
LEFT JOIN (
  SELECT `lot_id`, MAX(`amount`) AS `max_amount`
  FROM `bets`
  GROUP BY `lot_id`
) AS lot_bets ON lot_bets.`lot_id` = lots.`id`
WHERE lots.`expire_date` > CURRENT_DATE
ORDER BY lots.`created_at` DESC
LIMIT ?;
EOT;

    // TODO: Move prepared SELECT query execution to a separate helper function with full error handling.
    $stmt = mysqli_prepare($connection, $sql);

    mysqli_stmt_bind_param($stmt, 'i', $limit);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result === false) {
        // TODO: Replace exit() with exceptions and show the error on the error.php page.
        exit('Ошибка SQL-запроса: ' . mysqli_error($connection));
    }

    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $rows;
}
