<?hh // strict

namespace PLC;

use PLC\Controller\Controllable;
use PLC\Exception\NotFound;

class Router
{
    /**
     * Calls Controller and handles Exceptions.
     *
     * @param  string $method   HTTP Method
     * @param  string $uri      Requested URI
     */
    public static async function route(string $method, string $uri): Awaitable<void>
    {
        $controllable = await self::getControllable($method, $uri);
        await $controllable->render();
    }

    /**
     * Get Controllable object by method and uri.
     *
     * @param  string $method  HTTP Method
     * @param  string $uri     Requested URI
     * @return Controllable    Controllable instance
     */
    private static async function getControllable(string $method, string $uri): Awaitable<Controllable>
    {
        // init dependency injection container
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
