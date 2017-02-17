<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateRotor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:rotor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a set of Rotor Keys';

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
            
        $right = collect(range(0, 25));

        dd($right->shuffle()->toJson());
    }
}
