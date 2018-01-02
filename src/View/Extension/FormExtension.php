<?hh // strict

use PLC\Model\View\BaseModel;
use PLC\Util\InputType;

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

    private function _renderFormRow(string $name, string $label, InputType $inputType, ?Stringish $value = null): :xhp
    {
        if ($inputType === InputType::MUTLI_LINE_TEXT) {
            $input = <textarea>{$value}</textarea>;
        } else {
            $input = <input type={$inputType} value={$value} />;
        }
        $input->setAttribute('id', $name);
        $input->setAttribute('name', $name);

        return
            <x:frag>
                <label for={$name}>{$label}</label>
                {$input}
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
