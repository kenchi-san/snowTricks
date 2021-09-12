# snowTricks

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/55b078bdfdd4492d8625abffa511f9a8)](https://www.codacy.com/gh/kenchi-san/snowTricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=kenchi-san/snowTricks&amp;utm_campaign=Badge_Grade)
##installation
Use all packages below
```
composer install
composer require symfony/twig-pack
composer require symfony/filesystem
composer show twig/twig
composer require symfony/string
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
composer require doctrine/annotations
composer require symfony/twig-pack
composer require symfony/apache-pack
```

##important!!!!
Don't forget to make if you have a problem:
```
php bin/console cacheclear
```

##test
```
composer require --dev dama/doctrine-test-bundle
symfony php bin/phpunit --testdox
```
##fixtures
```
composer require --dev orm-fixtures
php bin/console doctrine:fixtures:load
```