<?hh // strict

namespace PLC\Service;

use AsyncMysqlConnection;
use AsyncMysqlQueryResult;
use PLC\Model\User as UserModel;

class User
{
    public function __construct(private AsyncMysqlConnection $_connection)
    {}

    public async function findById(int $id): Awaitable<?UserModel>
    {
        $result = await $this->_connection->queryf(
            'SELECT user_id, fullname, username, password FROM user WHERE id = %d',
            $id
        );

        return $this->_firstRowToModel($result);
    }

    public async function findByUsername(string $username): Awaitable<?UserModel>
    {
        $result = await $this->_connection->queryf(
            'SELECT user_id, fullname, username, password FROM user WHERE username = %s',
            $username
        );

        return $this->_firstRowToModel($result);
    }

    public async function save(UserModel $user): Awaitable<void>
    {
        if ($user->getId() === null) {
            await $this->_insert($user);
        } else {
            await $this->_update($user);
        }
    }

    private function _firstRowToModel(AsyncMysqlQueryResult $result): ?UserModel
    {
        if ($result->numRows() == 0) {
            return null;
        }
        return UserModel::create($result->mapRowsTyped()->at(0));
    }

    private async function _insert(UserModel $user): Awaitable<void>
    {
        await $this->_connection->queryf(
            'INSERT INTO user (fullname, username, password) VALUES (%s, %s, %s)',
            $user->getFullname(),
            $user->getUsername(),
            $user->getPassword()
        );
    }

    private async function _update(UserModel $user): Awaitable<void>
    {
        await $this->_connection->queryf(
            'UPDATE user SET fullname = %s, username = %s, password = %s WHERE user_id = %d',
            $user->getFullname(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getId()
        );
    }
}
