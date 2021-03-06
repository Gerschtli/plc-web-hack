<?hh // strict

namespace PLC\Service;

use AsyncMysqlConnection;
use AsyncMysqlQueryResult;
use PLC\Model\Article as ArticleModel;
use PLC\Model\User as UserModel;

class Article
{
    /**
     * All fields needed for complete article object.
     *
     * @var Vector<string>
     */
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

    /**
     * Delete article by id.
     *
     * @param int $id  ID
     */
    public async function deleteById(int $id): Awaitable<void>
    {
        await $this->_connection->queryf(
            'DELETE FROM article WHERE article_id = %d',
            $id
        );
    }

    /**
     * Find all articles sorted by updatedAt.
     *
     * @return Vector<ArticleModel>  List of articles
     */
    public async function findAll(): Awaitable<Vector<ArticleModel>>
    {
        $result = await $this->_connection->queryf(
            'SELECT %LC FROM article JOIN user ON author_id = user_id ORDER BY updated_at DESC',
            $this->_select
        );

        return $this->_mapList($result);
    }

    /**
     * Find all articles of $user sorted by updatedAt.
     *
     * @param  UserModel $user       Owner of articles
     * @return Vector<ArticleModel>  List of articles
     */
    public async function findAllByUser(UserModel $user): Awaitable<Vector<ArticleModel>>
    {
        $result = await $this->_connection->queryf(
            'SELECT %LC FROM article JOIN user ON author_id = user_id WHERE user_id = %d ORDER BY updated_at DESC',
            $this->_select,
            $user->getId()
        );

        return $this->_mapList($result);
    }

    /**
     * Find article by id.
     *
     * @param  int $id        ID
     * @return ?ArticleModel  Article or null
     */
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

    /**
     * Persist article object.
     *
     * @param ArticleModel $article  Article
     */
    public async function save(ArticleModel $article): Awaitable<void>
    {
        if ($article->getId() === null) {
            await $this->_insert($article);
        } else {
            await $this->_update($article);
        }
    }

    /**
     * Insert new article.
     *
     * @param  ArticleModel $article  Article
     */
    private async function _insert(ArticleModel $article): Awaitable<void>
    {
        $result = await $this->_connection->queryf(
            'INSERT INTO article (title, teaser, body, teaser_html, body_html, author_id, created_at, updated_at) '
            . 'VALUES (%s, %s, %s, %s, %s, %d, NOW(), NOW())',
            $article->getTitle(),
            $article->getTeaser(),
            $article->getBody(),
            $article->getTeaserHtml(),
            $article->getBodyHtml(),
            $article->getAuthor()?->getId()
        );

        $article->setId($result->lastInsertId());
    }

    /**
     * Map list of untyped articles to article models.
     *
     * @param  AsyncMysqlQueryResult $result  Query result
     * @return Vector<ArticleModel>           List of articles models
     */
    private function _mapList(AsyncMysqlQueryResult $result): Vector<ArticleModel>
    {
        return $result->mapRowsTyped()->map($data ==> {
            return ArticleModel::create($data);
        });
    }

    /**
     * Update existing article.
     *
     * @param  ArticleModel $article  Article
     */
    private async function _update(ArticleModel $article): Awaitable<void>
    {
        await $this->_connection->queryf(
            'UPDATE article SET title = %s, teaser = %s, body = %s, teaser_html = %s, body_html = %s, '
            . 'updated_at = NOW() WHERE article_id = %d',
            $article->getTitle(),
            $article->getTeaser(),
            $article->getBody(),
            $article->getTeaserHtml(),
            $article->getBodyHtml(),
            $article->getId()
        );
    }
}
