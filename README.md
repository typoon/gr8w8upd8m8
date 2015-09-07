# Gr8W8Upd8M8

## A Wii balance board weight reporter

This is my version of the gr8w8upd8m8 script. I have made a couple of changes
in order to make it easier for me to use it.

* This script now can be ran as a daemon. So you don't have to run it every
  time you want to weight yourself
* After weighting the script posts the result to a service that can be found on
  web/register_weight.php and the data is stored in a SQLite3 database
* I've added a small webpage to display the results of weighting in a graph

The web interface displays the average weight of each day in a per month chart.
So, if you weight yourself everyday for the next 3 months, 3 times a day, you
are going to see 3 charts with the average weight per day for each month (one
chart per month).

Couple features I am still missing:

* Crate some control based on pid to avoid the script from running twice
* Write a shellscript to automate the whole process of pairing the WiiFit board
* A better web interface that would also display the list of all measurements
  that have been made in a month


## FAQ

### Why would you use PHP?

Because it is easy, and was already available and running on my machine

### Why is the code you added so awful?

Well, I wanted a quick and dirty solution (took me a couple hours to do it) and
I wanted to see results. That is why I haven't used any frameworks or stuff
since it would be overkill and would probably have killed my will to do this
project.

### Is this all?

Yep.

## Acknowledgements

Big thanks to Stavros Korokithakis for the work on this and the explanations to
get it working.


# Original README

This script is based on [wiiboard-simple](https://code.google.com/p/wiiboard-simple/), with some dependencies (like
pygame) removed. I'm pretty sure it only works on Linux.

## Requirements

To run `gr8w8upd8m8`, you need:
* Linux.
* The `bluez-utils` package (you might need to install also `python-bluez`).
* Bluetooth.

## Usage

You can run it with:

    ./gr8w8upd8m8.py

It will prompt you to put the board in sync mode and it will search for and connect to it.

If you already know the address, you can just specify it:

    ./gr8w8upd8m8.py <board address>

That will skip the discovery process, and connect directly.

`gr8w8upd8m8` uses the `bluez-test-device` utility of `bluez-utils` to disconnect the board at the end, which causes
the board to shut off. Pairing it with the OS will allow you to use the front button to reconnect to it and run the
script.

Calculating the final weight is done by calculating the mode of all the event data, rounded to one decimal digit.

Feel free to use processor.weight to do whatever you want with the calculated weight (I send it to a server for
further pointless processing).

## License

This software is made available under the [Lesser GPL license](http://www.gnu.org/licenses/lgpl.html).
