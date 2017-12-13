<?hh // strict

namespace PLC\Controller;

use Viewable;

/**
 * Abstracts common methods of controllers.
 */
abstract class Controller
{
    public function __construct(protected Viewable $_view)
    {}

    public async function render(): Awaitable<void>
    {
        await $this->_run();
        echo $this->_view->render();
    }

    protected async function _run(): Awaitable<void>
    {}
}
