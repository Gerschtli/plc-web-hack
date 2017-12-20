<?hh // strict

namespace PLC\Controller;

use PLC\Model\View\Register as RegisterModel;
use PLC\Model\View\Model;
use PLC\Service\User;
use Viewable;

/**
 * Renders register page of blog.
 */
class Register extends Controller implements Controllable
{
    public function __construct(Viewable $view, private User $_user)
    {
        parent::__construct($view);
    }

    <<__Override>>
    protected async function _buildModel(): Awaitable<Model>
    {
        return new RegisterModel(null);
    }
}
