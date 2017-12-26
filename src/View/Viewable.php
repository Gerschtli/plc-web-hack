<?hh // strict

use PLC\Model\View\BaseModel;

/**
 * Interface for Views.
 */
interface Viewable
{
    /**
     * Renders view.
     *
     * @param  BaseModel  $model  View model
     * @return :xhp               HTML page
     */
    public function render(BaseModel $model): :xhp;
}
