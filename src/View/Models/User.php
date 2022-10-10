<?php


namespace Insight\View\Models;


use Insight\Inertia\View\Model;

class User extends Model
{
    /**
     * The name of the authenticated user.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * The profile photo of the authenticated user.
     *
     * @var string|null
     */
    public ?string $profilePhotoUrl = null;

    /**
     * Determine if the name should be visible in the navigation.
     *
     * @var bool
     */
    public bool $shouldShowName = false;

    /**
     * Show the name of the user.
     *
     * @return $this
     */
    public function withNameDisplayed(): static
    {
        $this->shouldShowName = true;

        return $this;
    }

    /**
     * Hide the name of the user.
     *
     * @return $this
     */
    public function withNameHidden(): static
    {
        $this->shouldShowName = false;

        return $this;
    }
}
