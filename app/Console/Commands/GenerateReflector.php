<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateReflector extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:reflector';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a Reflector';

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
            
        $left = collect(range(0, 25));
        $right = collect(range(0, 25));

        $pairs = collect([]);

        $i = 0;

        while($left->count() > 0)
        {

            $leftKey = 1;
            $rightKey = 1;

            while($leftKey == $rightKey){
                $leftKey = $left->random();
                $rightKey = $right->random();
            }



            $left->forget($leftKey);
            $right->forget($rightKey);
            $left->forget($rightKey);
            $right->forget($leftKey);

            $pairs->push([$leftKey, $rightKey]);

            $i++;
        }

        dd($pairs->toJson());
    }
}
