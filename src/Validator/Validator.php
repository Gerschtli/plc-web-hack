<?hh // strict

namespace PLC\Validator;

interface Validator<T>
{
    public function validate(T $object): Awaitable<Vector<string>>;
}
