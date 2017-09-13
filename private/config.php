<?php
define('ENV_DEV',  0);
define('ENV_TEST', 1);
define('ENV_PROD', 2);
define('PATH_BASE',     dirname(__DIR__) . '/'           );
define('PATH_PRIVATE',  PATH_BASE    . 'private/'        );
define('PATH_PUBLIC',   PATH_BASE    . 'public/'         );
define('PATH_LOG_FILE', PATH_PRIVATE . 'log/debug.log'   );
define('PATH_DEBUG',    PATH_PRIVATE . 'debug/'          );
define('PATH_AUTOLOAD', PATH_PRIVATE . 'lib/autoload.php');

define('ENV', ENV_DEV);

switch (ENV) {
	case ENV_DEV:
		define('SITE_URL', 'http://localhost:8080/');
		define('SITE_HOST', 'localhost');		
		break;
	default:
		define('SITE_URL', 'http://localhost:8080/');
		define('SITE_HOST', 'localhost');
		break;
}