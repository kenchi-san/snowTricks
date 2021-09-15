# snowTricks

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/55b078bdfdd4492d8625abffa511f9a8)](https://www.codacy.com/gh/kenchi-san/snowTricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=kenchi-san/snowTricks&amp;utm_campaign=Badge_Grade)

## Description



## Installation

Clone repository and install dependencies

```
git clone https://github.com/kenchi-san/snowTricks.git
cd snowTricks
composer install
```

Create a copy of .env file to .env.local with your own settings


Initialize database

```
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate

```

## Important
Don't forget to clean cache if you have any problem:
```
php bin/console cache:clear
```

## Running tests
Load fixtures before launch tests.

```
php bin/phpunit --testdox
```

## Load Fixtures

```
php bin/console doctrine:fixtures:load
or
composer reset
```
with "composer reset" you need to install "[symfony binary](https://symfony.com/doc/current/best_practices.html#use-the-symfony-binary-to-create-symfony-applications)"
