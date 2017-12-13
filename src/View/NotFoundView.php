<?hh // strict

/**
 * View for 404 error
 */
class NotFoundView extends View implements Viewable
{
    public function render(): :xhp
    {
        return
            <plc:layout title="404">
                <h1>404 - Not Found</h1>
                <p>Seite nicht gefunden</p>
            </plc:layout>;
    }
}
