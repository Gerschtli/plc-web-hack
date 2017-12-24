<?hh // strict

use XHPRoot;

/**
 * Defines layout element with common head elements and title attribute
 */
class :plc:layout extends :x:element
{
    children (:xhp)+;
    attribute :title;

    protected function render(): XHPRoot
    {
        return
            <x:doctype>
                <html>
                    <head>
                        <title>{$this->:title} - Blog</title>
                        <link rel="stylesheet" href="/css/main.css" />
                    </head>
                    <body>
                        <div class="headline">
                            <h1><a class="no-decoration" href="/">Herzlich Willkommen bei unserem Blog!</a></h1>
                        </div>
                        <div class="wrapper">
                            {$this->getChildren()}
                        </div>
                    </body>
                </html>
            </x:doctype>;
    }
}
