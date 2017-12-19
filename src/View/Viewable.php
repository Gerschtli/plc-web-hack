<?hh // strict

use PLC\Model\View\Model;

/**
 * Interface for Views
 */
interface Viewable
{
    /**
     * Renders view.
     */
    public function render(Model $model): :xhp;
}
