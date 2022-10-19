<?php


namespace Insight\Release;


use MonorepoBuilder202209\Symfony\Component\Console\Style\SymfonyStyle;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

class PublishNpmPackageReleaseWorker implements ReleaseWorkerInterface
{
    /**
     * @var \Symplify\MonorepoBuilder\Release\Process\ProcessRunner
     */
    private $processRunner;

    /**
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    private $symfonyStyle;
    public function __construct(SymfonyStyle $symfonyStyle, ProcessRunner $processRunner)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->processRunner = $processRunner;
    }

    public function getDescription(Version $version): string
    {
        return "Build NPM packages";
    }

    public function work(Version $version): void
    {
        collect(NpmPackageUtils::collectPackages())
            ->reverse()
            ->each(function ($package) {
                $dir = $package['path'];

                $this->symfonyStyle->info("Building {$package['name']}");

                $out = $this->processRunner->run("npm run pack", $dir);

                if ($this->symfonyStyle->isVerbose()) {
                    $this->symfonyStyle->note($out);
                }

                $out = $this->processRunner->run("npm run publish --access public", $dir);

                if ($this->symfonyStyle->isVerbose()) {
                    $this->symfonyStyle->note($out);
                }
            });
    }
}
