#An enigma emulator

1. Sessions: we need to store the state of the various rotors and the plugboard
2. Each query will be for a single letter, not a string, since we'll be seeing the results in real-time as we type
3. The Rotors and Plugboard need to be configurable and resettable.
4. Input/Output API -> Should work as a command-line tool OR a JS app

##Classes

###Enigma

Main class exposed to the API. Set up a new one by providing the Plugboard configuration and the Rotor positions

setup(String, String) // Rotor Numbers, Plugboard Settings
transform(Character) //

###Plugboard

Handles the first layer of transformation by transposing 10 sets of two letters

No methods exposed. Just init off the plugboard settings when the Enigma class is created

###Rotor

Each letter is swapped for another here. The three Rotors turn at different speeds, so the Rotor position is important

Rotors have letters, and when their Turnover letter is reached, they turn the rotor to their left forward one letter. The rightmost Rotor has no turnover letter, and therefore advances with every key stroke

###RotorManager

Handles the Rotor rotation. Keeps track of when each Rotor should turn

###Reflector

Sends the signal back through the Rotors, this time in reverse order