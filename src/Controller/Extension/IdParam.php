<?hh // strict

namespace PLC\Controller\Extension;

use PLC\Controller\Controllable;
use PLC\Exception\NotFound;
use PLC\Util\Globals;

/**
 * Controller extension for id get param support.
 */
trait IdParam
{
    require implements Controllable;

    /**
     * Gets id get param.
     *
     * @param  Globals $globals  Globals util helper
     * @return int               Id param
     */
    private function _getIdParam(Globals $globals): int
    {
        $get = $globals->getGet();

        if (!$get->containsKey('id') || !preg_match('/^[1-9][0-9]*/', $get['id'])) {
            throw new NotFound();
        }

        return (int) $get['id'];
    }
}
