<?hh // strict

namespace PLC\Controller;

use AsyncMysqlConnection;
use Viewable;

/**
 * Renders index page of blog
 */
class Index implements Controllable
{
    public function __construct(private Viewable $_view, private AsyncMysqlConnection $_connection)
    {}

    public async function render(): Awaitable<void>
    {
        // example database query
        $result = await $this->_connection->queryf('SELECT fullname, username FROM user');
        $this->_view->put('result', $result->mapRowsTyped());
        $this->_view->render();
    }
}
