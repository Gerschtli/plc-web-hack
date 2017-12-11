<?hh // strict

class IndexView implements Viewable
{
    public function render(): void
    {
        echo
            <plc:layout>
                <div>
                    <strong>hallo</strong>
                </div>
            </plc:layout>;
    }
}
