r.PHONY: help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: ## Install symfony project
	composer install
	make build

rebuild: ## Rebuild database
	php bin/console doctrine:database:drop --force
	make build

build: ## Build database
	php bin/console doctrine:database:create
	php bin/console doctrine:migrations:migrate --no-interaction
	php bin/console doctrine:fixtures:load --no-interaction --append
	php bin/console app:custom-db