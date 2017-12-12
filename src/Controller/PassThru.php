<?hh // strict

namespace PLC\Controller;

use Viewable;

/**
 * PassThru Controller
 *
 * Delegates render call straight to provided view.
 */
class PassThru implements Controllable
{
    public function __construct(private Viewable $view)
    {}

    public async function render(): Awaitable<void>
    {
        $this->view->render();
    }
}
