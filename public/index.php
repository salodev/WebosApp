<?php
require_once(dirname(dirname(__FILE__)) . '/private/start.php');

use Webos\Implementations\Service;


Service::Start('MyProject\App', [], !empty($_REQUEST['debug']));
