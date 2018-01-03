<?hh // strict

namespace PLC\Service;

use AsyncMysqlConnection;
use AsyncMysqlQueryResult;
use PLC\Model\User as UserModel;

class User
{
    public function __construct(private AsyncMysqlConnection $_connection)
    {}

    /**
     * Find user by id.
     *
     * @param  int    $id  ID
     * @return ?UserModel  User object
     */
    public async function findById(int $id): Awaitable<?UserModel>
    {
        $result = await $this->_connection->queryf(
            'SELECT user_id, fullname, username, password FROM user WHERE id = %d',
            $id
        );

        return $this->_firstRowToModel($result);
    }

    /**
     * Find user by username.
     *
     * @param  string $username  Username
     * @return ?UserModel        User object
     */
    public async function findByUsername(string $username): Awaitable<?UserModel>
    {
        $result = await $this->_connection->queryf(
            'SELECT user_id, fullname, username, password FROM user WHERE username = %s',
            $username
        );

        return $this->_firstRowToModel($result);
    }

    /**
     * Map untyped result list to one user model instance.
     *
     * @param  AsyncMysqlQueryResult $result  Query result
     * @return ?UserModel                     User
     */
    private function _firstRowToModel(AsyncMysqlQueryResult $result): ?UserModel
    {
        if ($result->numRows() === 0) {
            return null;
        }

        return UserModel::create($result->mapRowsTyped()->at(0));
    }

    /**
     * Insert new user.
     *
     * @param UserModel $user  User
     */
    public async function insert(UserModel $user): Awaitable<void>
    {
        await $this->_connection->queryf(
            'INSERT INTO user (fullname, username, password) VALUES (%s, %s, %s)',
            $user->getFullname(),
            $user->getUsername(),
            $user->getPassword()
        );
    }
}
