up:
	cd .docker && ./run.sh

start:
	cd .docker && docker-compose start

down:
	cd .docker && docker-compose down

migrate:
	cd .docker && docker-compose exec php-fpm php artisan migrate$(opt)

seed:
	cd .docker && docker-compose exec php-fpm php artisan db:seed

test:
	cd .docker && docker-compose exec php-fpm ./vendor/bin/phpunit

config-clear:
	cd .docker && docker-compose exec php-fpm php artisan config:clear

container:
	cd .docker && docker-compose exec php-fpm php artisan $(cmd)

optimize:
	cd .docker && docker-compose exec php-fpm php artisan optimize