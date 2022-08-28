<?php


namespace Insight\Forms\Validation;


use Insight\Forms\Contracts\FormContext;

class PendingValidation
{
    protected Rules $rules;

    protected ?FormContext $context = null;

    public function __construct(
        protected array $dataBeeingValidated
    )
    {
        $this->rules = new Rules();
    }

    /**
     * Set validation context on pending validation.
     *
     * @param \Insight\Forms\Contracts\FormContext $context
     * @return $this
     */
    protected function withContext(FormContext $context): static
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Retrieve context of the pending validation.
     *
     * @return \Insight\Forms\Contracts\FormContext|null
     */
    public function context(): ?FormContext
    {
        return $this->context;
    }

    /**
     * Determine if the pending validation has given context.
     *
     * @return bool
     */
    public function hasContext(): bool
    {
        return $this->context != null;
    }

    /**
     * Retrieve context of given instance or throws exception.
     *
     * @template T
     * @param class-string<T> $context
     * @return T
     */
    public function requireContext(string $context): mixed
    {
        if ($this->hasContext()) {
            if (get_class($this->context()) == $context) {
                return $this->context();
            }
        }

        throw new \RuntimeException("The context is not set.");
    }

    /**
     * Retrieve data that is beeing validated.
     *
     * @return array
     */
    public function dataBeeingValidated(): array
    {
        return $this->dataBeeingValidated;
    }

    /**
     * Rules applied on the validator.
     *
     * @return \Insight\Forms\Validation\Rules
     */
    public function rules(): Rules
    {
        return $this->rules;
    }

    /**
     * Creates new pending validation.
     *
     * @param array $dataBeeingValidated
     * @param \Insight\Forms\Contracts\FormContext|null $context
     * @return \Insight\Forms\Validation\PendingValidation
     */
    public static function make(array $dataBeeingValidated, ?FormContext $context = null): PendingValidation
    {
        $validation = new PendingValidation($dataBeeingValidated);

        if ($context != null) {
            $validation->withContext($context);
        }

        return $validation;
    }
}
