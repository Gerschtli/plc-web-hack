<?hh // strict

namespace PLC\Service;

use AsyncMysqlConnection;
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

        if ($result->numRows() == 0) {
            return null;
        }
        return UserModel::create($result->mapRowsTyped()->at(0));
    }
}
