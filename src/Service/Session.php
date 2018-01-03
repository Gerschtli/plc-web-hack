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

    /**
     * Returns user model instance of logged in user.
     *
     * @return ?UserModel  Logged in user
     */
    public async function getLoggedInUser(): Awaitable<?UserModel>
    {
        $session = $this->_globals->getSession();

        if (!$session->containsKey(self::KEY)) {
            return null;
        }

        $value = $session[self::KEY];

        return $value instanceof UserModel ? $value : null;
    }

    /**
     * Returns if current user is logged in.
     * @return boolean If current user is logged in
     */
    public async function isLoggedIn(): Awaitable<bool>
    {
        $user = await $this->getLoggedInUser();

        return $user !== null;
    }

    /**
     * Login user.
     *
     * @param string $username  Username
     */
    public async function logInUser(string $username): Awaitable<void>
    {
        $user = await $this->_userService->findByUsername($username);
        $this->_globals->setSession(self::KEY, $user);
    }

    /**
     * Logout user.
     */
    public function logOutUser(): void
    {
        $this->_globals->setSession(self::KEY, null);
    }
}
