<?hh // strict

namespace PLC\Module\Article;

use PLC\Model\Article;
use PLC\Model\View\BaseModel;

/**
 * View model for index controller.
 */
class Model extends BaseModel
{
    public function __construct(private Article $_article)
    {}

    public function getArticle(): Article
    {
        return $this->_article;
    }
}
