<?hh // strict

/**
 * View for index page
 */
class IndexView extends View implements Viewable
{
    public function render(): void
    {
        echo
            <plc:layout title="Startseite">
                <div>
                    <strong>hallo</strong>
                </div>
            </plc:layout>;
    }
}
