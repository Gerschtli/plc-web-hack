<?hh // strict

namespace PLC\Validator;

interface Validatable<T>
{
    /**
     * Validates object and returns list of errors.
     *
     * @param  T      $object  Object
     * @return Vector<string>  List of errors
     */
    public function validate(T $object): Awaitable<Vector<string>>;
}
