<?hh // strict

use PLC\Model\View\Model;

abstract class View<T as Model>
{
    public function __construct(private classname<T> $_cls)
    {}

    public function render(Model $model): :xhp
    {
        return $this->_render(
            $this->_castModel($model)
        );
    }

    private function _castModel(Model $model): T
    {
        invariant($model instanceof $this->_cls, 'Not the right View Model');
        return $model;
    }

    protected abstract function _render(T $model): :xhp;
}
