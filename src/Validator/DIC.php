<?hh // strict

namespace PLC\Validator;

use PLC\Service\DIC as ServiceDIC;

/**
 * Dependency injection container
 *
 * Provides getter for validators with all dependencies injected.
 */
class DIC
{
    public function __construct(private ServiceDIC $_serviceDIC)
    {}

    public function getArticle(): Article
    {
        return new Article();
    }

    public async function getLogin(): Awaitable<Login>
    {
        $userService = await $this->_serviceDIC->getUser();

        return new Login($userService);
    }

    public async function getUser(): Awaitable<User>
    {
        $userService = await $this->_serviceDIC->getUser();

        return new User($userService);
    }
}
