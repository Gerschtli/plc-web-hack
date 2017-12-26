<?hh // strict

use PLC\Model\View\BaseModel;

/**
 * View for 500 error.
 */
class ExceptionView extends View<BaseModel> implements Viewable
{
    public function __construct()
    {
        parent::__construct(BaseModel::class);
    }

    protected function _render(BaseModel $model): :xhp
    {
        return
            <plc:layout title="500">
                <h1>500 - Interal Server Error</h1>
                <p>Seite kaputt</p>
            </plc:layout>;
    }
}
