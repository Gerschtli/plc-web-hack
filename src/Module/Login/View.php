<?hh // strict

use PLC\Model\View\Login;
use PLC\Module\Login\Model;

/**
 * View for login.
 */
class LoginView extends View<Model> implements Viewable
{
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
                    {$this->_renderFormRow('username', 'Username', false)}
                    {$this->_renderFormRow('password', 'Passwort', true)}
                    {$this->_renderFormSubmit('Anmelden')}
                </form>
            </plc:layout>;
    }
}
