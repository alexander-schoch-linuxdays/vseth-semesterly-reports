<?php


namespace App\Model;


use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string[]
     */
    private $roles;

    /**
     * User constructor.
     * @param string $password
     * @param string $username
     * @param string[] $roles
     */
    public function __construct(string $password, string $username, array $roles)
    {
        $this->password = $password;
        $this->username = $username;
        $this->roles = $roles;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // skipped
    }
}
