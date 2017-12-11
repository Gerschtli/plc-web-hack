<?hh // strict

namespace PLC;

use PLC\Controller\Controllable;
use PLC\Controller\PassThru;
use NotFoundView;
use IndexView;
use Viewable;

class DIC
{
    public function getIndexController(): Controllable
    {
        return new PassThru($this->_getIndexView());
    }

    public function getNotFoundController(): Controllable
    {
        return new PassThru($this->_getNotFoundView());
    }

    private function _getIndexView(): Viewable
    {
        return new IndexView();
    }

    private function _getNotFoundView(): Viewable
    {
        return new NotFoundView();
    }
}
