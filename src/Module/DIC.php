<?hh // strict

namespace PLC\Module;

use Exception;

use AdminView;
use ArticleView;
use EditView;
use ErrorView;
use IndexView;
use LoginView;
use RegisterView;

use PLC\Controller\Controllable;
use PLC\Module\Admin\Controller as AdminController;
use PLC\Module\Article\Controller as ArticleController;
use PLC\Module\Delete\Controller as DeleteController;
use PLC\Module\Edit\Controller as EditController;
use PLC\Module\Error\Controller as ErrorController;
use PLC\Module\Index\Controller as IndexController;
use PLC\Module\Login\Controller as LoginController;
use PLC\Module\Register\Controller as RegisterController;

use PLC\Service\DIC as ServiceDIC;
use PLC\Util\DIC as UtilDIC;
use PLC\Validator\DIC as ValidatorDIC;

/**
 * Dependency injection container
 *
 * Provides getter for controllers with all dependencies injected.
 */
class DIC
{
    public function __construct(
        private ServiceDIC $_serviceDIC,
        private UtilDIC $_utilDIC,
        private ValidatorDIC $_validatorDIC
    )
    {}

    public async function getAdminController(): Awaitable<Controllable>
    {
        $asioUtil = $this->_utilDIC->getAsio();

        list($articleService, $sessionService) = await $asioUtil->batch(
            $this->_serviceDIC->getArticle(),
            $this->_serviceDIC->getSession()
        );

        return new AdminController(new AdminView(), $articleService, $sessionService);
    }

    public async function getArticleController(): Awaitable<Controllable>
    {
        $articleService = await $this->_serviceDIC->getArticle();

        return new ArticleController(new ArticleView(), $articleService, $this->_utilDIC->getGlobals());
    }

    public async function getDeleteController(): Awaitable<Controllable>
    {
        $asioUtil = $this->_utilDIC->getAsio();

        list($articleService, $sessionService) = await $asioUtil->batch(
            $this->_serviceDIC->getArticle(),
            $this->_serviceDIC->getSession()
        );

        return new DeleteController(
            $articleService,
            $sessionService,
            $asioUtil,
            $this->_utilDIC->getGlobals()
        );
    }

    public async function getEditController(): Awaitable<Controllable>
    {
        $asioUtil = $this->_utilDIC->getAsio();

        list($articleService, $sessionService) = await $asioUtil->batch(
            $this->_serviceDIC->getArticle(),
            $this->_serviceDIC->getSession()
        );

        return new EditController(
            new EditView(),
            $articleService,
            $this->_serviceDIC->getMarkdown(),
            $sessionService,
            $this->_validatorDIC->getArticle(),
            $asioUtil,
            $this->_utilDIC->getGlobals()
        );
    }

    public function getErrorController(Exception $exception): Controllable
    {
        return new ErrorController(new ErrorView(), $exception);
    }

    public async function getIndexController(): Awaitable<Controllable>
    {
        $articleService = await $this->_serviceDIC->getArticle();

        return new IndexController(new IndexView(), $articleService);
    }

    public async function getLoginController(): Awaitable<Controllable>
    {
        $asioUtil = $this->_utilDIC->getAsio();

        list($sessionService, $userService, $loginValidator) = await $asioUtil->batchThree(
            $this->_serviceDIC->getSession(),
            $this->_serviceDIC->getUser(),
            $this->_validatorDIC->getLogin()
        );

        return new LoginController(
            new LoginView(),
            $sessionService,
            $userService,
            $loginValidator,
            $this->_utilDIC->getGlobals()
        );
    }

    public async function getRegisterController(): Awaitable<Controllable>
    {
        $asioUtil = $this->_utilDIC->getAsio();

        list($userService, $userValidator) = await $asioUtil->batch(
            $this->_serviceDIC->getUser(),
            $this->_validatorDIC->getUser()
        );

        return new RegisterController(
            new RegisterView(),
            $userService,
            $userValidator,
            $this->_utilDIC->getGlobals()
        );
    }
}
