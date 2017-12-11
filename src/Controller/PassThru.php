<?hh // strict

namespace PLC\Controller;

use Viewable;

class PassThru implements Controllable
{
    public function __construct(private Viewable $view)
    {}

    public async function render(): Awaitable<void>
    {
        $this->view->render();
    }
}
