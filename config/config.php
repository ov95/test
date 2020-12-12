<?php

# Error reporting
error_reporting(E_ALL);

# Default timezone dor DateTime
date_default_timezone_set('UTC');

# Database params
define('DB_HOST',       'dev.citrus.com');
define('DB_NAME',       'citrus_shop');
define('DB_USER',       'du_citrus');
define('DB_PASSWORD',   '2Zy0pnjUXykvjA2p');
define('DB_CHARSET',    'utf8mb4');

# Views directory path
$viewsDirPath = rtrim(__DIR__, '/config') . "/src/templates/";
define('VIEWS_DIR', $viewsDirPath);

define('POSTS_PER_PAGE', 9);
define('POSTS_PER_ROW', 3);

define('IMAGE_FOLDER_PATH', '/images/');

define('STATUS_INACTIVE', 0);
define('STATUS_ACTIVE', 1);
