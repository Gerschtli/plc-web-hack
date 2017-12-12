<?hh // strict

/**
 * View for 404 error
 */
class NotFoundView extends View implements Viewable
{
    public function render(): void
    {
        echo
            <plc:layout title="404">
                <div>
                    <h1>404 - Not Found</h1>
                    <p>Seite nicht gefunden</p>
                </div>
            </plc:layout>;
    }
}
