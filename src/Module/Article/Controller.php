<?hh // strict

namespace PLC\Module\Article;

use PLC\Controller\ViewController;
use PLC\Controller\Controllable;
use PLC\Controller\Extension\IdParam;
use PLC\Model\View\BaseModel;
use PLC\Service\Article;
use PLC\Exception\NotFound;
use PLC\Util\Globals;
use Viewable;

/**
 * Renders admin page of blog.
 */
class Controller extends ViewController implements Controllable
{
    use IdParam;

    public function __construct(Viewable $view, private Globals $_globals, private Article $_article)
    {
        parent::__construct($view);
    }

    <<__Override>>
    protected async function _buildModel(): Awaitable<BaseModel>
    {
        $id      = $this->_getIdParam($this->_globals);
        $article = await $this->_article->findById($id);

        if ($article === null) {
            throw new NotFound();
        }

        return new Model($article);
    }
}
