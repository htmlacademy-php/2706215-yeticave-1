<?php

declare(strict_types=1);

/**
 * Formats a price and adds the ruble sign.
 *
 * @param int $price Price value.
 *
 * @return string Formatted price with the ruble sign.
 */
function format_price(int $price): string
{
    $formatted_price = number_format($price, 0, ',', ' ');

    return $formatted_price . ' ₽';
}

/**
 * Escapes a string for safe HTML output.
 *
 * @param string $value Raw string value.
 *
 * @return string Escaped string.
 */
function esc(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Returns the time left until the end of the given date.
 *
 * The date is treated as a calendar date in the application timezone.
 * The lot expires at 23:59:59 on this date.
 *
 * Invalid or expired dates return [0, 0].
 *
 * @param string $date Expiration date in YYYY-MM-DD format.
 *
 * @return array{0: int, 1: int} Time left as [hours, minutes].
 */
function get_time_left(string $date): array
{
    $hours_left = 0;
    $minutes_left = 0;

    if (is_date_valid($date)) {
        $expiration_date = DateTimeImmutable::createFromFormat('!Y-m-d H:i:s', "{$date} 23:59:59");
        $now = new DateTimeImmutable();
        $seconds_left = max(0, $expiration_date->getTimestamp() - $now->getTimestamp());

        $hours_left = intdiv($seconds_left, SECONDS_PER_HOUR);
        $minutes_left = intdiv($seconds_left % SECONDS_PER_HOUR, SECONDS_PER_MINUTE);
    }

    return [$hours_left, $minutes_left];
}

/**
 * Formats remaining time as HH:MM.
 *
 * @param array{0: int, 1: int} $time_left Remaining hours and minutes.
 *
 * @return string Formatted remaining time.
 */
function format_time_left(array $time_left): string
{
    $hours = str_pad((string) $time_left[0], 2, '0', STR_PAD_LEFT);
    $minutes = str_pad((string) $time_left[1], 2, '0', STR_PAD_LEFT);

    return $hours . ':' . $minutes;
}
