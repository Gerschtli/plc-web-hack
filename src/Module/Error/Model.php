<?hh // strict

namespace PLC\Module\Error;

use Exception;
use PLC\Model\View\BaseModel;

/**
 * View model for error controller.
 */
class Model extends BaseModel
{
    public function __construct(private Exception $_excpetion, private int $_code, private string $_message)
    {}

    public function getCode(): int
    {
        return $this->_code;
    }

    public function getException(): Exception
    {
        return $this->_excpetion;
    }

    public function getMessage(): string
    {
        return $this->_message;
    }
}
