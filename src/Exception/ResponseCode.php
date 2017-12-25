<?hh // strict

namespace PLC\Exception;

use Exception;

/**
 * Exception for providing response code.
 */
abstract class ResponseCode extends Exception
{
    const int HTTP_OK                    = 200;
    const int HTTP_FOUND                 = 302;
    const int HTTP_FORBIDDEN             = 403;
    const int HTTP_NOT_FOUND             = 404;
    const int HTTP_INTERNAL_SERVER_ERROR = 500;

    public function __construct(private int $_responseCode = self::HTTP_OK)
    {
        parent::__construct();
    }

    public function getResponseCode(): int
    {
        return $this->_responseCode;
    }
}
