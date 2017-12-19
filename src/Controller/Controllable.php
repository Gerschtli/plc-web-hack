<?hh // strict

namespace PLC\Controller;

/**
 * Interface for all Controllers
 */
interface Controllable
{
    require extends Controller;

    /**
     * Renders the page.
     */
    public function render(): Awaitable<void>;
}
