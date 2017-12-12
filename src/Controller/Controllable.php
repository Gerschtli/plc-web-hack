<?hh // strict

namespace PLC\Controller;

/**
 * Interface for all Controllers
 */
interface Controllable
{
    /**
     * Renders the page.
     *
     * @return Awaitable<void>
     */
    public function render(): Awaitable<void>;
}
