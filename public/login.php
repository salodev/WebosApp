<?php
require_once(dirname(dirname(__FILE__)) . '/private/start.php');

/**
 * @TODO: REMOVE IT!!!
 * CREATE LOGIN FORM AND FILL 'username' KEY WITH A AUTHENTICATED USER NAME.
 */
$_SESSION['username'] = 'root';
header('Location: /');
die();