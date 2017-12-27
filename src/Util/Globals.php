<?hh
// not strict because needed access to globals

namespace PLC\Util;

class Globals
{
    /**
     * Get global POST array as map.
     *
     * @return Map<string, string>  Typed POST array
     */
    public function getPost(): Map<string, string>
    {
        return new Map($_POST);
    }

    /**
     * Get global SERVER array as map.
     *
     * @return Map<string, mixed>  Typed SERVER array
     */
    public function getServer(): Map<string, mixed>
    {
        return new Map($_SERVER);
    }

    /**
     * Get global SESSION array as map.
     *
     * @return Map<string, mixed>  Typed SESSION array
     */
    public function getSession(): Map<string, mixed>
    {
        return new Map($_SESSION);
    }

    /**
     * Set value in SESSION array.
     *
     * @param string $key    Key
     * @param mixed  $value  Value
     */
    public function setSession(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }
}
