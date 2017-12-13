<?hh // strict

/**
 * View for index page
 */
class IndexView extends View implements Viewable
{
    public function render(): :xhp
    {
        return
            <plc:layout title="Startseite">
                <strong>hallo</strong>
            </plc:layout>;
    }
}
