<?hh // strict

use PLC\Model\View\Register;
use PLC\Module\Register\Model;
use PLC\Util\InputType;

/**
 * View for register.
 */
class RegisterView extends BaseView<Model> implements Viewable
{
    use FormExtension;

    public function __construct()
    {
        parent::__construct(Model::class);
    }

    protected function _render(Model $model): :xhp
    {
        $user = $model->getUser();

        return
            <plc:layout title="Registrieren">
                <h1>Registrieren</h1>
                <form action="/register" method="post">
                    {$this->_renderErrors($model->getErrors())}
                    {$this->_renderSuccess(
                        $model->isSuccess(),
                        <x:frag>
                            Registrierung erfolgreich. <a href="/login">Login</a>.
                        </x:frag>
                    )}
                    {$this->_renderFormRow('username', 'Username', InputType::ONE_LINE_TEXT, $user?->getUsername())}
                    {$this->_renderFormRow('fullname', 'Voller Name', InputType::ONE_LINE_TEXT, $user?->getFullname())}
                    {$this->_renderFormRow('password', 'Passwort', InputType::PASSWORD)}
                    {$this->_renderFormRow('password_repeat', 'Wiederhole Passwort', InputType::PASSWORD)}
                    {$this->_renderFormSubmit('Registrieren')}
                </form>
            </plc:layout>;
    }
}
