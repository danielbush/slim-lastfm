# Lastfm app demo in slim

## Install

You'll need to have composer installed on your system.

Then run:

    composer install

Then create a config.yml; use config.dist.yml as a guide.

We use the robo task runner to handle some common taks.  To List commands:

    vendor/bin/robo list

To start a dev server (php -S):

    vendor/bin/robo server:start [<port>]

You should be able to point your browser to http\://localhost:<port>/ .

A ```tmp/``` directory will probably be created automatically by the app.
If not, you may need to do so with appropriate permissions.
```tmp/cache/templates``` will store compiled templates.

## Testing

To run acceptance / end-to-end tests:

    vendor/bin/robo test:acceptance

"Unit" tests:

    vendor/bin/robo test

## TODO ##

* not handling error responses from the api atm; if they fail eg bad key, the app will throw an error; I don't have anything that says: "couldn't get result for country X" etc
* php 5.5 behaving strangely when doing live connections; it might have been my vm; php 7 seems ok
* getting top artists by country with page=4 limit=5 gives backup more than 5 results; maybe I misinterpreted something
* I used phpspec for the tests and found it quite awkward; it forces you to work almost exclusively with instantiable objects; no nested describes/contexts; probably should have stuck with phpunit
* I probably should have looked for a lastfm client on packagist

