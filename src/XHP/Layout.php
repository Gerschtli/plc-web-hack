<?hh // strict

/**
 * Defines layout element with common head elements and title attribute
 */
class :plc:layout extends :x:element
{
    children (:div)+;
    attribute :title;

    protected function render(): \XHPRoot
    {
        return
            <x:doctype>
                <html>
                    <head>
                        <title>{$this->:title} - Blog</title>
                        <link rel="stylesheet" href="/css/main.css" />
                    </head>
                    <body>
                        {$this->getChildren()}
                    </body>
                </html>
            </x:doctype>;
    }
}
