<?hh // strict

namespace PLC;

use PLC\Controller\Controllable;
use PLC\Exception\NotFound;

class Router
{
    /**
     * Calls Controller and handles Exceptions.
     */
    public static async function route(): Awaitable<void>
    {
        session_start();
        $controllable = await self::getControllable();
        await $controllable->render();
    }

    /**
     * Get Controllable object by method and uri.
     *
     * @return Controllable    Controllable instance
     */
    private static async function getControllable(): Awaitable<Controllable>
    {
        // init dependency injection container
        $dic = new DIC();

        $server = $dic->getGlobalsUtil()->getServer();
        $uri    = $server['REQUEST_URI'];

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
