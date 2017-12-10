<?hh // strict

namespace PLC\Router;

class Router
{
    public static async function route(): Awaitable<void>
    {
        echo 'Hallo Welt';
    }
}
