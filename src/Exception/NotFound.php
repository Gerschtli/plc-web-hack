<?hh // strict

namespace PLC\Exception;

use Exception;

/**
 * Exception thrown if an 404 occures.
 */
class NotFound extends ResponseCode
{
    public function __construct()
    {
        parent::__construct(self::HTTP_NOT_FOUND);
    }
}
