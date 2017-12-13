<?hh

namespace PLC\Util;

class Globals
{
    public function getServer(): Map<string, mixed>
    {
        return new Map($_SERVER);
    }
}
