<?hh // strict

namespace PLC\XHP;

use XHPUnsafeRenderable;

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
