r.PHONY: help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: ## Install symfony project
	composer install
	build_assets
	make build

reinstall: ## Reinstall symfony project
	composer install
	make build_assets
	make rebuild

rebuild: ## Rebuild database
	php bin/console doctrine:database:drop --force
	make build

build: ## Build database
	php bin/console doctrine:database:create
	php bin/console doctrine:migrations:migrate --no-interaction
	php bin/console doctrine:fixtures:load --no-interaction --append
	php bin/console lexik:translations:import
	php bin/console app:custom-db

build_assets: ## build assets
	yarn install
	yarn encore dev

deploy_db_dev: ## Deploy project for dev environment
	php bin/console doctrine:database:drop --force --env=dev --if-exists --no-interaction
	php bin/console doctrine:database:create --if-not-exists --env=dev --no-interaction
	php bin/console doctrine:migrations:migrate --env=dev --no-interaction
	php bin/console doctrine:fixtures:load --no-interaction --env=dev --append
	php bin/console lexik:translations:import
	php bin/console app:custom-db

deploy_prod: ## Deploy project for prod environment
	composer install --prefer-dist --no-ansi --no-interaction --no-dev
	yarn install
	yarn encore prod
	php bin/console doctrine:database:create --env=prod --if-not-exists --no-interaction
	php bin/console doctrine:migrations:migrate --env=prod --no-interaction
