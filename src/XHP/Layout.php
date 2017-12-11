<?hh // strict

class :plc:layout extends :x:element {
    children (:div)+;

    protected function render(): \XHPRoot {
        return
            <x:doctype>
                <html>
                    <head>
                        <title>Titel</title>
                    </head>
                    <body>
                        {$this->getChildren()}
                    </body>
                </html>
            </x:doctype>;
    }
}
