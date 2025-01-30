# Headless Commerce

<!-- TOC -->
* [Headless Commerce](#headless-commerce)
  * [Installation](#installation)
  * [Running tests](#running-tests)
<!-- TOC -->

## Installation

Clone the repo locally:

```shell
git clone https://github.com/oshudev/headless-commerce.git
cd headless-commerce
```

Install PHP dependencies:

```shell
composer install
```

Install NPM dependencies:
```shell
npm install
```

Setup configurations:

```shell
cp .env.example .env
```

Generate application key:

```shell
php artisan key:generate
```

Create an SQLite Database:

```shell
touch database/database.sqlite
```

Run database migration:

```shell
php artisan migrate
```

Build assets:

```shell
npm run dev
```

Run artisan server:

```shell
php artisan serve
```

## Running tests
To run the tests, run:

```shell
composer run test
```
