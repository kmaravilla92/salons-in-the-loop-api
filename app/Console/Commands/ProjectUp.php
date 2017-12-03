<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProjectUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kickstart application setup.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Cache clearing started');
        $this->call('cache:clear');
        $this->info('Cache clearing completed');

        $this->info('Views cache clearing started');
        $this->call('view:clear');
        $this->info('Views cache clearing completed');

        $this->info('Database setup started...');
        shell_exec(
            sprintf(
                'mysql -u%s -e "CREATE DATABASE IF NOT EXISTS %s"',
                config('database.connections.mysql.username'),
                config('database.connections.mysql.database')
            )
        );
        $this->info('Database setup completed...');

        $this->info('Database migration started...');
        $this->call('migrate:refresh');
        $this->info('Database migration completed...');

        $this->info('Database seeding started...');
        $this->call('db:seed');
        $this->info('Database seeding completed...');
        
        $this->call('inspire');
        $this->info('I LOVE YOU LABLAB ME :D');
    }
}
