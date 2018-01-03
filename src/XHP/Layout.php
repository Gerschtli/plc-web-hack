<?hh // strict

use XHPRoot;

/**
 * Defines layout element with common head elements and title attribute.
 */
class :plc:layout extends :x:element
{
    children (:xhp)+;
    attribute string title @required;
    attribute bool admin-nav = false;

    protected function render(): XHPRoot
    {
        return
            <x:doctype>
                <html>
                    <head>
                        <title>{$this->:title} - Blog</title>
                        <meta charset="utf-8" />
                        <link rel="stylesheet" href="/css/main.css" />
                    </head>
                    <body>
                        <div class="headline">
                            <h1><a class="no-decoration" href="/">Herzlich Willkommen bei unserem Blog!</a></h1>
                            {$this->_renderNav()}
                        </div>
                        <div class="wrapper">
                            {$this->getChildren()}
                        </div>
                    </body>
                </html>
            </x:doctype>;
    }

    private function _renderNav(): :xhp
    {
        $list = Vector {};

        if ($this->:admin-nav) {
            $list->add(shape('url' => '/admin', 'label' => 'Admin'));
            $list->add(shape('url' => '/login?logout', 'label' => 'Logout'));
        } else {
            $list->add(shape('url' => '/login', 'label' => 'Login'));
            $list->add(shape('url' => '/register', 'label' => 'Registrieren'));
        }

        $result = <div />;

        foreach ($list as $element) {
            $result->appendChild(
                <a class="form-inline form-inline-sep" href={$element['url']}>{$element['label']}</a>
            );
        }

        return $result;
    }
}
