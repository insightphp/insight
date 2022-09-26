<?php


namespace Insight\Inertia;


use Illuminate\Support\Str;

class ResolvedComponent
{
    public function __construct(
        protected string $clazz,
        protected string $namespace,
        protected string $path
    ) {}

    /**
     * Retrieve the component class.
     *
     * @return string
     */
    public function getClass(): string
    {
        return $this->clazz;
    }

    /**
     * Retrieve the namespace name of the view component.
     *
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * Retrieve relative path within the namespace of the component which should match Vue component path.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Retrieve the component name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getNamespace() . '-' . Str::of($this->getPath())->replace('/', '')->kebab();
    }

}
