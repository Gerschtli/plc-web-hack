<?hh // strict

use PLC\Model\View\Model;
use PLC\Model\View\NoData;

/**
 * View for 404 error
 */
class NotFoundView extends View<Model> implements Viewable
{
    public function __construct()
    {
        parent::__construct(NoData::class);
    }

    public function render(Model $model): :xhp
    {
        return
            <plc:layout title="404">
                <h1>404 - Not Found</h1>
                <p>Seite nicht gefunden</p>
            </plc:layout>;
    }
}
