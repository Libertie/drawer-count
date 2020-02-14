# drawer-count

<a href="LICENSE" target="_blank">
    <img alt="Software License" src="https://img.shields.io/badge/license-GPL3-brightgreen.svg?style=flat-square">
</a>

A small app to count cash register drawers. Drawer and denomination counts can be preserved in a file database for later review or auditing purposes.

## Features

* Drawer total and discrepancy calculation
* Currency localization
* Denomination sort customization
* Historic count preservation and review

## Compatibility

Tested on Linux Mint in the latest Firefox.

## Dependencies

* PHP 7+
* SQLite 3
* PDO Driver for SQLite 3
* PHP-Intl Extension

In a vanilla Ubuntu installation, you may be able to add all dependencies with `sudo apt install git php sqlite php-sqlite3 php-intl`.

## Getting Started

Clone the repository in the current directory:

```
git clone https://github.com/Libertie/drawer-count.git
```

Copy the sample config file, and edit it as needed:

```
cp drawer-count/config.sample.php drawer-count/config.php
nano drawer-count/config.php
```

Run the app on your localhost:

```
php -S localhost:8000 -t drawer-count/
```

The app should now be available at [http://localhost:8000](http://localhost:8000)!