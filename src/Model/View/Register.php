<?hh // strict

namespace PLC\Model\View;

use PLC\Model\User;

/**
 * View model for register controller.
 */
class Register extends BaseModel
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
