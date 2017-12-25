<?hh // strict

use PLC\Model\View\Model;

/**
 * Abstracts common methods of views.
 */
abstract class View<T as Model>
{
    public function __construct(private classname<T> $_cls)
    {}

    /**
     * Renders view.
     *
     * @param  Model  $model  View model
     * @return :xhp           HTML page
     */
    public function render(Model $model): :xhp
    {
        return $this->_render(
            $this->_castModel($model)
        );
    }

    /**
     * Asserts invariant that right view model is provided.
     *
     * @param  Model  $model  View model
     * @return T              Typed view model
     */
    private function _castModel(Model $model): T
    {
        invariant($model instanceof $this->_cls, 'Not the right View Model');
        return $model;
    }

    /**
     * Renders view providing the typed view model object.
     *
     * @param  T      $model  View model
     * @return :xhp           HTML page
     */
    protected abstract function _render(T $model): :xhp;

    protected function _renderErrors(?Vector<string> $errors): :xhp
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

    protected function _renderFormRow(string $name, string $label, bool $isPassword, ?Stringish $value = null): :xhp
    {
        $type = $isPassword ? 'password' : 'text';

        return
            <x:frag>
                <label for={$name}>{$label}</label>
                <input type={$type} id={$name} name={$name} value={$value} />
            </x:frag>;
    }

    protected function _renderFormSubmit(string $value): :xhp
    {
        return <button type="submit" name="submit">{$value}</button>;
    }

    protected function _renderSuccess(bool $isSuccess, :xhp $message): :xhp
    {
        if (!$isSuccess) {
            return <x:frag />;
        }

        return <p class="success">{$message}</p>;
    }
}
