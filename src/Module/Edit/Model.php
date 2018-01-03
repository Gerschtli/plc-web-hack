<?hh // strict

namespace PLC\Module\Edit;

use PLC\Model\Article;
use PLC\Model\View\BaseModel;

/**
 * View model for edit controller.
 */
class Model extends BaseModel
{
    public function __construct(
        private ?Article $_article,
        private Vector<string> $_errors,
        private bool $_isSuccess
    )
    {}

    public function getArticle(): ?Article
    {
        return $this->_article;
    }

    public function getErrors(): Vector<string>
    {
        return $this->_errors;
    }

    public function isSuccess(): bool
    {
        return $this->_isSuccess;
    }
}
