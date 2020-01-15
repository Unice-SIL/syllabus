# Syllabus

## v1.0
Version initiale de l'application Syllabus.

### Installation de l'application

#### 1. Si vous avez le logiciel "make" installé sur votre machine
 
Placez-vous à la racine du projet et lancez la commande: 
                
    make install
 
#### 2. Si vous n'avez pas le logiciel "make" installé sur votre machine.

Placez vous à la racine du projet et lancez  manuellement les commandes sous la clé `install` dans le fichier Makefile (qui se trouve également à la racine du projet)

e.g. (path: projectDirectory/Makefile)
    
    ...
    
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
    	
Dans cet exemple, lancez les commandes suivantes:
1. `composer install`
2. `php bin/console doctrine:database:create`
3. `php bin/console doctrine:migrations:migrate --no-interaction`
4. `php bin/console doctrine:fixtures:load --no-interaction --append`

La commande `make build` fait appel à un nouveau block de commande qui sont les commandes 2, 3 et 4 indiquées juste au dessus.