<?hh // strict

namespace PLC\Module\Error;

use PLC\Model\View\BaseModel;
use PLC\Controller\BaseController;
use PLC\Controller\Controllable;
use Exception;
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
        $code    = self::HTTP_INTERNAL_SERVER_ERROR;
        $message = 'Internal Server Error';

        return new Model($code, $message);
    }
}
