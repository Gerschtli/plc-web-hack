<?hh // strict

namespace PLC\Controller;

use PLC\Model\View\BaseModel;
use PLC\Util\ResponseCode;
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

    protected function _redirectTo(string $uri): void
    {
        $this->_setResponseCode(ResponseCode::FOUND);
        header("Location:{$uri}");
        exit();
    }

    protected function _setResponseCode(ResponseCode $code): void
    {
        http_response_code($code);
    }
}
