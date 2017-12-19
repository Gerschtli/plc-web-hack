<?hh // strict

namespace PLC\Model\View;

/**
 * View model for index controller.
 */
class Index implements Model
{
    public function __construct(private Vector<Map<string, mixed>> $_articles)
    {}

    public function getArticles(): Vector<Map<string, mixed>>
    {
        return $this->_articles;
    }
}
