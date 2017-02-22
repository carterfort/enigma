<?php

namespace App\Console\Commands;

use Enigma\Enigma;
use Illuminate\Console\Command;

class Console extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enigma';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a sequence of letters through the machine';

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

        $rotors = $this->ask('Enter Rotor Numbers (i.e. I IV II, III V II, I III II) ');
        $offsets = $this->ask('Enter The Rotor Offsets (i.e. 17 10 22, 8 2 3, 20 10 7)');
        $plugboard = $this->ask('Enter Plugboard Settings (i.e. AS PO EN DJ XW ) You cannot enter the same letter twice');

        //Set up our Enigma with the rotors and plugboard
        $enigma = new Enigma($rotors, $offsets, $plugboard);

        $limit = 1000;
        $letters = collect([]);
        $stop = false;

        //Get our input from the user

        while ($letters->count() < $limit && ! $stop){
            $letter = $this->ask('Enter a letter');

            if ($letter == 'STOP'){
                $stop = true;
            } else {

                //Output the transcoded letters
                $plaintextLetter = substr($letter, 0, 1);
                $transformedLetter = $enigma->transform($plaintextLetter);
                $letters->push($transformedLetter);
                $this->info($letters->implode(''));
            }
        }

    }
}
