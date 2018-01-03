<?hh // strict

namespace PLC\Service;

class Markdown
{
    public async function convertToHtml(?string $markdown): Awaitable<?string>
    {
        return $markdown;
    }
}
