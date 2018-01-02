<?hh // strict

namespace PLC\Controller;

use PLC\Model\View\BaseModel;
use PLC\Util\ResponseCode;
use Viewable;

/**
 * Abstracts common methods of controllers.
 */
abstract class ViewController extends BaseController
{
    public function __construct(protected Viewable $_view)
    {}

    /**
     * Renders the page.
     */
    public async function render(): Awaitable<void>
    {
        $model = await $this->_buildModel();
        echo $this->_view->render($model);
    }

    /**
     * Builds the model passed to the viewable.
     */
    abstract protected function _buildModel(): Awaitable<BaseModel>;
}
