<?hh // strict

namespace PLC\Controller;

/**
 * Interface for all controllers.
 */
interface Controllable
{
    /**
     * Renders the page.
     */
    public function render(): Awaitable<void>;
}
