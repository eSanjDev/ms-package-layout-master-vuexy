<?php

declare(strict_types=1);

namespace Esanj\LayoutMaster\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'layout-master:install
                            {--force : Force overwrite existing files}';

    protected $description = 'Install the Layout Master package';

    private const CONFIG_FILES = [
        'package.json',
        'vite.config.js',
        'postcss.config.js',
    ];

    public function handle(): int
    {
        $this->info('Installing Layout Master package...');

        $force = $this->option('force');

        if (! $force) {
            $this->handleExistingConfigFiles();
        }

        $this->publishAssets($force);

        $this->info('Layout Master package installed successfully.');

        return self::SUCCESS;
    }

    private function handleExistingConfigFiles(): void
    {
        foreach (self::CONFIG_FILES as $file) {
            $this->handleExistingFile($file);
        }
    }

    private function handleExistingFile(string $filename): void
    {
        $filePath = base_path($filename);

        if (! file_exists($filePath)) {
            return;
        }

        if ($this->confirm("{$filename} already exists. Do you want to overwrite it?", false)) {
            unlink($filePath);
            $this->info("{$filename} removed.");
        } else {
            $this->warn("Skipping {$filename}.");
        }
    }

    private function publishAssets(bool $force): void
    {
        // Without --force, vendor:publish skips files that already exist, so it
        // never clobbers customized views/config. The root config files the user
        // agreed to overwrite were deleted above, so they get republished here.
        $this->call('vendor:publish', [
            '--provider' => 'Esanj\\LayoutMaster\\Providers\\LayoutMasterServiceProvider',
            '--force' => $force,
        ]);
    }
}