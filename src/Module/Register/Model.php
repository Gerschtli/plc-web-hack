<?hh // strict

namespace PLC\Module\Register;

use PLC\Model\User;
use PLC\Model\View\BaseModel;

/**
 * View model for register controller.
 */
class Model extends BaseModel
{
    public function __construct(
        private ?User $_user,
        private ?Vector<string> $_errors,
        private bool $_isSuccess
    )
    {}

    public function getErrors(): ?Vector<string>
    {
        return $this->_errors;
    }

    public function getUser(): ?User
    {
        return $this->_user;
    }

    public function isSuccess(): bool
    {
        return $this->_isSuccess;
    }
}
