# Syllabus


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

####3. Programmer le cron Scheduler (seulement en production)
Ajouter dans le cron du serveur la commande suivante:
`* * * * * php path_to_syllabus\bin\console app:scheduler`

### v2

#### v2.2.5
##### Hotfix
- Select2 teachers form focus issue fixed

#### v2.2.4
##### Hotfix
- Disable csrf protection for general presentation and duplicate course info forms

#### v2.2.3
##### Hotfix
- Teaching hours infos added

#### v2.2.2
##### Hotfix
- Syllabus API filters fixed

#### v2.2.1
##### Hotfix
- Syllabus not published is now invisible to student views

#### v2.2.0
##### Release
- Migration Symfony 4.4
- Rework student view
- Add student light version

#### v2.1.5
##### Release
- Added API filters for Course and CourseInfo

#### v2.1.4
##### Release
- Switched apogee code <--> title
- Prerequisite not mandatory
- Fixed obsolete => false
- Added title on student view
