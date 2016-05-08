# Lastfm app demo in slim

## Install

You'll need to have composer installed on your system.

Then run:

  composer install

We use the robo task runner to handle some common taks.  To List commands:

  vendor/bin/robo list

To start a dev server (php -S):
  vendor/bin/robo server:start [<port>]

You should be able to point your browser to http\://localhost:<port>/ .

A tmp/ directory will be created automatically by the app.
tmp/cache/templates will store compiled templates.

## Testing

To run acceptance / end-to-end tests:
  vendor/bin/robo test:acceptance

