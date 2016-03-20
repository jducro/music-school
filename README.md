Music school
============


API
---

### Setup :

#### Dependencies installation
  
    composer install
    
#### Database

Define database connexion in app/config/parameters.yml

Database creation

    bin/console doctrine:database:create

Schema update

    bin/console doctrine:schema:update --force
    
Data Fixtures creation

    bin/console doctrine:fixtures:load
    
#### Documentation 
API doc is available at [/api/doc](http://julien.ducro.fr/music-school/web/api/doc)


[Frontend](http://julien.ducro.fr/music-school/web/index.html)
--------

### Mise en place :

#### Installation des dépendances

    bower install
    
