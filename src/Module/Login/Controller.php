<?hh // strict

namespace PLC\Module\Login;

use PLC\Controller\BaseController;
use PLC\Controller\Controllable;
use PLC\Model\User as UserModel;
use PLC\Model\View\BaseModel;
use PLC\Model\View\Login as LoginModel;
use PLC\Service\User as UserService;
use PLC\Util\Globals;
use PLC\Validator\Login as LoginValidator;
use Viewable;

/**
 * Renders login page of blog.
 */
class Controller extends BaseController implements Controllable
{
    public function __construct(
        Viewable $view,
        private UserService $_userService,
        private Globals $_globals,
        private LoginValidator $_loginValidator
    )
    {
        parent::__construct($view);
    }

    <<__Override>>
    protected async function _buildModel(): Awaitable<BaseModel>
    {
        $post = $this->_globals->getPost();

        $errors = null;

        if ($post->containsKey('submit')) {
            $login = shape(
                'username' => $post['username'],
                'password' => $post['password'],
            );

            $errors = await $this->_loginValidator->validate($login);

            if ($errors->isEmpty()) {
                // TODO: login
                $this->_redirectTo('/admin');
            }
        }

        return new Model($errors);
    }
}
