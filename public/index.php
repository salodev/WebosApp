<?php
require_once(dirname(dirname(__FILE__)) . '/private/start.php');

use Webos\Service\Implementation;


Implementation::Start('MyProject\App', [], 'login.php');
