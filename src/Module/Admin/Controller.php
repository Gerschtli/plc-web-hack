<?hh // strict

namespace PLC\Module\Admin;

use PLC\Controller\ViewController;
use PLC\Controller\Controllable;
use PLC\Controller\Extension\Authentication;
use PLC\Exception\Forbidden;
use PLC\Model\View\BaseModel;
use PLC\Service\Article;
use PLC\Service\Session;
use Viewable;

/**
 * Renders admin page of blog.
 */
class Controller extends ViewController implements Controllable
{
    use Authentication;

    public function __construct(Viewable $view, private Article $_article, private Session $_sessionService)
    {
        parent::__construct($view);
    }

    <<__Override>>
    protected async function _buildModel(): Awaitable<BaseModel>
    {
        $user   = await $this->_getLoggedInUser($this->_sessionService);
        $result = await $this->_article->findAllByUser($user);

        return new Model($result);
    }
}
