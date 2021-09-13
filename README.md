# snowTricks

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/55b078bdfdd4492d8625abffa511f9a8)](https://www.codacy.com/gh/kenchi-san/snowTricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=kenchi-san/snowTricks&amp;utm_campaign=Badge_Grade)
##installation
Use all packages below
```
composer install
composer require symfony/twig-pack
composer require symfony/filesystem
composer require symfony/string
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
composer require doctrine/annotations
composer require symfony/apache-pack
```

##important!!!!
Don't forget to make it if you have any problem:
```
php bin/console cacheclear
```

##test
###install
```
composer require --dev dama/doctrine-test-bundle
```
loading tests:
```
symfony php bin/phpunit --testdox
```
##fixtures
###install
```
composer require --dev orm-fixtures
```
### load Fixtures
```
php bin/console doctrine:fixtures:load
or
composer reset
```
with "composer reset" you need to setup symfony commands"
<br>
ex: symfony make ....
<br>
if you haven't this, juste change in the file composer.json "symfony" by "php bin/console" and that's will work