<?hh // strict

use PLC\Module\Error\Model;

/**
 * View for index page.
 */
class ErrorView extends View<Model> implements Viewable
{
    public function __construct()
    {
        parent::__construct(Model::class);
    }

    protected function _render(Model $model): :xhp
    {
        return
            <plc:layout title="Startseite">
                <h1>Alle Artikel</h1>
            </plc:layout>;
    }
}
