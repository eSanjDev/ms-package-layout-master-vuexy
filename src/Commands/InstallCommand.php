<?php

namespace Esanj\LayoutMaster\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'layout-master:install';
    protected $description = 'Install the Layout Master package';

    public function handle(): int
    {
        if (file_exists(base_path('package.json'))) {
            if ($this->confirm('package.json file already exists. Do you remove it and copy the new one?')) {
                unlink(base_path('package.json'));
                $this->info('package.json removed.');
            } else {
                $this->info('Skipping package.json file copy.');
            }
        }

        if (file_exists(base_path('vite.config.js'))) {
            if ($this->confirm('vite.config.js file already exists. Do you remove it and copy the new one?')) {
                unlink(base_path('vite.config.js'));
                $this->info('vite.config.js removed.');
            } else {
                $this->info('Skipping vite.config.js file copy.');
            }
        }


        $this->info('Installing Layout Master package...');
        $this->call('vendor:publish', [
            '--provider' => "Esanj\\LayoutMaster\\Providers\\LayoutMasterServiceProvider",
        ]);


        $this->info('Layout Master package installed successfully. ✔');
        return self::SUCCESS;
    }
}
