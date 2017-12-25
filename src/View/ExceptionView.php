<?hh // strict

use PLC\Model\View\NoData;

/**
 * View for 500 error.
 */
class ExceptionView extends View<NoData> implements Viewable
{
    public function __construct()
    {
        parent::__construct(NoData::class);
    }

    protected function _render(NoData $model): :xhp
    {
        return
            <plc:layout title="500">
                <h1>500 - Interal Server Error</h1>
                <p>Seite kaputt</p>
            </plc:layout>;
    }
}
