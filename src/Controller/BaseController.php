<?hh // strict

namespace PLC\Controller;

use PLC\Model\View\BaseModel;
use Viewable;

/**
 * Abstracts common methods of controllers.
 */
abstract class BaseController
{
    const int HTTP_OK                    = 200;
    const int HTTP_FOUND                 = 302;
    const int HTTP_FORBIDDEN             = 403;
    const int HTTP_NOT_FOUND             = 404;
    const int HTTP_INTERNAL_SERVER_ERROR = 500;

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

    protected function _redirectTo(string $uri, int $code = self::HTTP_FOUND): void
    {
        $this->_setResponseCode($code);
        header("Location:{$uri}");
        exit();
    }

    protected function _setResponseCode(int $code): void
    {
        http_response_code($code);
    }
}
