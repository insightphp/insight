<?php


namespace Insight\Inertia;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Insight\Inertia\Exceptions\ViewException;
use Insight\Inertia\View\Component;
use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ComponentManager
{
    /**
     * List of registered components.
     *
     * @var array<\Insight\Inertia\ResolvedComponent>
     */
    protected array $components = [];

    /**
     * Retrieve list of registered components.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRegisteredComponents(): Collection
    {
        return collect($this->components);
    }

    /**
     * Retrieve instance of Resolved component for the given component.
     *
     * @param string $component FQCN of the component or Surface path.
     * @return \Insight\Inertia\ResolvedComponent|null
     */
    public function resolve(string $component): ?ResolvedComponent
    {
        if (class_exists($component)) {
            return $this->getRegisteredComponents()
                ->first(fn (ResolvedComponent $resolvedComponent) => $resolvedComponent->getClass() == $component);
        }

        [$namespace, $path] = Str::contains($component, ':') ? explode(":", $component) : ['app', $component];

        return $this->getRegisteredComponents()
            ->first(
                fn (ResolvedComponent $resolvedComponent) => $resolvedComponent->getNamespace() == $namespace
                    && $resolvedComponent->getPath() == $path
            );
    }

    /**
     * Register View Component within the Component Manager.
     *
     * @param string $class
     * @param string $namespace
     * @param string|null $pathBase
     * @return \Insight\Inertia\ResolvedComponent
     */
    public function addComponent(string $class, string $namespace = 'app', ?string $pathBase = null): ResolvedComponent
    {
        if (! class_exists($class)) {
            throw new ViewException("The class [$class] does not exist and cannot be registered as View Component.");
        }

        if (! Arr::has(class_parents($class), Component::class)) {
            throw new ViewException("The class [$class] is not valid View Component since it does not exted [" . Component::class . '] class.');
        }

        $clazz = new ReflectionClass($class);

        $path = ($pathBase ? (string) Str::of($pathBase)
            ->ltrim('/')->rtrim('/')->append('/') : '') . $clazz->getShortName();

        return tap(new ResolvedComponent($class, $namespace, $path), fn ($component) => $this->addResolvedComponent($component));
    }

    /**
     * Register components from given directory.
     * Returns list of resolved components.
     *
     * @param string $path
     * @param string $namespace
     * @return \Illuminate\Support\Collection
     */
    public function addComponentsFromPath(string $path, string $namespace = 'app'): Collection
    {
        $componentClasses = $this->discoverComponentsInDirectory($path);

        if ($componentClasses->isEmpty()) {
            return collect();
        }

        $commonNamespaceBase = $this->resolveCommonBase($componentClasses->all());

        $components = $componentClasses->map(function (string $class) use ($commonNamespaceBase, $namespace) {
            $componentPath = Str::of($class)
                ->replaceFirst($commonNamespaceBase, '')
                ->ltrim('\\')
                ->replace('\\', '/');

            return new ResolvedComponent($class, $namespace, $componentPath);
        });

        $components->each(fn (ResolvedComponent $component) => $this->addResolvedComponent($component));

        return $components;
    }

    /**
     * Add resolved component to manager.
     *
     * @param \Insight\Inertia\ResolvedComponent $component
     * @return $this
     */
    protected function addResolvedComponent(ResolvedComponent $component): static
    {
        $this->components[] = $component;

        return $this;
    }

    /**
     * Search for base namespace base of given class list.
     * Given class list:
     *  - App\View\Components\User
     *  - App\View\Components\Customers\Avatar
     *  - App\View\Components\Customers\Settings
     * will resolve to App\View\Components since it is the common namespace for all classes.
     *
     * @param array $classes
     * @return string
     */
    protected function resolveCommonBase(array $classes): string
    {
        if (empty($classes)) {
            throw new \LogicException("There must be at least one class to resolve its common namespace base.");
        }

        if (count($classes) == 1) {
            return Str::of($classes[0])->replaceLast(class_basename($classes[0]), '')->rtrim('\\');
        }

        sort($classes);
        $first = Arr::first($classes);
        $last = Arr::last($classes);

        for ($eq = 0; $eq < min(strlen($first), strlen($last) && $first[$eq] == $last[$eq]); $eq++);

        return rtrim(substr($first, 0, $eq), "\\");
    }

    /**
     * Searches for View Component classes in given directory.
     *
     * @param string $path
     * @return \Illuminate\Support\Collection
     */
    protected function discoverComponentsInDirectory(string $path): Collection
    {
        if (! file_exists($path)) {
            return collect();
        }

        return collect((new Finder)->files()->name("*.php")->in($path))->map(function (SplFileInfo $fileInfo) {
            // Search for class namespace from file.
            preg_match_all('/^\s*namespace\s+(.*);$/m', $fileInfo->getContents(), $matches, PREG_SET_ORDER);
            if (count($matches) == 1 && count($matches[0]) == 2) {
                $clazz = $matches[0][1] . '\\' . $fileInfo->getFilenameWithoutExtension();

                if (class_exists($clazz) && Arr::has(class_parents($clazz), Component::class)) {
                    return $clazz;
                }
            }

            return null;
        })->filter()->values();
    }

}
