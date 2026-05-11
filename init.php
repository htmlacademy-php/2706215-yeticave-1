<?php

declare(strict_types=1);

date_default_timezone_set('Europe/Moscow');

define('BASE_PATH', __DIR__);

require_once __DIR__ . '/util/const.php';
require_once __DIR__ . '/functions/helpers.php';
require_once __DIR__ . '/functions/functions.php';
require_once __DIR__ . '/functions/database.php';
require_once __DIR__ . '/functions/upload.php';
require_once __DIR__ . '/functions/form.php';

$db_config = require __DIR__ . '/config/db.php';

$db_connection = db_connect($db_config);

$is_auth = (bool) rand(0, 1);
$user_name = 'Александр';

$categories = get_all_categories($db_connection);
