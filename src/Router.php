<?hh // strict

namespace PLC;

use PLC\Controller\Controllable;
use PLC\Exception\NotFound;

class Router
{
    public static async function route(string $method, string $uri): Awaitable<void>
    {
        $controllable = await self::getControllable($method, $uri);
        await $controllable->render();
    }

    private static async function getControllable(string $method, string $uri): Awaitable<Controllable>
    {
        $dic = new DIC();

        try {
            if ($uri === '/') {
                return await $dic->getIndexController();
            } else {
                throw new NotFound();
            }
        } catch (NotFound $exception) {
            return $dic->getNotFoundController();
        }
    }
}
