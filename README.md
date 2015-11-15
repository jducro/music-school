Music school
============


API
---

### Mise en place :

#### Instalation des dépendances
  
    composer install
    
#### Base de données

Définition de la connexion à la base de données dans app/config/parameters.yml (exemple dans le fichier parameters.yml.dist)

Création de la base de données

    php app/console doctrine:database:create
 
Mise à jour du schéma

    php app/console doctrine:schema:update --force
    
Création du jeu de test

    php app/console doctrine:fixtures:load
    
#### Documentation 
Documentation de l'API accessible à [/api/doc](http://julien.ducro.fr/music-school/web/api/doc)


[Frontend](http://julien.ducro.fr/music-school/web/index.html)
--------

### Mise en place :

#### Installation des dépendances

    bower install
    
    
