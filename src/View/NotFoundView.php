<?hh // strict

use PLC\Model\View\BaseModel;

/**
 * View for 404 error.
 */
class NotFoundView extends View<BaseModel> implements Viewable
{
    public function __construct()
    {
        parent::__construct(BaseModel::class);
    }

    protected function _render(BaseModel $model): :xhp
    {
        return
            <plc:layout title="404">
                <h1>404 - Not Found</h1>
                <p>Seite nicht gefunden</p>
            </plc:layout>;
    }
}
