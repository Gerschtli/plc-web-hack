<?hh // strict

use PLC\Model\View\Register;
use PLC\Module\Register\Model;

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
                    {$this->_renderFormRow('username', 'Username', false, $user?->getUsername())}
                    {$this->_renderFormRow('fullname', 'Voller Name', false, $user?->getFullname())}
                    {$this->_renderFormRow('password', 'Passwort', true)}
                    {$this->_renderFormRow('password_repeat', 'Wiederhole Passwort', true)}
                    {$this->_renderFormSubmit('Registrieren')}
                </form>
            </plc:layout>;
    }
}
