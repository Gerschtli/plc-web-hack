<?hh // strict

namespace PLC\Module\Index;

use PLC\Model\Article;
use PLC\Model\View\BaseModel;

/**
 * View model for index controller.
 */
class Model extends BaseModel
{
    public function __construct(private Vector<Article> $_articles)
    {}

    public function getArticles(): Vector<Article>
    {
        return $this->_articles;
    }
}
