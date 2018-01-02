<?hh // strict

namespace PLC\Service;

use AsyncMysqlConnection;
use AsyncMysqlQueryResult;
use PLC\Model\Article as ArticleModel;
use PLC\Model\User as UserModel;

class Article
{
    private Vector<string> $_select = Vector {
        'article_id',
        'title',
        'teaser',
        'body',
        'teaser_html',
        'body_html',
        'created_at',
        'updated_at',
        'user_id',
        'fullname',
        'username',
        'password',
    };

    public function __construct(private AsyncMysqlConnection $_connection)
    {}

    public async function deleteById(int $id): Awaitable<void>
    {
        await $this->_connection->queryf(
            'DELETE FROM article WHERE article_id = %d',
            $id
        );
    }

    public async function findAll(): Awaitable<Vector<ArticleModel>>
    {
        $result = await $this->_connection->queryf(
            'SELECT %LC FROM article JOIN user ON author_id = user_id ORDER BY updated_at DESC',
            $this->_select
        );

        return $this->_mapList($result);
    }

    public async function findAllByUser(UserModel $user): Awaitable<Vector<ArticleModel>>
    {
        $result = await $this->_connection->queryf(
            'SELECT %LC FROM article JOIN user ON author_id = user_id WHERE user_id = %d ORDER BY updated_at DESC',
            $this->_select,
            $user->getId()
        );

        return $this->_mapList($result);
    }

    public async function findById(int $id): Awaitable<?ArticleModel>
    {
        $result = await $this->_connection->queryf(
            'SELECT %LC FROM article JOIN user ON author_id = user_id WHERE article_id = %d',
            $this->_select,
            $id
        );

        if ($result->numRows() == 0) {
            return null;
        }
        return ArticleModel::create($result->mapRowsTyped()->at(0));
    }

    private function _mapList(AsyncMysqlQueryResult $result): Vector<ArticleModel>
    {
        return $result->mapRowsTyped()->map($data ==> {
            return ArticleModel::create($data);
        });
    }
}
