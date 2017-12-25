<?hh // strict

namespace PLC\Exception;

use Exception;

/**
 * Exception thrown if an 403 occures.
 */
class Forbidden extends ResponseCode
{
    public function __construct()
    {
        parent::__construct(self::HTTP_FORBIDDEN);
    }
}
