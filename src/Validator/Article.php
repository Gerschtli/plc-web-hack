<?hh // strict

namespace PLC\Validator;

use PLC\Model\Article as ArticleModel;
use PLC\Service\Article as ArticleService;

class Article implements Validatable<ArticleModel>
{
    public async function validate(ArticleModel $article): Awaitable<Vector<string>>
    {
        $errors = Vector {};

        if ($this->_isEmpty($article->getTitle())) {
            $errors->add('Titel darf nicht leer sein');
        }
        if ($this->_isEmpty($article->getTeaser())) {
            $errors->add('Teaser darf nicht leer sein');
        }
        if ($this->_isEmpty($article->getBody())) {
            $errors->add('Body darf nicht leer sein');
        }

        return $errors;
    }

    private function _isEmpty(?string $value): bool
    {
        return $value === null || $value === '';
    }
}
