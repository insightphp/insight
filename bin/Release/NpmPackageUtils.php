<?php


namespace Insight\Release;


use Illuminate\Support\Arr;

final class NpmPackageUtils
{
    public static function collectPackages(): array
    {
        $path = __DIR__ . '/../../packages';

        return collect(scandir(__DIR__ . '/../../packages'))
            ->filter(fn ($dir) => ! in_array($dir, [".", ".."]))
            ->map(fn ($dir) => realpath($path . '/' . $dir))
            ->filter(fn ($dir) => is_dir($dir))
            ->prepend(realpath(__DIR__ . '/../../'))
            ->map(function ($packageDir) {
                $file = $packageDir . '/package.json';
                if (file_exists($file)) {

                    $name = Arr::get(json_decode(file_get_contents($file), true), 'name');

                    return [
                        'path' => $packageDir,
                        'name' => $name,
                        'file' => $file,
                    ];
                }

                return null;
            })->filter()->all();
    }

    public static function setPackageVersion(string $file, string $version): void
    {
        static::setPackageJsonValue('version', $version, $file);
    }

    public static function getPackageJson(string $file): array
    {
        return json_decode(file_get_contents($file), true);
    }

    public static function savePackageJson(array $contents, string $file): void
    {
        file_put_contents($file, json_encode($contents, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL);
    }

    public static function setPackageJsonValue(string $key, string $value, string $file): void
    {
        $contents = NpmPackageUtils::getPackageJson($file);
        Arr::set($contents, $key, $value);
        NpmPackageUtils::savePackageJson($contents, $file);
    }
}
