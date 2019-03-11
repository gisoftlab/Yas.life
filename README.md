# Yas.life
#
# Installation 
#
composer install
#
# Run 
#
php index.php Spain
php index.php Spain England
php index.php Spain Poland
etc.
#
# test 
#
composer test test/functional/api/CountriesTest.php
or
./vendor/bin/phpunit --bootstrap vendor/autoload.php test/functional/api/CountriesTest.php