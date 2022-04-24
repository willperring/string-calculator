# String Calculator

This repository has been organised in such a way that, starting with version 0.1.0
as the barebones repository, each requirement in the task brief has been treated
as a new minor version. By viewing the codebase as it exists at each tag, the 
progression in structure can be visible. Commits have been performed atomically.

## Requirements

This library required a PHP version of 8.0 upwards.

## Installation

### Composer Dependencies

PHPUnit is required to run tests. Install dependencies with

```shell
composer install --dev
```

## Running tests

To run PHPUnit tests in a Mac or *nix environment:

```shell
bin/test
```

If this script doesn't run, check that it has the execute permission,
or run PHPUnit straight from the vendor directory with:

```shell
vendor/bin/phpunit
```

## Running manually

To run the calculator manually, you can use the command:

```shell
bin/add <string>
```

This will likely need to be quoted, particularly is using spaces or custom
separators.

```shell
bin/add "//;\n1;2;3"
```




