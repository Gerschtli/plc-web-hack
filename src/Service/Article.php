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
            'SELECT a.article_id, a.title, a.teaser, a.body, a.teaser_html, a.body_html, a.created_at, a.updated_at, '
            . 'u.user_id, u.fullname, u.username, u.password '
            . 'FROM article a JOIN user u ON a.author_id = u.user_id ORDER BY a.updated_at DESC'
        );

        return $result->mapRowsTyped()->map($data ==> {
            return ArticleModel::create($data);
        });
    }
}
