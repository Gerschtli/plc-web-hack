<?hh // strict

namespace PLC\Model;

class User
{
    private ?int $_id;
    private ?string $_fullname;
    private ?string $_username;
    private ?string $_password;

    public static function create(Map<string, mixed> $data): User
    {
        $id       = $data['user_id'];
        $fullname = $data['fullname'];
        $username = $data['username'];
        $password = $data['password'];

        invariant(is_int($id), 'User data wrong type');
        invariant(is_string($fullname), 'User data wrong type');
        invariant(is_string($username), 'User data wrong type');
        invariant(is_string($password), 'User data wrong type');

        $user = new User();
        $user->setId($id);
        $user->setFullname($fullname);
        $user->setUsername($username);
        $user->setPassword($password);

        return $user;
    }

    public function getId(): ?int
    {
        return $this->_id;
    }

    public function setId(int $id): void
    {
        $this->_id = $id;
    }

    public function getFullname(): ?string
    {
        return $this->_fullname;
    }

    public function setFullname(string $fullname): void
    {
        $this->_fullname = $fullname;
    }

    public function getUsername(): ?string
    {
        return $this->_username;
    }

    public function setUsername(string $username): void
    {
        $this->_username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->_password;
    }

    public function setPassword(string $password): void
    {
        $this->_password = $password;
    }
}
