<?php


namespace Insight\Forms\Concerns;

use Illuminate\Support\Facades\Validator;
use Insight\Forms\FormControl;
use Insight\Forms\Validation\PendingValidation;

/**
 * @mixin \Insight\Forms\Form
 */
trait ValidatesFormValue
{
    /**
     * Creates new pending validation.
     *
     * @return \Insight\Forms\Validation\PendingValidation
     */
    protected function createPendingValidation(): PendingValidation
    {
        $pendingValidation = PendingValidation::make($this->getDataForValidator(), $this->context);

        $this->controls()->each(fn (FormControl $control) => $control->configureValidation($pendingValidation));

        return $pendingValidation;
    }

    /**
     * Retrieve validation rules for the form.
     *
     * @return array
     */
    public function getRulesForValidator(): array
    {
        return $this->createPendingValidation()->rules()->toRules();
    }

    /**
     * Retrieve data that are going to be validated.
     *
     * @return array
     */
    public function getDataForValidator(): array
    {
        return $this->value();
    }

    /**
     * Creates new Validator instance for the form.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createValidator(): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make(
            data: $this->getDataForValidator(),
            rules: $this->getRulesForValidator()
        );
    }

    /**
     * Retrieve value of the form. Performs validation before retrieving data.
     *
     * @param bool $onlyValidated if the retrurned value should contains only validated fields
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validatedValue(bool $onlyValidated = false): array
    {
        $validator = $this->createValidator();

        if ($onlyValidated) {
            return $validator->validate();
        }

        $validator->validate();

        return $this->value();
    }

    /**
     * Validate submitted form.
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(): void
    {
        $validator = $this->createValidator();

        $validator->validate();
    }
}
