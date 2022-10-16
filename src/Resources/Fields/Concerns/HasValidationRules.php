<?php


namespace Insight\Resources\Fields\Concerns;


trait HasValidationRules
{
    /**
     * The rules used for resource creation.
     *
     * @var \Closure|string|array|null
     */
    protected \Closure|string|array|null $creationRules = null;

    /**
     * The rules used for resource update.
     *
     * @var \Closure|string|array|null
     */
    protected \Closure|string|array|null $updateRules = null;

    /**
     * Set the rules for creation and update.
     *
     * @param \Closure|string|array|null $rules
     * @return $this
     */
    public function rules(\Closure|string|array|null $rules): static
    {
        return $this->creationRules($rules)->updateRules($rules);
    }

    /**
     * Set the rules for creation.
     *
     * @param \Closure|string|array|null $rules
     * @return $this
     */
    public function creationRules(\Closure|string|array|null $rules): static
    {
        $this->creationRules = $rules;

        return $this;
    }

    /**
     * Retrieve rules used for creation.
     *
     * @return array|string|\Closure|null
     */
    public function getCreationRules(): array|string|\Closure|null
    {
        return $this->creationRules;
    }

    /**
     * Set the rules for update.
     *
     * @param \Closure|string|array|null $rules
     * @return $this
     */
    public function updateRules(\Closure|string|array|null $rules): static
    {
        $this->updateRules = $rules;

        return $this;
    }

    /**
     * Retrieve rules used for update.
     *
     * @return array|string|\Closure|null
     */
    public function getUpdateRules(): array|string|\Closure|null
    {
        return $this->updateRules;
    }
}
