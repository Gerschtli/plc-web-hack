<?hh // strict

namespace PLC\Service;

use AsyncMysqlConnection;
use PLC\Model\Article as ArticleModel;

class Article
{
    public function __construct(private AsyncMysqlConnection $_connection)
    {}

    public async function findAll(): Awaitable<Vector<ArticleModel>>
    {
        $result = await $this->_connection->queryf(
            'SELECT article_id, title, teaser, body, teaser_html, body_html, created_at, updated_at, user_id, fullname, username, password '
            . 'FROM article JOIN user ORDER BY updated_at DESC'
        );
        return $result->mapRowsTyped()->map($data ==> {
            return ArticleModel::create($data);
        });
    }
}
