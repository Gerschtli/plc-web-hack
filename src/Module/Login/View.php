<?hh // strict

use PLC\Module\Login\Model;
use PLC\Util\InputType;

/**
 * View for login page.
 */
class LoginView extends BaseView<Model> implements Viewable
{
    use FormExtension;

    public function __construct()
    {
        parent::__construct(Model::class);
    }

    protected function _render(Model $model): :xhp
    {
        return
            <plc:layout title="Login">
                <h1>Login</h1>
                <form action="/login" method="post">
                    {$this->_renderErrors($model->getErrors())}
                    {$this->_renderFormRow('username', 'Username', InputType::ONE_LINE_TEXT)}
                    {$this->_renderFormRow('password', 'Passwort', InputType::PASSWORD)}
                    {$this->_renderFormSubmit('Anmelden')}
                </form>
            </plc:layout>;
    }
}
