# Demo

Demo project of the CodeCollab project libraries

This project is meant to implement the different packages / libraries to find out whether they work nicely in an actual project as well as have some sort of intergration test

[![Build Status](https://travis-ci.org/CodeCollab/Demo.svg?branch=master)](https://travis-ci.org/CodeCollab/Demo) [![MIT License](https://img.shields.io/badge/license-MIT-blue.svg)](mit) [![Latest Stable Version](https://poser.pugx.org/codecollab/demo/v/stable)](https://packagist.org/packages/codecollab/demo) [![Total Downloads](https://poser.pugx.org/codecollab/demo/downloads)](https://packagist.org/packages/codecollab/demo) [![Latest Unstable Version](https://poser.pugx.org/codecollab/demo/v/unstable)](https://packagist.org/packages/codecollab/demo)

## Requirements

PHP7+

## Installation

```
composer create-project codecollab/demo . 1.0.*
```

or

```
$ git clone https://github.com/CodeCollab/Demo && composer install
```

To setup apache you need to route all requests through the `index.php` file in the /public directory. This directory must also be your document root.

```
<VirtualHost *:80>
  ServerName codecollabdemo.local
  DocumentRoot "/path/to/the/project/public"

  FallbackResource /index.php
</VirtualHost>
```

If you are using nginx I assume you know what you are doing and you will be able to set it up yourself.

Generate a new encryption key by running:

```
$ php ./cli/generate-encryption-key.php
```

## Contributing

[How to contribute][contributing]

## License

[MIT][mit]

[contributing]: https://github.com/CodeCollab/Demo/blob/master/CONTRIBUTING.md
[mit]: http://spdx.org/licenses/MIT
