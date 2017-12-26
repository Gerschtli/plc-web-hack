<?hh // strict

namespace PLC\Module\Index;

use PLC\Model\View\BaseModel;
use PLC\Controller\Controllable;
use PLC\Controller\BaseController;
use PLC\Service\Article;
use Viewable;

/**
 * Renders index page of blog.
 */
class Controller extends BaseController implements Controllable
{
    public function __construct(Viewable $view, private Article $_article)
    {
        parent::__construct($view);
    }

    <<__Override>>
    protected async function _buildModel(): Awaitable<BaseModel>
    {
        $result = await $this->_article->findAll();

        return new Model($result);
    }
}
