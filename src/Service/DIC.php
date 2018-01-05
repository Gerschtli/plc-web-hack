<?hh // strict

namespace PLC\Service;

use AsyncMysqlConnection;
use AsyncMysqlConnectionPool;
use PLC\Config;
use PLC\Util\DIC as UtilDIC;

/**
 * Dependency injection container
 *
 * Provides getter for services with all dependencies injected.
 */
class DIC
{
    public function __construct(private UtilDIC $_utilDIC)
    {}

    private ?AsyncMysqlConnectionPool $_mysqlConnectionPool;
    private ?User $_serviceUser;

    public async function getArticle(): Awaitable<Article>
    {
        $connection = await $this->_getMysqlConnection();

        return new Article($connection);
    }

    public function getMarkdown(): Markdown
    {
        return new Markdown();
    }

    public async function getSession(): Awaitable<Session>
    {
        $userService = await $this->getUser();

        return new Session($userService, $this->_utilDIC->getGlobals());
    }

    public async function getUser(): Awaitable<User>
    {
        if ($this->_serviceUser === null) {
            $connection = await $this->_getMysqlConnection();
            $this->_serviceUser = new User($connection);
        }

        return $this->_serviceUser;
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
