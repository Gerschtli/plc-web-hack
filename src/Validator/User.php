<?hh // strict

namespace PLC\Validator;

use PLC\Service\User as UserService;
use PLC\Model\User as UserModel;

class User implements Validatable<UserModel>
{
    public function __construct(private UserService $_userService)
    {}

    public async function validate(UserModel $user): Awaitable<Vector<string>>
    {
        $errors = Vector {};

        $username = $user->getUsername();

        if ($this->_isEmpty($username)) {
            $errors->add('Username darf nicht leer sein');
        } else {
            invariant($username !== null, 'if condition is false');
            $foundUser = await $this->_userService->findByUsername($username);
            if ($foundUser !== null) {
                $errors->add('Username schon vergeben');
            }
        }
        if ($this->_isEmpty($user->getFullname())) {
            $errors->add('Voller Name darf nicht leer sein');
        }
        if ($this->_isEmpty($user->getPassword())) {
            $errors->add('Passwort darf nicht leer sein');
        } else if ($user->getPassword() !== $user->getPasswordRepeat()) {
            $errors->add('Passwörter sind nicht gleich');
        }

        return $errors;
    }

    private function _isEmpty(?string $value): bool
    {
        return $value === null || $value === '';
    }
}
