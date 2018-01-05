<?hh // strict

namespace PLC;

use PLC\Module\DIC as ModuleDIC;
use PLC\Service\DIC as ServiceDIC;
use PLC\Util\DIC as UtilDIC;
use PLC\Validator\DIC as ValidatorDIC;

/**
 * Dependency injection container
 *
 * Provides getter for needed dic instances for system start.
 */
class DIC
{
    private ModuleDIC $_module;
    private ServiceDIC $_service;
    private UtilDIC $_util;
    private ValidatorDIC $_validator;

    public function __construct()
    {
        $this->_util      = new UtilDIC();
        $this->_service   = new ServiceDIC($this->_util);
        $this->_validator = new ValidatorDIC($this->_service);
        $this->_module    = new ModuleDIC($this->_service, $this->_util, $this->_validator);
    }

    public function getModule(): ModuleDIC
    {
        return $this->_module;
    }

    public function getUtil(): UtilDIC
    {
        return $this->_util;
    }
}
