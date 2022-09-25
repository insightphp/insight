<?php


namespace Insight\Inertia\Tests\Fixtures;


use Insight\Inertia\View\Model;

class UserModel extends Model
{
    /**
     * The identifier of the user.
     *
     * @var int|null
     */
    public ?int $id = 1;

    /**
     * The name of the user.
     *
     * @var string
     */
    public string $name;

    /**
     * The email of the user.
     *
     * @var string|null
     */
    public ?string $email;

    /**
     * The user password.
     *
     * @var string|null
     */
    protected ?string $password;

    /**
     * Retrieves the user password.
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }
}
