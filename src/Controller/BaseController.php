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
