<?hh // strict

namespace PLC\Util;

/**
 * Dependency injection container
 *
 * Provides getter for utils with all dependencies injected.
 */
class DIC
{
    private ?Asio $_asio;
    private ?Globals $_globals;

    public function getAsio(): Asio
    {
        if ($this->_asio === null) {
            $this->_asio = new Asio();
        }

        return $this->_asio;
    }

    public function getGlobals(): Globals
    {
        if ($this->_globals === null) {
            $this->_globals = new Globals();
        }

        return $this->_globals;
    }
}
