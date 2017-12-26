<?hh // strict

namespace PLC\Model\View;

use PLC\Model\User;

/**
 * View model for register controller.
 */
class Login extends BaseModel
{
    public function __construct(private ?Vector<string> $_errors)
    {}

    public function getErrors(): ?Vector<string>
    {
        return $this->_errors;
    }
}
