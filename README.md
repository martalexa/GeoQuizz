# Geoquizz Backend

Application réalisée dans le cadre de l'atelier 2, LP CISIIE


## Réalisée Par

- Alexandra MARTIN
- Mohamed ALHASNE
- Nicolas BOBELET
- Yann Dumas
- Daniel RICKLIN

## Pré-requis

- PHP 7 +
- Apache
- docker-compose
- composer

## Installation

- Ajouter les hosts virtuels `api.geoquizz.local - web.geoquizz.local - migrate.geoquizz.local - db.geoquizz.local - admin.geoquizz.local - player.geoquizz.local - bo.geoquizz.local`
- Installer les dépendances du projet `$ composer update`
- Créer le schéma de la base de données en exécutant le lien `http://migrate.geoquizz.local:10083/migrate.php`
- Aller sur l'interface sur le lien `http://admin.geoquizz.local:8082`
- Se connecter avec `host=geoquizz, username=admin, password:admin` et selectionner la base de données `geoquizz`
- Importer les villes et la série par défaut en important le fichier `./data/data.sql`
- Acceder au jeu sur le lien `http://player.geoquizz.local:10090`
- Acceder au backoffice de gestion sur le lien `http://bo.geoquizz.local:10091`
