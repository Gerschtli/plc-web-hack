<?hh // strict

namespace PLC\Module\Delete;

use PLC\Controller\BaseController;
use PLC\Controller\Controllable;
use PLC\Controller\Extension\Authentication;
use PLC\Controller\Extension\IdParam;
use PLC\Exception\Forbidden;
use PLC\Exception\NotFound;
use PLC\Model\View\BaseModel;
use PLC\Service\Article;
use PLC\Service\Session;
use PLC\Util\Globals;

/**
 * Renders admin page of blog.
 */
class Controller extends BaseController implements Controllable
{
    use Authentication;
    use IdParam;

    public function __construct(private Globals $_globals, private Article $_article, private Session $_sessionService)
    {}

    public async function render(): Awaitable<void>
    {
        $user    = await $this->_getLoggedInUser($this->_sessionService);
        $id      = $this->_getIdParam($this->_globals);
        $article = await $this->_article->findById($id);

        if ($article === null) {
            throw new NotFound();
        }

        if ($article->getAuthor()?->getId() !== $user->getId()) {
            throw new Forbidden();
        }

        await $this->_article->deleteById($id);
        $this->_redirectTo('/admin');
    }
}
