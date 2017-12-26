<?hh // strict

use PLC\Model\View\BaseModel;

/**
 * View for 403 error.
 */
class ForbiddenView extends View<BaseModel> implements Viewable
{
    public function __construct()
    {
        parent::__construct(BaseModel::class);
    }

    protected function _render(BaseModel $model): :xhp
    {
        return
            <plc:layout title="403">
                <h1>403 - Forbidden</h1>
                <p>Sie sind nicht berechtigt, diese Seite zu sehen.</p>
            </plc:layout>;
    }
}
