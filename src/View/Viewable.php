<?hh // strict

use PLC\Model\View\Model;

/**
 * Interface for Views.
 */
interface Viewable
{
    /**
     * Renders view.
     *
     * @param  Model  $model  View model
     * @return :xhp           HTML page
     */
    public function render(Model $model): :xhp;
}
