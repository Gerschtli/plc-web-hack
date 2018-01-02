<?hh // strict

namespace PLC\Model;

use DateTime;

class Article
{
    private ?int $_id;
    private ?string $_title;
    private ?string $_teaser;
    private ?string $_body;
    private ?string $_teaserHtml;
    private ?string $_bodyHtml;
    private ?User $_author;
    private ?DateTime $_createdAt;
    private ?DateTime $_updatedAt;

    public static function create(Map<string, mixed> $data): Article
    {
        $id         = $data['article_id'];
        $title      = $data['title'];
        $teaser     = $data['teaser'];
        $body       = $data['body'];
        $teaserHtml = $data['teaser_html'];
        $bodyHtml   = $data['body_html'];
        $author     = User::create($data);
        $createdAt  = new DateTime($data['created_at']);
        $updatedAt  = new DateTime($data['updated_at']);

        invariant(is_int($id), 'Article data wrong type');
        invariant(is_string($title), 'Article data wrong type');
        invariant(is_string($teaser), 'Article data wrong type');
        invariant(is_string($body), 'Article data wrong type');
        invariant(is_string($teaserHtml), 'Article data wrong type');
        invariant(is_string($bodyHtml), 'Article data wrong type');
        invariant($author instanceof User, 'Article data wrong type');
        invariant($createdAt instanceof DateTime, 'Article data wrong type');
        invariant($updatedAt instanceof DateTime, 'Article data wrong type');

        $article = new Article();
        $article->setId($id);
        $article->setTitle($title);
        $article->setTeaser($teaser);
        $article->setBody($body);
        $article->setTeaserHtml($teaserHtml);
        $article->setBodyHtml($bodyHtml);
        $article->setAuthor($author);
        $article->setCreatedAt($createdAt);
        $article->setUpdatedAt($updatedAt);

        return $article;
    }

    public function getId(): ?int
    {
        return $this->_id;
    }

    public function setId(int $id): void
    {
        $this->_id = $id;
    }

    public function getTitle(): ?string
    {
        return $this->_title;
    }

    public function setTitle(string $title): void
    {
        $this->_title = $title;
    }

    public function getTeaser(): ?string
    {
        return $this->_teaser;
    }

    public function setTeaser(string $teaser): void
    {
        $this->_teaser = $teaser;
    }

    public function getBody(): ?string
    {
        return $this->_body;
    }

    public function setBody(string $body): void
    {
        $this->_body = $body;
    }

    public function getTeaserHtml(): ?string
    {
        return $this->_teaserHtml;
    }

    public function setTeaserHtml(string $teaserHtml): void
    {
        $this->_teaserHtml = $teaserHtml;
    }

    public function getBodyHtml(): ?string
    {
        return $this->_bodyHtml;
    }

    public function setBodyHtml(string $bodyHtml): void
    {
        $this->_bodyHtml = $bodyHtml;
    }

    public function getAuthor(): ?User
    {
        return $this->_author;
    }

    public function setAuthor(User $author): void
    {
        $this->_author = $author;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->_createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->_createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->_updatedAt;
    }

    public function getUpdatedAtFormatted(): ?string
    {
        return $this->_updatedAt?->format('d.m.Y H:i');
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->_updatedAt = $updatedAt;
    }
}
