# snowTricks

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/2421adac9f87401f928be3109730636c)](https://app.codacy.com/gh/kenchi-san/snowTricks?utm_source=github.com&utm_medium=referral&utm_content=kenchi-san/snowTricks&utm_campaign=Badge_Grade_Settings)


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