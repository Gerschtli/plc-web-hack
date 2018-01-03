<?hh // strict

namespace PLC\XHP;

use XHPUnsafeRenderable;

/**
 * Implementation of XHPUnsafeRenderable to render html strings.
 */
class HtmlUnsafeRenderable implements XHPUnsafeRenderable
{
    public function __construct(
        private ?string $_html
    )
    {}

    public function toHTMLString(): string
    {
        return $this->_html === null ? '' : $this->_html;
    }
}
