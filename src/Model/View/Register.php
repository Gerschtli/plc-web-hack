<?hh // strict

namespace PLC\Model\View;

use PLC\Model\User;

/**
 * View model for register controller.
 */
class Register implements Model
{
    public function __construct(private ?User $_user)
    {}

    public function getUser(): ?User
    {
        return $this->_user;
    }
}
