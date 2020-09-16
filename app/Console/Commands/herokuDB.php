<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class herokuDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:herokudb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'set heroku clearDB';

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
     * @return int
     */
    public function handle()
    {
        echo exec('heroku config:set DB_HOST=us-cdbr-east-02.cleardb.com');
        echo exec('heroku config:set DB_DATABASE=heroku_5551255eedaa227');
        echo exec('heroku config:set DB_USERNAME=b63ea54c55b600');
        echo exec('heroku config:set DB_PASSWORD=bf5c08f0');
    }
}
