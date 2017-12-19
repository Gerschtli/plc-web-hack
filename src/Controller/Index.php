<?hh // strict

namespace PLC\Controller;

use AsyncMysqlConnection;
use PLC\Model\View\Model;
use PLC\Model\View\Index as IndexModel;
use Viewable;

/**
 * Renders index page of blog.
 */
class Index extends Controller implements Controllable
{
    public function __construct(Viewable $view, private AsyncMysqlConnection $_connection)
    {
        parent::__construct($view);
    }

    <<__Override>>
    protected async function _buildModel(): Awaitable<Model>
    {
        // example database query
        $result = await $this->_connection->queryf(
            'SELECT a.id, a.title, a.teaser, a.created_at, a.updated_at, u.fullname '
            . 'FROM article a JOIN user u ON a.author_id = u.id ORDER BY updated_at DESC'
        );

        return new IndexModel($result->mapRowsTyped());
    }
}
