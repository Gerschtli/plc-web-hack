<?hh // strict

use PLC\Model\View\NoData;

/**
 * View for 403 error.
 */
class ForbiddenView extends View<NoData> implements Viewable
{
    public function __construct()
    {
        parent::__construct(NoData::class);
    }

    protected function _render(NoData $model): :xhp
    {
        return
            <plc:layout title="403">
                <h1>403 - Forbidden</h1>
                <p>Sie sind nicht berechtigt, diese Seite zu sehen.</p>
            </plc:layout>;
    }
}
