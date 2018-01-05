<?hh // strict

namespace PLC\Util;

/**
 * Dependency injection container
 *
 * Provides getter for utils with all dependencies injected.
 */
class DIC
{
    private ?Globals $_globals;

    public function getGlobals(): Globals
    {
        if ($this->_globals === null) {
            $this->_globals = new Globals();
        }

        return $this->_globals;
    }
}
