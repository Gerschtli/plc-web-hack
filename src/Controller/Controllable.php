<?hh // strict

namespace PLC\Controller;

/**
 * Interface for all Controllers.
 */
interface Controllable
{
    require extends BaseController;

    /**
     * Renders the page.
     */
    public function render(): Awaitable<void>;
}
