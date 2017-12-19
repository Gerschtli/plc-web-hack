<?hh // strict

use PLC\Model\View\NoData;

/**
 * View for 404 error.
 */
class NotFoundView extends View<NoData> implements Viewable
{
    public function __construct()
    {
        parent::__construct(NoData::class);
    }

    protected function _render(NoData $model): :xhp
    {
        return
            <plc:layout title="404">
                <h1>404 - Not Found</h1>
                <p>Seite nicht gefunden</p>
            </plc:layout>;
    }
}
