<?php

declare(strict_types=1);

date_default_timezone_set('Europe/Moscow');

require_once __DIR__ . '/util/const.php';
require_once __DIR__ . '/functions/helpers.php';
require_once __DIR__ . '/functions/functions.php';
require_once __DIR__ . '/functions/database.php';

$db_config = require __DIR__ . '/config/db.php';

$db_connection = db_connect($db_config);
