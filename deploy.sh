git pull
composer install
yarn install
php ./bin/console doctrine:migrations:migrate --no-interaction
php ./bin/console cache:clear
chmod -R 777 ./var/
yarn build
