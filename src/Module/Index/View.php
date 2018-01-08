<?hh // strict

use PLC\Model\Article;
use PLC\Module\Index\Model;
use PLC\XHP\HtmlUnsafeRenderable;

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
            <plc:layout title="Startseite" wrapper={false}>
                {$this->_showArticles($model)}
            </plc:layout>;
    }

    private function _showArticles(Model $model): :xhp
    {
        $xhp = <x:frag />;
        foreach ($model->getArticles() as $article) {
            $xhp->appendChild($this->_showArticle($article));
        }

        return $xhp;
    }

    private function _showArticle(Article $article): :xhp
    {
        return
            <div class="wrapper">
                <h4 class="article-head-inline">{$article->getTitle()}</h4>
                <aside>
                    <h4 class="article-head-inline">Zuletzt aktualisiert: {$article->getUpdatedAtFormatted()}</h4>
                </aside>
                <br />
                <div class="articlebody">{new HtmlUnsafeRenderable($article->getTeaserHtml())}</div>
                <br />
                <span class="author">{$article->getAuthor()?->getFullname()}</span>
                <aside>
                    <a class="form-inline" href={"/article?id={$article->getId()}"}>
                        Zeig mir alles!
                    </a>
                </aside>
            </div>;
    }
}
