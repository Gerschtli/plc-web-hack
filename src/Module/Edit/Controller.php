<?hh // strict

namespace PLC\Module\Edit;

use PLC\Controller\Controllable;
use PLC\Controller\Extension\Authentication;
use PLC\Controller\Extension\Form;
use PLC\Controller\Extension\IdParam;
use PLC\Controller\ViewController;
use PLC\Model\Article as ArticleModel;
use PLC\Model\View\BaseModel;
use PLC\Service\Article as ArticleService;
use PLC\Service\Markdown;
use PLC\Service\Session;
use PLC\Util\Asio;
use PLC\Util\Globals;
use PLC\Validator\Article as ArticleValidator;
use Viewable;

/**
 * Edit or create articles and converts markdown texts to html.
 */
class Controller extends ViewController implements Controllable
{
    use Authentication;
    use Form<ArticleModel>;
    use IdParam;

    public function __construct(
        Viewable $view,
        private ArticleService $_articleService,
        private Markdown $_markdownService,
        private Session $_sessionService,
        private ArticleValidator $_articleValidator,
        private Asio $_asio,
        private Globals $_globals
    )
    {
        parent::__construct($view);
    }

    <<__Override>>
    protected async function _buildModel(): Awaitable<BaseModel>
    {
        $user = await $this->_getLoggedInUser($this->_sessionService);
        $id   = $this->_getIdParamOptional($this->_globals);

        $formResult = await $this->_handleForm(
            $this->_globals,
            $this->_articleValidator,
            async $post ==> {
                $article = new ArticleModel();
                if ($id !== null) {
                    $article->setId($id);
                }
                $article->setTitle($post['title']);
                $article->setTeaser($post['teaser']);
                $article->setBody($post['body']);
                $article->setAuthor($user);

                list($teaser, $body) = await $this->_asio->batch(
                    $this->_markdownService->convertToHtml($post['teaser']),
                    $this->_markdownService->convertToHtml($post['body'])
                );
                if ($teaser !== null) {
                    $article->setTeaserHtml($teaser);
                }
                if ($body !== null) {
                    $article->setBodyHtml($body);
                }

                return $article;
            },
            async $model ==> {
                await $this->_articleService->save($model);
            }
        );

        $preFilledData = $formResult['model'];
        if ($preFilledData === null && $id !== null) {
            $preFilledData = await $this->_articleService->findById($id);
        }

        return new Model($preFilledData, $formResult['errors'], $formResult['success']);
    }
}
