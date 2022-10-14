<?php


namespace Insight\Resources;


use Illuminate\Database\Eloquent\Model;

class PendingValue
{

    protected ?Resource $resource = null;
    protected ?Model $model = null;
    protected ?string $attribute = null;
    protected mixed $value = null;

    public function __construct(
        protected \Closure $setter,
        protected bool $afterSave = false,
        protected int $priority = 0
    ) {}

    /**
     * Determine if the value should be set after save.
     *
     * @return bool
     */
    public function shouldSetAfterSave(): bool
    {
        return $this->afterSave === true;
    }

    /**
     * Save scheduled model value.
     *
     * @return null
     */
    public function savePendingValue()
    {
        if (is_null($this->resource) || is_null($this->model) || is_null($this->attribute)) {
            throw new \LogicException("The pending value could not be saved since saveLater was not called.");
        }

        return $this->save($this->resource, $this->model, $this->attribute, $this->value);
    }

    /**
     * Schedule setting of model attribute.
     *
     * @param \Insight\Resources\Resource $resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $attribute
     * @param mixed $value
     * @return $this
     */
    public function saveLater(Resource $resource, Model $model, string $attribute, mixed $value): static
    {
        $this->resource = $resource;
        $this->model = $model;
        $this->attribute = $attribute;
        $this->value = $value;

        return $this;
    }

    /**
     * Set model attribute using provided setter.
     *
     * @param \Insight\Resources\Resource $resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $attribute
     * @param mixed $value
     * @return null
     */
    public function save(Resource $resource, Model $model, string $attribute, mixed $value)
    {
        call_user_func($this->setter, $resource, $model, $attribute, $value);

        return null;
    }

    /**
     * Create value setter which.
     *
     * @param \Closure $setter
     * @param int $priority
     * @return \Insight\Resources\PendingValue
     */
    public static function set(\Closure $setter, int $priority = 0): PendingValue
    {
        return new PendingValue($setter, afterSave: false, priority: $priority);
    }

    /**
     * Create value setter which will be executed after model has been saved.
     *
     * @param \Closure $seetter
     * @param int $priority
     * @return \Insight\Resources\PendingValue
     */
    public static function setAfterSave(\Closure $seetter, int $priority = 0): PendingValue
    {
        return new PendingValue($seetter, afterSave: true, priority: $priority);
    }
}
