<?php

namespace App\Http\Controllers;

use Enigma\Enigma;
use Illuminate\Http\Request;

class EnigmaController extends Controller
{
    public function transform(Request $request)
    {
    	$this->validate($request, [
    		"rotors" => 'required',
    		"offsets" => 'required',
    		"plugboard" => 'required',
    		"message" => 'required'
		]);

		$machine = new Enigma($request->rotors, $request->offsets, $request->plugboard);
		$transformedMessage = $machine->transformMessage($request->message);

		$request = $request->all();
		$request['message'] = $transformedMessage;

		return $request;
    }
}
