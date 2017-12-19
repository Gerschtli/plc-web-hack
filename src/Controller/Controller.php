<?hh // strict

namespace PLC\Controller;

use PLC\Model\View\Model;
use PLC\Model\View\NoData;
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
        $model = await $this->_run();
        echo $this->_view->render($model);
    }

    protected async function _run(): Awaitable<Model>
    {
        return new NoData();
    }
}
