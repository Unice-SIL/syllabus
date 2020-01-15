# Syllabus

## v1.0
Version initiale de l'application Syllabus.

### Installation de l'application

1. Lancer la commande composer install pour installer les vendors.
2. Lancer la commande php bin/console doctrine:database:create pour créer la base de données
3. Lancer la commande php bin/console doctrine:schema:update --force pour créer les tables en base de données
4. Lancer la commande php bin/console doctrine:fixtures:load pour charger un jeu de données en base de données