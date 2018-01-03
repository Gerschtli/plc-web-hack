<?hh // strict

namespace PLC\Module\Admin;

use PLC\Model\Article;
use PLC\Model\View\BaseModel;

/**
 * View model for admin controller.
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
