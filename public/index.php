<?hh // strict

// autoload all
require_once('../vendor/hh_autoload.php');

use HH\Asio\join;
use PLC\Router;

// call router with all essential variables
/* HH_IGNORE_ERROR[1002] */
join(
    Router::route(
        $_SERVER['REQUEST_METHOD'],
        $_SERVER['REQUEST_URI']
    )
);
