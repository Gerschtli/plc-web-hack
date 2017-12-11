<?hh // strict

namespace PLC;

use PLC\Controller\Index;
use IndexView;

class Router
{
    public static async function route(string $method, string $uri): Awaitable<void>
    {
        if ($uri === '/') {
            await self::_getIndexController()->render();
        } else {
            echo 'error';
        }
    }

    private static function _getIndexController(): Index
    {
        return new Index(self::_getIndexView());
    }

    private static function _getIndexView(): IndexView
    {
        return new IndexView();
    }
}
