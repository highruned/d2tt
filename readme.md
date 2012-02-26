# D2 Trade Tools (D2TT)

Provides tools to assist with your daily Diablo II trading. 

![ss](http://dl.dropbox.com/u/58484258/Screenshots/dkej.png)

## Components

* Signature - Generates a single PNG image with a list of your most recent finds.
* Watcher - Monitors your bot's most recent finds and updates your profile with the list.
* Logger - Currently only provides instructions for logging items from an old D2NT bot.

## Requirements

* PHP 5.3

## Getting started

If all you want is the signature, simply upload the `signature` folder to a webhost, and edit the `watcher/log/items.txt` file with your trade list.

If you want the trade list to be automatically based upon your D2 find list, you will need to integrate your bot. Instructions for an old version of D2NT are found in the `logger/readme.md` file. Basically, you need to generate a log file `watcher/logs/bot1.txt`, and while you are running the `watcher` it will monitor the log file and update the `logs/items.txt` file, which as we saw earlier is pulled in as our signature.