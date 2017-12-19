<?hh
// not strict because needed access to globals

namespace PLC\Util;

class Globals
{
    public function getServer(): Map<string, mixed>
    {
        return new Map($_SERVER);
    }
}
