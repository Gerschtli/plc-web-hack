<?hh // strict

namespace PLC\Controller;

use IndexView;

class Index implements Controllable
{
    public function __construct(private IndexView $indexView)
    {}

    public async function render(): Awaitable<void>
    {
        $this->indexView->render();
    }
}
