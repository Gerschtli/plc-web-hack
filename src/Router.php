<?hh // strict

namespace PLC;

use PLC\Controller\Controllable;
use PLC\Exception\Forbidden;
use PLC\Exception\NotFound;
use PLC\Exception\Redirect;
use PLC\Exception\ResponseCode;
use Exception;

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
        } catch (Redirect $exception) {
            self::_setResponseCode($exception);
            header("Location:{$exception->getUri()}");
            exit();
        } catch (Forbidden $exception) {
            self::_setResponseCode($exception);

            await $dic->getForbiddenController()->render();
        } catch (NotFound $exception) {
            self::_setResponseCode($exception);

            await $dic->getNotFoundController()->render();
        } catch (Exception $exception) {
            self::_setResponseCodeInt(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);

            await $dic->getExceptionController()->render();
        }
    }

    /**
     * Get Controllable object by method and uri.
     *
     * @return Controllable    Controllable instance
     */
    private static async function getControllable(DIC $dic): Awaitable<Controllable>
    {
        $server = $dic->getGlobalsUtil()->getServer();
        $uri    = $server['REQUEST_URI'];

        if ($uri === '/') {
            return await $dic->getIndexController();
        }
        if ($uri === '/register') {
            return await $dic->getRegisterController();
        }
        if ($uri === '/login') {
            return await $dic->getLoginController();
        }

        throw new NotFound();
    }

    private static function _setResponseCodeInt(int $responseCode): void
    {
        http_response_code($responseCode);
    }

    private static function _setResponseCode(ResponseCode $responseCode): void
    {
        self::_setResponseCodeInt($responseCode->getResponseCode());
    }
}
