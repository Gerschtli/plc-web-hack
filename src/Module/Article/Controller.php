<?hh // strict

namespace PLC\Module\Article;

use PLC\Controller\Controllable;
use PLC\Controller\Extension\IdParam;
use PLC\Controller\ViewController;
use PLC\Exception\NotFound;
use PLC\Model\View\BaseModel;
use PLC\Service\Article;
use PLC\Util\Globals;
use Viewable;

/**
 * Shows full requested article.
 */
class Controller extends ViewController implements Controllable
{
    use IdParam;

    public function __construct(Viewable $view, private Article $_article, private Globals $_globals)
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
