<?hh // strict

use PLC\Model\View\Register;

/**
 * View for register.
 */
class RegisterView extends View<Register> implements Viewable
{
    public function __construct()
    {
        parent::__construct(Register::class);
    }

    protected function _render(Register $model): :xhp
    {
        $user = $model->getUser();

        return
            <plc:layout title="Benutzer registrieren">
                <h1>Benutzer registrieren</h1>
                <form action="/register" method="post">
                    {$this->_formRow('username', 'Benutzername', $user?->getUsername(), false)}
                    {$this->_formRow('fullname', 'Voller Name', $user?->getFullname(), false)}
                    {$this->_formRow('password', 'Passwort', null, true)}
                    {$this->_formRow('password_repeat', 'Passwort wiederholden', null, true)}
                    <div>
                        <input type="submit" name="submit" value="Registrieren" />
                    </div>
                </form>
            </plc:layout>;
    }

    private function _formRow(string $name, string $label, ?Stringish $value, bool $isPassword): :xhp
    {
        $type = $isPassword ? 'password' : 'text';

        return
            <div>
                <label for={$name}>{$label}</label>
                <input type={$type} id={$name} name={$name} value={$value} />
            </div>;
    }
}
