# tldr-php
[![Travis](https://img.shields.io/travis/BrainMaestro/tldr-php.svg?style=flat-square)](https://travis-ci.org/BrainMaestro/tldr-php)
[![Packagist](https://img.shields.io/packagist/v/brainmaestro/tldr-php.svg?style=flat-square)](https://packagist.org/packages/brainmaestro/tldr-php)
> A `PHP` based command-line client for [tldr](https://github.com/tldr-pages/tldr).

![tldr screenshot](screenshot.png)

## Installing
```sh
composer global require brainmaestro/tldr
```

## Usage
To see tldr pages:
  
- `tldr <command>` show examples for this command
- `tldr <command> --p=<platform>` show command page for the given platform (`linux`, `osx`, `sunos`)

The client caches a copy of all pages locally, in `~/.tldr`.
There are more commands to control the local cache:

- `tldr --update` download latest version of pages in your local cache
- `tldr --clear-cache` delete the entire local cache

## Related
- [tldr-node-client](https://github.com/tldr-pages/tldr-node-client) - source of documentation and cache functionality
## License
MIT © Ezinwa Okpoechi
