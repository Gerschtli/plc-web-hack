<?hh
// not strict because needed access to globals

namespace PLC\Util;

class Globals
{
    /**
     * Get global SERVER array as map.
     *
     * @return Map<string, mixed>  Typed SERVER array
     */
    public function getServer(): Map<string, mixed>
    {
        return new Map($_SERVER);
    }
}
