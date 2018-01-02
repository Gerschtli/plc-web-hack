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

    private function _mapList(AsyncMysqlQueryResult $result): Vector<ArticleModel>
    {
        return $result->mapRowsTyped()->map($data ==> {
            return ArticleModel::create($data);
        });
    }
}
