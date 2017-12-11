<?hh // strict

namespace PLC;

use PLC\Controller\Controllable;
use PLC\Exception\NotFound;

class Router
{
    public static async function route(string $method, string $uri): Awaitable<void>
    {
        await self::getControllable($method, $uri)->render();
    }

    private static function getControllable(string $method, string $uri): Controllable
    {
        $dic = new DIC();

        try {
            if ($uri === '/') {
                return $dic->getIndexController();
            } else {
                throw new NotFound();
            }
        } catch (NotFound $exception) {
            return $dic->getNotFoundController();
        }
    }
}
