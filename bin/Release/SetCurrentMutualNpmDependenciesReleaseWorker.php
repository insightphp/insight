<?php


namespace Insight\Release;


use Illuminate\Support\Arr;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;

class SetCurrentMutualNpmDependenciesReleaseWorker implements ReleaseWorkerInterface
{
    public function getDescription(Version $version): string
    {
        return "Set NPM packages mutual dependencies to {$version->getVersionString()} version";
    }

    public function work(Version $version): void
    {
        $allPackages = NpmPackageUtils::collectPackages();

        collect(NpmPackageUtils::collectPackages())->each(function ($package) use ($allPackages, $version) {
            $otherPackages = collect($allPackages)->filter(function ($p) use ($package) {
                return $p['name'] != $package['name'];
            })->all();

            $json = NpmPackageUtils::getPackageJson($package['file']);

            foreach ($otherPackages as $dependency) {
                // Dependency
                if (Arr::has($json, "dependencies.{$dependency['name']}")) {
                    Arr::set($json, "dependencies.{$dependency['name']}", $version->getVersionString());
                }

                // Dev dependency
                if (Arr::has($json, "devDependencies.{$dependency['name']}")) {
                    Arr::set($json, "devDependencies.{$dependency['name']}", $version->getVersionString());
                }
            }

            NpmPackageUtils::savePackageJson($json, $package['file']);
        });
    }
}
