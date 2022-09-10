<?php


namespace Insight\Inertia;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Insight\Inertia\Exceptions\ViewComponentException;
use League\Flysystem\WhitespacePathNormalizer;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ViewComponentManager
{
    /**
     * List of view components and their namespaces.
     *
     * @var array
     */
    protected array $components = [];

    /**
     * Register components in given folder.
     *
     * @param string $path
     * @param string $namespace
     * @return $this
     */
    public function registerComponentsIn(string $path, string $namespace): static
    {
        collect((new Finder())
            ->files()
            ->name("*.php")
            ->in($path))
            ->each(function (SplFileInfo $info) use ($path, $namespace) {
                preg_match_all('/^\s*namespace\s+(.*);$/m', $info->getContents(), $matches, PREG_SET_ORDER);

                if (count($matches) == 1 && count($matches[0]) == 2) {
                    $clazz = $matches[0][1] . '\\' . $info->getFilenameWithoutExtension();

                    if (class_exists($clazz) && Arr::has(class_parents($clazz), ViewComponent::class)) {
                        $relativePath = (string) Str::of(realpath($info->getPath()) . '\\' . $info->getFilenameWithoutExtension())
                            ->replaceFirst(realpath($path), "")
                            ->ltrim('\\/');

                        $this->registerComponent($clazz, $namespace, $relativePath);
                    }
                }
            });

        return $this;
    }

    /**
     * Register component class under given namespace.
     *
     * @param string $class
     * @param string $namespace
     * @param string $relativePath
     * @return $this
     */
    protected function registerComponent(string $class, string $namespace, string $relativePath): static
    {
        $this->components[$class] = [
            'namespace' => $namespace,
            'relativePath' => $relativePath,
        ];

        return $this;
    }

    public function findComponentRelativeName(ViewComponent $component): string
    {
        $clazz = get_class($component);

        if (Arr::has($this->components, $clazz)) {
            return Arr::get($this->components, "{$clazz}.relativePath");
        }

        throw new ViewComponentException("The component {$clazz} is not registered in any namespace.");
    }

    public function findNamespaceForComponent(ViewComponent $component): string
    {
        $clazz = get_class($component);

        if (Arr::has($this->components, $clazz)) {
            return Arr::get($this->components, "{$clazz}.namespace");
        }

        throw new ViewComponentException("The component {$clazz} is not registered in any namespace.");
    }
}
