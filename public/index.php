<?hh // strict

// autoload all
require_once('../vendor/hh_autoload.php');

use HH\Asio\join;
use PLC\Router;

// call router
/* HH_IGNORE_ERROR[1002] */
join(Router::route());
