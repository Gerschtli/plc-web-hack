<?hh // strict

namespace PLC\Controller;

use PLC\Model\View\BaseModel;
use Viewable;

/**
 * Abstracts common methods of controllers.
 */
abstract class BaseController
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
    protected async function _buildModel(): Awaitable<BaseModel>
    {
        return new BaseModel();
    }
}
