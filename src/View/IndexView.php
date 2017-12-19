<?hh // strict

use PLC\Model\View\Index;

/**
 * View for index page
 */
class IndexView extends View<Index> implements Viewable
{
    public function __construct()
    {
        parent::__construct(Index::class);
    }

    protected function _render(Index $model): :xhp
    {
        return
            <plc:layout title="Startseite">
                <h1>Alle Artikel</h1>
                {$this->_showArticles($model)}
            </plc:layout>;
    }

    private function _showArticles(Index $model): :xhp
    {
        $xhp = <div></div>;
        foreach ($model->getArticles() as $article) {
            $xhp->appendChild($this->_showArticle($article));
        }
        return $xhp;
    }

    private function _showArticle(Map<string, mixed> $article): :xhp
    {
        return
            <div>
                <h3>{$article['title']}</h3>
            </div>;
    }
}
