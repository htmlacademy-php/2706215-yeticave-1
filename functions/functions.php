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
 * @param array{0: int, 1: int} $time_left Remaining time as [hours, minutes].
 *
 * @return string Formatted remaining time.
 */
function format_time_left(array $time_left): string
{
    return sprintf('%02d:%02d', $time_left[0], $time_left[1]);
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
 * Generates HTML link tags for CSS files.
 *
 * @param string[] $css_files List of CSS file paths.
 *
 * @return string HTML link tags separated by line breaks.
 */
function include_css_files(array $css_files = []): string
{
    $links = [];

    foreach ($css_files as $href) {
        $links[] = '<link href="' . esc($href) . '" rel="stylesheet">';
    }

    return implode(PHP_EOL, $links);
}

/**
 * Generates HTML script tags for JavaScript files.
 *
 * @param string[] $js_files List of JavaScript file paths.
 *
 * @return string HTML script tags separated by line breaks.
 */
function include_js_files(array $js_files = []): string
{
    $scripts = [];

    foreach ($js_files as $src) {
        $scripts[] = '<script src="' . esc($src) . '"></script>';
    }

    return implode(PHP_EOL, $scripts);
}

/**
 * Checks whether the current page is the home page.
 */
function is_home_page(): bool
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    return in_array($path, ['/', '/index.php'], true);
}

/**
 * Redirects to the given URL and stops script execution.
 *
 * @param string $url Redirect URL.
 * @return never
 */
function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}
