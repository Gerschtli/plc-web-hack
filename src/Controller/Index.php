<?hh // strict

namespace PLC\Controller;

use PLC\Model\View\Index as IndexModel;
use PLC\Model\View\Model;
use PLC\Service\Article;
use Viewable;

/**
 * Renders index page of blog.
 */
class Index extends Controller implements Controllable
{
    public function __construct(Viewable $view, private Article $_article)
    {
        parent::__construct($view);
    }

    <<__Override>>
    protected async function _buildModel(): Awaitable<Model>
    {
        // example database query
        $result = await $this->_article->findAll();

        return new IndexModel($result);
    }
}
