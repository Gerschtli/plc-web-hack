<?hh // strict

/**
 * Abstracts common methods of views.
 */
abstract class View
{
    protected Map<string, mixed> $_data = Map {};

    /**
     * Put data into view.
     *
     * @param  string $key   Key
     * @param  mixed  $data  Data
     */
    public function put(string $key, mixed $data): void
    {
        $this->_data[$key] = $data;
    }
}
