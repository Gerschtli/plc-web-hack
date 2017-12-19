<?hh // strict

use PLC\Model\View\Model;

abstract class View<T as Model>
{
    public function __construct(private classname<T> $_cls)
    {}

    protected function _castModel(Model $model): T
    {
        invariant($model instanceof $this->_cls, "Not Child");
        return $model;
    }
}
