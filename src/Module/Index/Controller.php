<?hh // strict

namespace PLC\Module\Index;

use PLC\Controller\Controllable;
use PLC\Controller\ViewController;
use PLC\Model\View\BaseModel;
use PLC\Service\Article;
use Viewable;

/**
 * Shows teasers to all articles.
 */
class Controller extends ViewController implements Controllable
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
