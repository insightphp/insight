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
        $contents = json_decode(file_get_contents($file), true);
        Arr::set($contents, 'version', $version);
        file_put_contents($file, json_encode($contents, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL);
    }

}
