<?hh // strict

use PLC\Module\Error\Model;

/**
 * View for error page.
 */
class ErrorView extends BaseView<Model> implements Viewable
{
    public function __construct()
    {
        parent::__construct(Model::class);
    }

    protected function _render(Model $model): :xhp
    {
        return
            <plc:layout title={(string) $model->getCode()}>
                <h1>{$model->getCode()} - {$model->getMessage()}</h1>
                <pre>{print_r($model->getException(), true)}</pre>
            </plc:layout>;
    }
}
