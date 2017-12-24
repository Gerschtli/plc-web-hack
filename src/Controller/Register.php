<?hh // strict

namespace PLC\Controller;

use PLC\Model\User as UserModel;
use PLC\Model\View\Model;
use PLC\Model\View\Register as RegisterModel;
use PLC\Service\User as UserService;
use PLC\Util\Globals;
use PLC\Validator\User as UserValidator;
use Viewable;

/**
 * Renders register page of blog.
 */
class Register extends Controller implements Controllable
{
    public function __construct(
        Viewable $view,
        private UserService $_userService,
        private Globals $_globals,
        private UserValidator $_userValidator
    )
    {
        parent::__construct($view);
    }

    <<__Override>>
    protected async function _buildModel(): Awaitable<Model>
    {
        $post = $this->_globals->getPost();

        $user    = null;
        $errors  = null;
        $success = false;

        if ($post->containsKey('submit')) {
            $user = new UserModel();
            $user->setUsername($post['username']);
            $user->setFullname($post['fullname']);
            $user->setPassword($post['password']);
            $user->setPasswordRepeat($post['password_repeat']);

            $errors = await $this->_userValidator->validate($user);

            if ($errors->isEmpty()) {
                $success = true;
                await $this->_userService->save($user);
                $user = null;
            }
        }

        return new RegisterModel($user, $errors, $success);
    }
}
