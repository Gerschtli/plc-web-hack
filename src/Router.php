<?hh // strict

namespace PLC;

use Exception;
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

        // init dependency injection container
        $dic = new DIC();

        try {
            $controllable = await self::getControllable($dic);
            await $controllable->render();
        } catch (Exception $exception) {
            await $dic->getErrorController($exception)->render();
        }
    }

    /**
     * Get Controllable object by method and uri.
     *
     * @return Controllable  Controllable instance
     */
    private static async function getControllable(DIC $dic): Awaitable<Controllable>
    {
        $server = $dic->getGlobalsUtil()->getServer();
        $uri    = $server['DOCUMENT_URI'];

        if ($uri === '/') {
            return await $dic->getIndexController();
        }
        if ($uri === '/article') {
            return await $dic->getArticleController();
        }
        if ($uri === '/register') {
            return await $dic->getRegisterController();
        }
        if ($uri === '/login') {
            return await $dic->getLoginController();
        }
        if ($uri === '/admin') {
            return await $dic->getAdminController();
        }
        if ($uri === '/admin/edit') {
            return await $dic->getEditController();
        }
        if ($uri === '/admin/delete') {
            return await $dic->getDeleteController();
        }

        throw new NotFound();
    }
}
