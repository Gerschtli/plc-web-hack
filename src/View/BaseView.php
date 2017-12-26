<?hh // strict

use PLC\Model\View\BaseModel;

/**
 * Abstracts common methods of views.
 */
abstract class BaseView<T as BaseModel>
{
    public function __construct(private classname<T> $_cls)
    {}

    /**
     * Renders view.
     *
     * @param  BaseModel  $model  View model
     * @return :xhp               HTML page
     */
    public function render(BaseModel $model): :xhp
    {
        return $this->_render(
            $this->_castModel($model)
        );
    }

    /**
     * Asserts invariant that right view model is provided.
     *
     * @param  BaseModel  $model  View model
     * @return T                  Typed view model
     */
    private function _castModel(BaseModel $model): T
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
}
