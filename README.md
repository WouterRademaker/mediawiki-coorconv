# CoordinateConversion

Conversion of geographical coordinates to various systems.

## Features

 * [Special page](https://www.mediawiki.org/wiki/Manual:Special_pages) (specials/SpecialHelloWorld.php)
 * [Parser hook](https://www.mediawiki.org/wiki/Manual:Parser_functions) (CoordinateConversion/CoordinateConversion.hooks.php)
 * [Gerrit integration](https://www.mediawiki.org/wiki/Gerrit) (.gitreview)

## Development on Linux (OS X anyone?)
To take advantage of this automation, use the Makefile: `make help`. To start,
run `make install` and follow the instructions.

## Development on Windows
Since you cannot use the `Makefile` on Windows, do the following:

  # Install nodejs, npm, and PHP composer
  # Change to the extension's directory
  # npm install
  # composer install

Once set up, running `npm test` and `composer test` will run automated code checks.

Mediawiki extension Coorconv - copied from http://www.mediawiki.org/w/index.php?title=Extension:Coorconv&oldid=522110

More information at http://www.mediawiki.org/wiki/Extension:Coorconv

This Mediawiki Extension was written by user Egel on Scoutwiki / MediaWiki.


