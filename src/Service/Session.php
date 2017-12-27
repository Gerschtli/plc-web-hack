<?hh

namespace PLC\Service;

use PLC\Model\User as UserModel;
use PLC\Util\Globals;

class Session
{
    const string KEY = 'login';

    public function __construct(
        private Globals $_globals,
        private User $_userService
    )
    {}

    public async function logInUser(string $username): Awaitable<void>
    {
        $user = await $this->_userService->findByUsername($username);
        $this->_globals->setSession(self::KEY, $user);
    }

    public async function getLoggedInUser(): Awaitable<?UserModel>
    {
        $session = $this->_globals->getSession();

        if (!$session->containsKey(self::KEY)) {
            return null;
        }

        $value = $session[self::KEY];

        return $value instanceof UserModel ? $value : null;
    }
}
