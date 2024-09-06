# start services
build:
	docker compose build
up:
	docker compose up -d
down:
	docker compose down
install-composer:
	docker compose run --rm php composer install --optimize-autoloader
test:
	docker compose run --rm php vendor/bin/phpunit tests
install: install-composer
phpstan:
	docker compose run --rm php vendor/bin/phpstan analyse src tests
install-database:
	docker compose run --rm php vendor/bin/doctrine-migrations migrate -n
generate-migration:
	docker compose run --rm php vendor/bin/doctrine-migrations generate


