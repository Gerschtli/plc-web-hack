<?hh // strict

// autoload all
require_once('../vendor/hh_autoload.php');

// call router
/* HH_IGNORE_ERROR[1002] */
\HH\Asio\join(\PLC\Router::route());
