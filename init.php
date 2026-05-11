<?php

declare(strict_types=1);

date_default_timezone_set('Europe/Moscow');

define('BASE_PATH', __DIR__);

define('UPLOADS_DIR', BASE_PATH . '/uploads');
define('UPLOADS_URL', '/uploads');

require_once __DIR__ . '/util/const.php';
require_once __DIR__ . '/functions/helpers.php';
require_once __DIR__ . '/functions/functions.php';
require_once __DIR__ . '/functions/database.php';
require_once __DIR__ . '/functions/upload.php';

$db_config = require __DIR__ . '/config/db.php';

$db_connection = db_connect($db_config);
