<?hh // strict

namespace PLC\Validator;

interface Validatable<T>
{
    public function validate(T $object): Awaitable<Vector<string>>;
}
