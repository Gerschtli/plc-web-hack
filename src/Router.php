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
            await $dic->getModule()->getErrorController($exception)->render();
        }
    }

    /**
     * Get Controllable object by method and uri.
     *
     * @return Controllable  Controllable instance
     */
    private static async function getControllable(DIC $dic): Awaitable<Controllable>
    {
        $server = $dic->getUtil()->getGlobals()->getServer();
        $uri    = $server['DOCUMENT_URI'];

        $moduleDIC = $dic->getModule();

        if ($uri === '/') {
            return await $moduleDIC->getIndexController();
        }
        if ($uri === '/article') {
            return await $moduleDIC->getArticleController();
        }
        if ($uri === '/register') {
            return await $moduleDIC->getRegisterController();
        }
        if ($uri === '/login') {
            return await $moduleDIC->getLoginController();
        }
        if ($uri === '/admin') {
            return await $moduleDIC->getAdminController();
        }
        if ($uri === '/admin/edit') {
            return await $moduleDIC->getEditController();
        }
        if ($uri === '/admin/delete') {
            return await $moduleDIC->getDeleteController();
        }

        throw new NotFound();
    }
}
