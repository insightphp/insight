<?php


namespace Insight\Resources\Dialogs;


use Illuminate\Support\Arr;
use Insight\View\Components\Dialogs\Dialog;

abstract class DialogFactory
{
    /**
     * The dialog data.
     *
     * @var array
     */
    protected array $input = [];

    /**
     * Set the dialog input.
     *
     * @param array $input
     * @return $this
     */
    protected function withInput(array $input): static
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Retrieve the input value.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    protected function input(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->input, $key, $default);
    }

    /**
     * Retrieve the boolean value from data.
     *
     * @param string $key
     * @param bool $default
     * @return bool
     */
    protected function boolean(string $key, bool $default = false): bool
    {
        return filter_var($this->input($key, $default), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Determine if dialog has given data.
     *
     * @param string $key
     * @return bool
     */
    protected function has(string $key): bool
    {
        return Arr::has($this->input, $key);
    }

    /**
     * Creates new dialog using the factory.
     *
     * @param array $input
     * @param mixed ...$args
     * @return \Insight\View\Components\Dialogs\Dialog|null
     */
    public static function create(array $input, mixed ...$args): ?Dialog
    {
        $factory = (new static(...$args))->withInput($input);

        if (! method_exists($factory, 'build')) {
            throw new \LogicException("The dialog factory [".static::class."] does not have build method.");
        }

        return app()->call([$factory, 'build']);
    }
}
