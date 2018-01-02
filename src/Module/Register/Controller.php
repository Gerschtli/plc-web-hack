<?hh // strict

namespace PLC\Module\Register;

use PLC\Controller\ViewController;
use PLC\Controller\Controllable;
use PLC\Controller\Extension\Form;
use PLC\Model\User as UserModel;
use PLC\Model\View\BaseModel;
use PLC\Model\View\Register as RegisterModel;
use PLC\Service\User as UserService;
use PLC\Util\Globals;
use PLC\Validator\User as UserValidator;
use Viewable;

/**
 * Renders register page of blog.
 */
class Controller extends ViewController implements Controllable
{
    use Form<UserModel>;

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
    protected async function _buildModel(): Awaitable<BaseModel>
    {
        $formResult = await $this->_handleForm(
            $this->_globals,
            $this->_userValidator,
            $post ==> {
                $user = new UserModel();
                $user->setUsername($post['username']);
                $user->setFullname($post['fullname']);
                $user->setPassword($post['password']);
                $user->setPasswordRepeat($post['password_repeat']);

                return $user;
            },
            async $model ==> {
                await $this->_userService->save($model);
            }
        );

        $preFilledData = null;
        if (!$formResult['success']) {
            $preFilledData = $formResult['model'];
        }

        return new Model($preFilledData, $formResult['errors'], $formResult['success']);
    }
}
