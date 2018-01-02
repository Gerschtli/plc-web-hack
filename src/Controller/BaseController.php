<?hh // strict

namespace PLC\Controller;

use PLC\Util\ResponseCode;

/**
 * Provides util methods of controllers.
 */
abstract class BaseController
{
    /**
     * Redirect to URI.
     *
     * @param  string $uri  URI
     */
    protected function _redirectTo(string $uri): void
    {
        $this->_setResponseCode(ResponseCode::FOUND);
        header("Location:{$uri}");
        exit();
    }

    /**
     * Set response code.
     *
     * @param ResponseCode $code  Response code
     */
    protected function _setResponseCode(ResponseCode $code): void
    {
        http_response_code($code);
    }
}
