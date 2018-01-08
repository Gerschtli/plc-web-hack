<?hh // strict

namespace PLC\Module\Delete;

use PLC\Controller\BaseController;
use PLC\Controller\Controllable;
use PLC\Controller\Extension\Authentication;
use PLC\Controller\Extension\IdParam;
use PLC\Exception\Forbidden;
use PLC\Exception\NotFound;
use PLC\Service\Article;
use PLC\Service\Session;
use PLC\Util\Asio;
use PLC\Util\Globals;

/**
 * Delete article if logged in user is author.
 */
class Controller extends BaseController implements Controllable
{
    use Authentication;
    use IdParam;

    public function __construct(
        private Article $_article,
        private Session $_sessionService,
        private Asio $_asio,
        private Globals $_globals
    )
    {}

    public async function render(): Awaitable<void>
    {
        $id = $this->_getIdParam($this->_globals);

        list($user, $article) = await $this->_asio->batch(
            $this->_getLoggedInUser($this->_sessionService),
            $this->_article->findById($id)
        );

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
