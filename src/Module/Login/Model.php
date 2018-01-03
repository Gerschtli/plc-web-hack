<?hh // strict

namespace PLC\Module\Login;

use PLC\Model\User;
use PLC\Model\View\BaseModel;

/**
 * View model for login controller.
 */
class Model extends BaseModel
{
    public function __construct(private Vector<string> $_errors)
    {}

    public function getErrors(): Vector<string>
    {
        return $this->_errors;
    }
}
