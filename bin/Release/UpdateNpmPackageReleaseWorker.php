<?php

namespace Insight\Release;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;

class UpdateNpmPackageReleaseWorker implements ReleaseWorkerInterface
{

    public function getDescription(Version $version): string
    {
        return "Update NPM package versions to {$version->getVersionString()}";
    }

    public function work(Version $version): void
    {
        collect(NpmPackageUtils::collectPackages())->each(function ($package) use ($version) {
            NpmPackageUtils::setPackageVersion($package['file'], $version->getVersionString());
        });
    }

}
