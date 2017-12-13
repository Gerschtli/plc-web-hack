<?hh // strict

/**
 * Interface for Views
 */
interface Viewable
{
    require extends View;

    /**
     * Put data into view.
     *
     * @param  string $key   Key
     * @param  mixed  $data  Data
     */
    public function put(string $key, mixed $data): void;

    /**
     * Renders view.
     */
    public function render(): :xhp;
}
