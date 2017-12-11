<?hh // strict

interface Viewable
{
    require extends View;

    public function put(string $key, mixed $data): void;

    public function render(): void;
}
