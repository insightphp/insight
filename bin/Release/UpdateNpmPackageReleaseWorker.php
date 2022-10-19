<?php

namespace Insight\Release;

class UpdateNpmPackageReleaseWorker implements \Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface
{

    public function getDescription(\PharIo\Version\Version $version): string
    {
        return "test";
    }

    public function work(\PharIo\Version\Version $version): void
    {
        // TODO: Implement work() method.
    }
}
