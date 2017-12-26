<?hh // strict

namespace PLC;

use AsyncMysqlConnection;
use AsyncMysqlConnectionPool;
use ExceptionView;
use ForbiddenView;
use IndexView;
use LoginView;
use NotFoundView;
use PLC\Controller\Controllable;
use PLC\Controller\Login;
use PLC\Controller\PassThru;
use PLC\Controller\Register;
use PLC\Module\Index\Controller as IndexController;
use PLC\Service\Article;
use PLC\Service\User as UserService;
use PLC\Util\Globals;
use PLC\Validator\Login as LoginValidator;
use PLC\Validator\User as UserValidator;
use RegisterView;
use Viewable;

/**
 * Dependency injection container
 *
 * Provides getter for controller with all instances needed.
 */
class DIC
{
    private ?AsyncMysqlConnectionPool $_mysqlConnectionPool;

    public function getGlobalsUtil(): Globals
    {
        return new Globals();
    }


    public function getExceptionController(): Controllable
    {
        return new PassThru(new ExceptionView());
    }

    public function getForbiddenController(): Controllable
    {
        return new PassThru(new ForbiddenView());
    }

    public async function getIndexController(): Awaitable<Controllable>
    {
        $articleService = await $this->_getArticleService();

        return new IndexController(new IndexView(), $articleService);
    }

    public async function getLoginController(): Awaitable<Controllable>
    {
        $userService    = await $this->_getUserService();
        $loginValidator = await $this->_getLoginValidator($userService);

        return new Login(new LoginView(), $userService, $this->getGlobalsUtil(), $loginValidator);
    }

    public function getNotFoundController(): Controllable
    {
        return new PassThru(new NotFoundView());
    }

    public async function getRegisterController(): Awaitable<Controllable>
    {
        $userService   = await $this->_getUserService();
        $userValidator = await $this->_getUserValidator($userService);

        return new Register(
            new RegisterView(),
            $userService,
            $this->getGlobalsUtil(),
            $userValidator
        );
    }


    private async function _getArticleService(): Awaitable<Article>
    {
        $connection = await $this->_getMysqlConnection();

        return new Article($connection);
    }

    private async function _getUserService(): Awaitable<UserService>
    {
        $connection = await $this->_getMysqlConnection();

        return new UserService($connection);
    }


    private async function _getLoginValidator(?UserService $userService = null): Awaitable<LoginValidator>
    {
        if ($userService === null) {
            $userService = await $this->_getUserService();
        }

        return new LoginValidator($userService);
    }

    private async function _getUserValidator(?UserService $userService = null): Awaitable<UserValidator>
    {
        if ($userService === null) {
            $userService = await $this->_getUserService();
        }

        return new UserValidator($userService);
    }


    private function _getMysqlConnection(): Awaitable<AsyncMysqlConnection>
    {
        return $this->_getMysqlConnectionPool()->connect(
            Config::HOST,
            Config::PORT,
            Config::DB,
            Config::USER,
            Config::PASSWORD
        );
    }

    private function _getMysqlConnectionPool(): AsyncMysqlConnectionPool
    {
        // open only one connection pool
        if ($this->_mysqlConnectionPool === null) {
            $this->_mysqlConnectionPool = new AsyncMysqlConnectionPool(['pool_connection_limit' => 100]);
        }

        return $this->_mysqlConnectionPool;
    }
}
