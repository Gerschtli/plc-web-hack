<?hh // strict

namespace PLC\Validator;

use PLC\Service\User as UserService;

type LoginModel = shape('username' => string, 'password' => string);

/**
 * Validates login form data.
 */
class Login implements Validatable<LoginModel>
{
    public function __construct(private UserService $_userService)
    {}

    public async function validate(LoginModel $login): Awaitable<Vector<string>>
    {
        $errors = Vector {};

        $username = $login['username'];

        if ($username === '') {
            $errors->add('Username darf nicht leer sein');
        } else {
            invariant($username !== null, 'if condition is false');
            $foundLogin = await $this->_userService->findByUsername($username);

            if ($foundLogin?->getPassword() !== $login['password']) {
                $errors->add('Passwort leider falsch');
            }
        }

        return $errors;
    }
}
