<?hh // strict

use PLC\Model\View\Login;

/**
 * View for login.
 */
class LoginView extends View<Login> implements Viewable
{
    public function __construct()
    {
        parent::__construct(Login::class);
    }

    protected function _render(Login $model): :xhp
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
