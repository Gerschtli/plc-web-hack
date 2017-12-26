<?hh // strict

namespace PLC\Module\Error;

use Exception;
use PLC\Controller\BaseController;
use PLC\Controller\Controllable;
use PLC\Exception\Forbidden;
use PLC\Exception\NotFound;
use PLC\Model\View\BaseModel;
use PLC\Util\ResponseCode;
use Viewable;

/**
 * Delegates render call straight to provided view.
 */
class Controller extends BaseController implements Controllable
{
    public function __construct(Viewable $view, private Exception $_exception)
    {
        parent::__construct($view);
    }

    <<__Override>>
    protected async function _buildModel(): Awaitable<BaseModel>
    {
        $code    = ResponseCode::INTERNAL_SERVER_ERROR;
        $message = 'Internal Server Error';

        if ($this->_exception instanceof Forbidden) {
            $code    = ResponseCode::FORBIDDEN;
            $message = 'Forbidden';
        } else if ($this->_exception instanceof NotFound) {
            $code    = ResponseCode::NOT_FOUND;
            $message = 'Not Found';
        }

        return new Model($code, $message);
    }
}
