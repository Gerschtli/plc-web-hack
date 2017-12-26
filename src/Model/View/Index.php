<?hh // strict

namespace PLC\Model\View;

use PLC\Model\Article;

/**
 * View model for index controller.
 */
class Index extends BaseModel
{
    public function __construct(private Vector<Article> $_articles)
    {}

    public function getArticles(): Vector<Article>
    {
        return $this->_articles;
    }
}
