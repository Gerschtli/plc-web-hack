<?hh // strict

namespace PLC\Exception;

use Exception;

/**
 * Exception for 302 redirect.
 */
class Redirect extends ResponseCode
{
    public function __construct(private string $_uri)
    {
        parent::__construct(self::HTTP_FOUND);
    }

    public function getUri(): string
    {
        return $this->_uri;
    }
}
