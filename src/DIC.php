<?hh // strict

namespace PLC;

use AsyncMysqlConnection;
use AsyncMysqlConnectionPool;
use Exception;

use AdminView;
use ArticleView;
use ErrorView;
use IndexView;
use LoginView;
use RegisterView;
use Viewable;

use PLC\Controller\Controllable;
use PLC\Module\Admin\Controller as AdminController;
use PLC\Module\Article\Controller as ArticleController;
use PLC\Module\Delete\Controller as DeleteController;
use PLC\Module\Error\Controller as ErrorController;
use PLC\Module\Index\Controller as IndexController;
use PLC\Module\Login\Controller as LoginController;
use PLC\Module\Register\Controller as RegisterController;
use PLC\Service\Article;
use PLC\Service\Session as SessionService;
use PLC\Service\User as UserService;
use PLC\Util\Globals;
use PLC\Validator\Login as LoginValidator;
use PLC\Validator\User as UserValidator;

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


    public async function getAdminController(): Awaitable<Controllable>
    {
        $articleService = await $this->_getArticleService();
        $sessionService = await $this->_getSessionService();

        return new AdminController(new AdminView(), $articleService, $sessionService);
    }

    public async function getArticleController(): Awaitable<Controllable>
    {
        $articleService = await $this->_getArticleService();

        return new ArticleController(new ArticleView(), $this->getGlobalsUtil(), $articleService);
    }

    public async function getDeleteController(): Awaitable<Controllable>
    {
        $articleService = await $this->_getArticleService();
        $sessionService = await $this->_getSessionService();

        return new DeleteController($this->getGlobalsUtil(), $articleService, $sessionService);
    }

    public function getErrorController(Exception $exception): Controllable
    {
        return new ErrorController(new ErrorView(), $exception);
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
        $sessionService = await $this->_getSessionService($userService);

        return new LoginController(
            new LoginView(),
            $userService,
            $this->getGlobalsUtil(),
            $loginValidator,
            $sessionService
        );
    }

    public async function getRegisterController(): Awaitable<Controllable>
    {
        $userService   = await $this->_getUserService();
        $userValidator = await $this->_getUserValidator($userService);

        return new RegisterController(
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

    private async function _getSessionService(?UserService $userService = null): Awaitable<SessionService>
    {
        if ($userService === null) {
            $userService = await $this->_getUserService();
        }

        return new SessionService($this->getGlobalsUtil(), $userService);
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
