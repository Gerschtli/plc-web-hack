<?hh // strict

require_once('../vendor/hh_autoload.php');

/* HH_IGNORE_ERROR[1002] */
\HH\Asio\join(\PLC\Router::route($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']));
