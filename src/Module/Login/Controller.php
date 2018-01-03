<?hh // strict

namespace PLC\Module\Login;

use PLC\Controller\ViewController;
use PLC\Controller\Controllable;
use PLC\Controller\Extension\Form;
use PLC\Model\View\BaseModel;
use PLC\Service\Session;
use PLC\Service\User as UserService;
use PLC\Util\Globals;
use PLC\Validator\Login as LoginValidator;
use Viewable;

type LoginModel = shape('username' => string, 'password' => string);

/**
 * Renders login page of blog.
 */
class Controller extends ViewController implements Controllable
{
    use Form<LoginModel>;

    public function __construct(
        Viewable $view,
        private UserService $_userService,
        private Globals $_globals,
        private LoginValidator $_loginValidator,
        private Session $_sessionService
    )
    {
        parent::__construct($view);
    }

    <<__Override>>
    protected async function _buildModel(): Awaitable<BaseModel>
    {
        $isLoggedIn = await $this->_sessionService->isLoggedIn();
        if ($isLoggedIn) {
            $get = $this->_globals->getGet();

            if ($get->containsKey('logout')) {
                $this->_sessionService->logOutUser();
            } else {
                $this->_redirectTo('/admin');
            }
        }

        $formResult = await $this->_handleForm(
            $this->_globals,
            $this->_loginValidator,
            async $post ==> shape(
                'username' => $post['username'],
                'password' => $post['password'],
            ),
            async $model ==> {
                await $this->_sessionService->logInUser($model['username']);
                $this->_redirectTo('/admin');
            }
        );

        return new Model($formResult['errors']);
    }
}
