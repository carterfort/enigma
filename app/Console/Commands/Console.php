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
    protected $description = 'Run a letter through the machine';

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
        // $rotors = $this->ask('Enter Rotor Numbers');
        // $plugboard = $this->ask('Enter Plugboard Settings');
        // 
        $rotors = $plugboard = 'I II III';

        $enigma = new Enigma($rotors, $plugboard);

        $message = $this->ask('Message?');

        $plain = collect(str_split($message));
        $transformed = $plain->map(function($character) use ($enigma){
            if ($character != ' ')
                return $enigma->transform($character);
        });
        
        $this->info($transformed->implode(''));

        return;

        //Set up our Enigma with the rotors and plugboard
        
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
