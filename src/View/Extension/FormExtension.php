<?hh // strict

use PLC\Model\View\BaseModel;

/**
 * Abstracts common methods of views.
 */
trait FormExtension
{
    require implements Viewable;

    private function _renderErrors(Vector<string> $errors): :xhp
    {
        if ($errors->isEmpty()) {
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

    private function _renderFormRow(string $name, string $label, bool $isPassword, ?Stringish $value = null): :xhp
    {
        $type = $isPassword ? 'password' : 'text';

        return
            <x:frag>
                <label for={$name}>{$label}</label>
                <input type={$type} id={$name} name={$name} value={$value} />
            </x:frag>;
    }

    private function _renderFormSubmit(string $value): :xhp
    {
        return <button type="submit" name="submit">{$value}</button>;
    }

    private function _renderSuccess(bool $isSuccess, :xhp $message): :xhp
    {
        if (!$isSuccess) {
            return <x:frag />;
        }

        return <p class="success">{$message}</p>;
    }
}
