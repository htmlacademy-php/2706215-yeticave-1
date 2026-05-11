<?php

declare(strict_types=1);

// DateTime
const SECONDS_PER_MINUTE = 60;
const SECONDS_PER_HOUR = SECONDS_PER_MINUTE * 60;

// HTTP response status codes
const HTTP_NOT_FOUND = 404;

// Lots
const LIMIT_RECENT_LOTS = 6;

// Uploads
const MAX_UPLOADED_FILE_SIZE = 2 * 1024 * 1024; // 2MB
const ALLOWED_IMAGE_TYPES = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'webp' => 'image/webp',
];
