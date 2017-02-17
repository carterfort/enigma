#An enigma emulator

I saw this video about how the Enigma machine worked, and figured it would be fun and easy to build an emulator. It was fun. It was not all that easy.

This was challenging because I wanted to stick as close to the original design of the machine as possible, including the mechanical flaws that allowed the good guys to defeat the encryption back in the 40s. Of course this whole project is not very useful as a means of encryption; so much easier to use bcrypt and an RSA key.

##How to use it

(I use the word "transform" instead of "encrypt" because the machine doesn't have an encrypt/decrypt setting. It just takes an input and runs it through the process. If you feed an encrypted string, it will decrypt it. And vice-versa)

###Command-line

There's a command-line tool you can fire up by navigating to the project directory and running `php artisan enigma`. It will ask you for the rotor order (i.e. "II I III", "IV I V", "I V II", etc.), the offset positions ("4 24 18", "17 5 20", etc.), and then the plugboard configuration ("UD FE RV AB").

Then you can enter one letter a time and receive the transformed response.

###API

You can transform a string by posting to `/api/enigma` with the following body:

```
{
	rotors : "I VI I",
	offsets : "14 3 9",
	plugboard : "UE CN SW BL",
	message : "The message you want to transform"
}
```

It will return the request back with the message field transformed.

###Web interface

If you send a GET request to `/enigma`, you'll get a web interface that allows you to setup your machine and transform a string.


##Classes

###Enigma

Main class exposed to the API. Set up a new one by providing the Rotor order and offsets as well as the Plugboard configuration.

The input is accepted as [A-Z] characters and then transformed into an integer. The integer is run through a series of transformations, with the result translated back into an [A-Z] character.

The process for transformation looks like this:

1. Enigma receives a character and converts it to an index (position in the alphabet)
2. Index is sent through the Plugboard and transformed if appropriate
3. Index is sent through RotorManager right-to-left
4. Index is reflected by the Reflector
5. Index is sent through RotorManager left-to-right
6. Index is sent through the Plugboard again
7. Enigma transforms the index into a letter and returns that
8. Enigma alerts the RotorManager that the circuit has been complete
9. RotorManager handles advancing the rotor offsets as needed

###Plugboard

Swaps two letters before and after being fed through the rotor box. Each letter can only be swapped once since each letter only has one physical slot, and a letter cannot be swapped with itself.

The constructor handles the requirements. If a user tries to build a bad plugboard, an Exception will be raised.

###Rotor

Cross-wired rotors swap letters. Each rotor needs a defined sequence of swaps where each letter is swapped with another in two directions. The current will travel through each rotor twice; once left-to-right, and then back right-to-left.

The transformation process for a rotor works like this:

1. Index received from RotorManager
2. Index input transformed using the current offset of the rotor
3. Index transformed via the rotor map (letter swap)
4. Index output transformed using the current offset of the rotor
5. Output given back to RotorManager

When a rotor has completed a full turn (i.e. the offset has become greater than the total number of posts in the rotor), it resets itself to 0 and sends a message to the RotorManager that it has completed a revolution.

###RotorManager

Contains the three chosen rotors for a given configuration. Accepts an input and a current direction. Passes the index it's given along to each rotor in turn, indicating the direction of the input each time.

Handles the step rotation of the rotors. Listens for completed revolutions to determine if it needs to increment any rotor offsets.

###Reflector

The reflector scrambles the post position in a manner similar to the rotors, except it requires paired posts instead of randomly assigned ones. If the Reflector receives an 8 and returns a 20, it must also return an 8 when receiving a 20. This is not true of the rotors, who might transform 8 => 20 when going left to right, but 20 => 14 when going right to left.

It turns out this was the fatal flaw in the original Enigma machine design, as it meant a letter could never be encoded as itself.