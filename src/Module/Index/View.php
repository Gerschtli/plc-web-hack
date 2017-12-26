<?hh // strict

use PLC\Model\Article;
use PLC\Module\Index\Model;

/**
 * View for index page.
 */
class IndexView extends BaseView<Model> implements Viewable
{
    public function __construct()
    {
        parent::__construct(Model::class);
    }

    protected function _render(Model $model): :xhp
    {
        return
            <plc:layout title="Startseite">
                <h1>Alle Artikel</h1>
                {$this->_showArticles($model)}
            </plc:layout>;
    }

    private function _showArticles(Model $model): :xhp
    {
        $xhp = <div></div>;
        foreach ($model->getArticles() as $article) {
            $xhp->appendChild($this->_showArticle($article));
        }
        return $xhp;
    }

    private function _showArticle(Article $article): :xhp
    {
        return
            <div>
                <h3>{$article->getTitle()}</h3>
            </div>;
    }
}
