<?hh // strict

namespace PLC\Controller\Extension;

use PLC\Controller\Controllable;
use PLC\Exception\Forbidden;
use PLC\Model\User as UserModel;
use PLC\Service\Session;

trait Authentication
{
    require implements Controllable;

    private async function _getLoggedInUser(Session $sessionService): Awaitable<UserModel>
    {
        $currentUser = await $sessionService->getLoggedInUser();
        if ($currentUser === null) {
            throw new Forbidden();
        }
        return $currentUser;
    }
}
