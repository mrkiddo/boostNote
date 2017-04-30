<?php

define('DB_NAME', 'boost_note');
define('DB_USER', 'test');
define('DB_PASSWORD', '000000');
define('DB_HOST', 'localhost');
define('DB_TABLE_PREFIX', 'bn_');

define('MIGRATION_DIR', APP_PATH.'application/migrations');
define('DEFAULT_CONTROLLER', 'User');

define('MOCK_USER_ID', true);

define('SHARE_LEVEL_EVERYONE', 0);
define('SHARE_LEVEL_EMAIL', 1);
define('SHARE_LEVEL_USER', 2);