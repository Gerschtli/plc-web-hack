<?hh // strict

abstract class View
{
    protected Map<string, mixed> $_data = Map {};

    public function put(string $key, mixed $data): void
    {
        $this->_data[$key] = $data;
    }
}
