<?hh // strict

use PLC\Module\Article\Model;
use PLC\XHP\HtmlUnsafeRenderable;

/**
 * View for article page.
 */
class ArticleView extends BaseView<Model> implements Viewable
{
    public function __construct()
    {
        parent::__construct(Model::class);
    }

    protected function _render(Model $model): :xhp
    {
        $article = $model->getArticle();

        return
            <plc:layout title="Artikel">
                <h4 class="article-head-inline">{$article->getTitle()}</h4>
                <aside>
                    <h4 class="article-head-inline">Zuletzt aktualisiert: {$article->getUpdatedAtFormatted()}</h4>
                </aside>
                <br />
                <br />
                <div class="articlebody">{new HtmlUnsafeRenderable($article->getBodyHtml())}</div>
                <br />
                <h4 class="author">Verfasser: {$article->getAuthor()?->getFullname()}</h4>
                <a class="form-inline" href="/">
                    Zurück zur Startseite
                </a>
                <aside>
                    <h4 class="article-head-inline">Erstellt am: {$article->getCreatedAtFormatted()}</h4>
                </aside>
            </plc:layout>;
    }
}
