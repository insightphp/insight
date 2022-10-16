<?php


namespace Insight\Resources;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Insight\Resources\Fields\Concerns\ControlsVisibility;
use Insight\Resources\Fields\Concerns\DisplaysInTables;
use Insight\Resources\Fields\Concerns\DisplaysInForms;
use Insight\Resources\Fields\Concerns\DisplaysInPanels;
use Insight\Resources\Fields\Concerns\HasValidationRules;

class Field
{
    use HasValidationRules;
    use DisplaysInTables;
    use DisplaysInForms;
    use DisplaysInPanels;
    use ControlsVisibility;

    /**
     * The title of the field.
     *
     * @var string
     */
    protected string $title;

    /**
     * The name of the attribute for the field.
     * If the attribute is closure, the actual field value is determined by evaluating the closure.
     * If attribute is not set, its name is guessed from title.
     *
     * @var string|\Closure|null
     */
    protected string|\Closure|null $attribute;

    /**
     * Custom callback for retrieving value from model.
     *
     * @var \Closure|null
     */
    protected ?\Closure $getValueUsing = null;

    /**
     * Custom callback for setting model value.
     *
     * @var \Insight\Resources\PendingValue|null
     */
    protected ?PendingValue $setValueUsing = null;

    /**
     * The default value of the field.
     *
     * @var \Insight\Resources\DefaultValue|null
     */
    protected ?DefaultValue $defaultValue = null;

    public function __construct(
        string $title,
        string|\Closure|null $attribute = null
    )
    {
        $this->title = $title;
        $this->attribute = $attribute;
    }

    /**
     * Retrieve title of the field.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Retrieve name of the attribute.
     *
     * @return string
     */
    public function getAttributeName(): string
    {
        if (is_string($this->attribute)) {
            return $this->attribute;
        }

        return $this->guessAttributeName();
    }

    /**
     * Creates attribute name from field title.
     *
     * @return string
     */
    protected function guessAttributeName(): string
    {
        return Str::snake(Str::studly($this->title));
    }

    /**
     * Retrieve attribute value from the Eloquent model.
     *
     * @param \Insight\Resources\Resource $resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return mixed
     */
    protected function getValue(Resource $resource, Model $model): mixed
    {
        // If the attribute is closure, we assume it returns value of the field.
        if ($this->attribute instanceof \Closure) {
            return value($this->attribute, $model, $resource);
        }

        // Otherweise we use attribute value from the model..
        $attribute = $this->getAttributeName();

        if ($this->getValueUsing instanceof \Closure) {
            return value($this->getValueUsing, $model, $attribute, $resource);
        }

        return $model->getAttribute($attribute);
    }

    /**
     * Set custom value resolution callback when resolving value from model.
     *
     * @param \Closure $resolveValue
     * @return $this
     */
    public function getValueUsing(\Closure $resolveValue): static
    {
        $this->getValueUsing = $resolveValue;

        return $this;
    }

    /**
     * Set the value of the model. If the value should be set after model
     * is saved, the PendingValue object must be returned.
     *
     * @param \Insight\Resources\Resource $resource
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param mixed $value
     * @return \Insight\Resources\PendingValue|null
     */
    public function setValue(Resource $resource, Model $model, mixed $value): PendingValue|null
    {
        $attribute = $this->getAttributeName();

        if ($this->setValueUsing instanceof PendingValue) {
            if ($this->setValueUsing->shouldSetAfterSave()) {
                return $this->setValueUsing->saveLater($resource, $model, $attribute, $value);
            }

            return $this->setValueUsing->save($resource, $model, $attribute, $value);
        }

        return PendingValue::set(function (Resource $resource, Model $model, string $attribute, mixed $value) {
            $model->setAttribute($attribute, $value);
        })->save($resource, $model, $attribute, $value);
    }

    /**
     * Set custom callback for setting value of the field.
     *
     * @param \Closure|\Insight\Resources\PendingValue $setValue
     * @return $this
     */
    public function setValueUsing(\Closure|PendingValue $setValue): static
    {
        if ($setValue instanceof \Closure) {
            $this->setValueUsing = PendingValue::set($setValue);
        } else {
            $this->setValueUsing = $setValue;
        }

        return $this;
    }

    /**
     * Determine if the field has default value.
     *
     * @return bool
     */
    public function hasDefaultValue(): bool
    {
        return $this->defaultValue instanceof DefaultValue;
    }

    /**
     * Set the default value of the field.
     *
     * @param mixed $value
     * @return $this
     */
    public function withDefaultValue(mixed $value): static
    {
        $this->defaultValue = new DefaultValue($value);

        return $this;
    }

    /**
     * Retrieve the default value of the field.
     *
     * @param \Insight\Resources\Resource $resource
     * @param \Illuminate\Database\Eloquent\Model|null $model
     * @return mixed
     */
    public function getDefaultValue(Resource $resource, ?Model $model): mixed
    {
        if ($this->defaultValue instanceof DefaultValue) {
            return $this->defaultValue->get($resource, $model);
        }

        return null;
    }

    /**
     * Creates new field instance.
     *
     * @return static
     */
    public static function make(): static
    {
        return new static(...func_get_args());
    }
}
