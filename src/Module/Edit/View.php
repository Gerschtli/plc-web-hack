<?hh // strict

use PLC\Module\Edit\Model;
use PLC\Util\InputType;

/**
 * View for edit page.
 */
class EditView extends BaseView<Model> implements Viewable
{
    use FormExtension;

    public function __construct()
    {
        parent::__construct(Model::class);
    }

    protected function _render(Model $model): :xhp
    {
        $article = $model->getArticle();

        return
            <plc:layout title="Bearbeite Artikel" admin-nav={true}>
                <h1>Bearbeite Artikel</h1>
                <form method="post">
                    {$this->_renderErrors($model->getErrors())}
                    {$this->_renderSuccess(
                        $model->isSuccess(),
                        <x:frag>
                            Erfolgreich gespeichert!
                        </x:frag>
                    )}
                    {$this->_renderFormRow('title', 'Titel', InputType::ONE_LINE_TEXT, $article?->getTitle())}
                    {$this->_renderFormRow('teaser', 'Teaser', InputType::MUTLI_LINE_TEXT, $article?->getTeaser())}
                    {$this->_renderFormRow('body', 'Body', InputType::MUTLI_LINE_TEXT, $article?->getBody())}
                    {$this->_renderFormSubmit('Speichern')}
                </form>
            </plc:layout>;
    }
}
