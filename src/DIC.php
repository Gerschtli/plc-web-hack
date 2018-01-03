<?hh // strict

namespace PLC;

use AsyncMysqlConnection;
use AsyncMysqlConnectionPool;
use Exception;

use AdminView;
use ArticleView;
use EditView;
use ErrorView;
use IndexView;
use LoginView;
use RegisterView;
use Viewable;

use PLC\Controller\Controllable;
use PLC\Module\Admin\Controller as AdminController;
use PLC\Module\Article\Controller as ArticleController;
use PLC\Module\Delete\Controller as DeleteController;
use PLC\Module\Edit\Controller as EditController;
use PLC\Module\Error\Controller as ErrorController;
use PLC\Module\Index\Controller as IndexController;
use PLC\Module\Login\Controller as LoginController;
use PLC\Module\Register\Controller as RegisterController;
use PLC\Service\Article as ArticleService;
use PLC\Service\Markdown as MarkdownService;
use PLC\Service\Session as SessionService;
use PLC\Service\User as UserService;
use PLC\Util\Globals;
use PLC\Validator\Article as ArticleValidator;
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

        return new ArticleController(new ArticleView(), $articleService, $this->getGlobalsUtil());
    }

    public async function getDeleteController(): Awaitable<Controllable>
    {
        $articleService = await $this->_getArticleService();
        $sessionService = await $this->_getSessionService();

        return new DeleteController($articleService, $sessionService, $this->getGlobalsUtil());
    }

    public async function getEditController(): Awaitable<Controllable>
    {
        $articleService = await $this->_getArticleService();
        $sessionService = await $this->_getSessionService();

        return new EditController(
            new EditView(),
            $articleService,
            $this->_getMarkdownService(),
            $sessionService,
            $this->_getArticleValidator(),
            $this->getGlobalsUtil()
        );
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
            $sessionService,
            $userService,
            $loginValidator,
            $this->getGlobalsUtil()
        );
    }

    public async function getRegisterController(): Awaitable<Controllable>
    {
        $userService   = await $this->_getUserService();
        $userValidator = await $this->_getUserValidator($userService);

        return new RegisterController(
            new RegisterView(),
            $userService,
            $userValidator,
            $this->getGlobalsUtil()
        );
    }


    private async function _getArticleService(): Awaitable<ArticleService>
    {
        $connection = await $this->_getMysqlConnection();

        return new ArticleService($connection);
    }

    private function _getMarkdownService(): MarkdownService
    {
        return new MarkdownService();
    }

    private async function _getSessionService(?UserService $userService = null): Awaitable<SessionService>
    {
        if ($userService === null) {
            $userService = await $this->_getUserService();
        }

        return new SessionService($userService, $this->getGlobalsUtil());
    }

    private async function _getUserService(): Awaitable<UserService>
    {
        $connection = await $this->_getMysqlConnection();

        return new UserService($connection);
    }


    private function _getArticleValidator(): ArticleValidator
    {
        return new ArticleValidator();
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
