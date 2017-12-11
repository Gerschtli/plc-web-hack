<?hh // strict

namespace PLC\Controller;

interface Controllable
{
    public function render(): Awaitable<void>;
}
