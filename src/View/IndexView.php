<?hh // strict

class IndexView implements Viewable
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
