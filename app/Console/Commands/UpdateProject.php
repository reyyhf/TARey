<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateProject extends Command
{
    protected $signature = 'project:update {--fresh}';

    protected $description = 'Updating Project Repository, Start From Composer To Update or Create Database';

    public function handle()
    {
        try {
            $this->info('Initiating Update Process');

            // Updating Git Repository Project
            $updatingGit = shell_exec('git pull origin master');

            if (! $updatingGit) {
                return $this->error($updatingGit);
            }
            $this->info($updatingGit);

            // Updating Composer Project
            $updatingComposer = shell_exec('composer install && composer dump-autoload -o');

            if (! $updatingComposer) {
                return $this->error($updatingComposer);
            }
            $this->info($updatingComposer);

            $checkEnv = config('app.env');

            if ($checkEnv != 'local') {
                // Building UI
                $buildUI = shell_exec('rm -rf public/build ; bun run build');

                if (! $buildUI) {
                    return $this->error($buildUI);
                }
            }

            if ($this->option('fresh')) {
                // Running Migration Database
                $freshMigrationData = shell_exec('php artisan migrate:fresh');

                if (! $freshMigrationData) {
                    return $this->error($freshMigrationData);
                }
                $this->info($freshMigrationData);

                // Running Seed Database
                $seedData = shell_exec('php artisan db:seed');

                if (! $seedData) {
                    return $this->error($seedData);
                }
                $this->info($seedData);
            } else {
                // Running Migration Database
                $migrateColumn = shell_exec('php artisan migrate');

                if (! $migrateColumn) {
                    return $this->error($migrateColumn);
                }
                $this->info($migrateColumn);
            }

            // Optimizing Project's Cache
            $optimize = shell_exec('php artisan optimize:clear');

            if (! $optimize) {
                return $this->error($optimize);
            }
            $this->info($optimize);

            $this->info('Successfully Update Project');
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
    }
}
