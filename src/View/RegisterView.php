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
            <plc:layout title="Registrieren">
                <h1>Registrieren</h1>
                <form action="/register" method="post">
                    {$this->_errors($model->getErrors())}
                    {$this->_success($model->isSuccess())}
                    {$this->_formRow('username', 'Username', $user?->getUsername(), false)}
                    {$this->_formRow('fullname', 'Voller Name', $user?->getFullname(), false)}
                    {$this->_formRow('password', 'Passwort', null, true)}
                    {$this->_formRow('password_repeat', 'Wiederhole Passwort', null, true)}
                    <button type="submit" name="submit">Registrieren</button>
                </form>
            </plc:layout>;
    }

    private function _errors(?Vector<string> $errors): :xhp
    {
        if ($errors === null || $errors->isEmpty()) {
            return <x:frag />;
        }

        $result = <ul />;

        foreach ($errors as $error) {
            $result->appendChild(
                <li>{$error}</li>
            );
        }

        return <div class="error">{$result}</div>;
    }

    private function _formRow(string $name, string $label, ?Stringish $value, bool $isPassword): :xhp
    {
        $type = $isPassword ? 'password' : 'text';

        return
            <x:frag>
                <label for={$name}>{$label}</label>
                <input type={$type} id={$name} name={$name} value={$value} />
            </x:frag>;
    }

    private function _success(bool $isSuccess): :xhp
    {
        if (!$isSuccess) {
            return <x:frag />;
        }

        return
            <p class="success">
                Registrierung erfolgreich. <a href="/login">Login</a>.
            </p>;
    }
}
