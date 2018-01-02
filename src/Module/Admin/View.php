<?hh // strict

use PLC\Model\Article;
use PLC\Module\Admin\Model;

/**
 * View for admin page.
 */
class AdminView extends BaseView<Model> implements Viewable
{
    public function __construct()
    {
        parent::__construct(Model::class);
    }

    protected function _render(Model $model): :xhp
    {
        return
            <plc:layout title="Startseite" admin-nav={true}>
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
            <div class="article-entry">
                <p>{$article->getTitle()}</p>
                <a href={"/admin/edit?id={$article->getId()}"}>bearbeiten</a> |
                <a href={"/admin/delete?id={$article->getId()}"}>löschen</a>
            </div>;
    }
}
