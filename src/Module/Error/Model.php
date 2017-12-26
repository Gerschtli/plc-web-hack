<?hh // strict

namespace PLC\Module\Error;

use PLC\Model\Article;
use PLC\Model\View\BaseModel;

/**
 * View model for index controller.
 */
class Model extends BaseModel
{
    public function __construct(private int $_code, private string $_message)
    {}

    public function getCode(): int
    {
        return $this->_code;
    }

    public function getMessage(): string
    {
        return $this->_message;
    }
}
