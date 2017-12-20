<?hh // strict

namespace PLC;

use AsyncMysqlConnection;
use AsyncMysqlConnectionPool;
use IndexView;
use NotFoundView;
use PLC\Controller\Controllable;
use PLC\Controller\Index;
use PLC\Controller\PassThru;
use PLC\Service\Article;
use PLC\Service\User;
use PLC\Util\Globals;
use Viewable;

/**
 * Dependency injection container
 *
 * Provides getter for controller with all instances needed.
 */
class DIC
{
    private ?AsyncMysqlConnectionPool $_mysqlConnectionPool;

    public function getGlobalsUtil(): Globals
    {
        return new Globals();
    }

    public async function getIndexController(): Awaitable<Controllable>
    {
        $articleService = await $this->_getArticleService();
        return new Index($this->_getIndexView(), $articleService);
    }

    public function getNotFoundController(): Controllable
    {
        return new PassThru($this->_getNotFoundView());
    }

    private async function _getArticleService(): Awaitable<Article>
    {
        $connection = await $this->_getMysqlConnection();
        return new Article($connection);
    }

    private async function _getUserService(): Awaitable<User>
    {
        $connection = await $this->_getMysqlConnection();
        return new User($connection);
    }

    private function _getIndexView(): Viewable
    {
        return new IndexView();
    }

    private function _getNotFoundView(): Viewable
    {
        return new NotFoundView();
    }

    private function _getMysqlConnection(): Awaitable<AsyncMysqlConnection>
    {
        return $this->_getMysqlConnectionPool()->connect(
            Config::HOST,
            Config::PORT,
            Config::DB,
            Config::USER,
            Config::PASSWORD
        );
    }

    private function _getMysqlConnectionPool(): AsyncMysqlConnectionPool
    {
        // open only one connection pool
        if ($this->_mysqlConnectionPool === null) {
            $this->_mysqlConnectionPool = new AsyncMysqlConnectionPool(['pool_connection_limit' => 100]);
        }
        return $this->_mysqlConnectionPool;
    }
}
