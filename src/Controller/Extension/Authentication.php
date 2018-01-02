<?hh // strict

namespace PLC\Controller\Extension;

use PLC\Controller\Controllable;
use PLC\Exception\Forbidden;
use PLC\Model\User as UserModel;
use PLC\Service\Session;

/**
 * Controller extension for authentication support.
 */
trait Authentication
{
    require implements Controllable;

    /**
     * Returns logged in user or throws forbidden exception.
     *
     * @param  Session $sessionService  Session service
     * @return UserModel                Logged in user
     */
    private async function _getLoggedInUser(Session $sessionService): Awaitable<UserModel>
    {
        $currentUser = await $sessionService->getLoggedInUser();
        if ($currentUser === null) {
            throw new Forbidden();
        }
        return $currentUser;
    }
}
