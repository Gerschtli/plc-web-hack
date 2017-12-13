<?hh // strict

namespace PLC\Controller;

use AsyncMysqlConnection;
use Viewable;

/**
 * Renders index page of blog
 */
class Index extends Controller implements Controllable
{
    public function __construct(Viewable $view, private AsyncMysqlConnection $_connection)
    {
        parent::__construct($view);
    }

    <<__Override>>
    protected async function _run(): Awaitable<void>
    {
        // example database query
        $result = await $this->_connection->queryf('SELECT fullname, username FROM user');
        $this->_view->put('result', $result->mapRowsTyped());
    }
}
