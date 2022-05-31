# palais-des-plaisirs

blog culinaires avec gestion utilisateur et articles
Possibiliter de rédiger un article pour l'autheur et de poster des commentaires pour les utilisateurs

## Installation

création de la base de données et ajouter les tables 
> php bin/console doctrine:database:create
> php bin/console doctrine:migration:migrate
> php bin/console doctrine:fixture:load

Ajouter les types de form (changer FileType par le type désiré)
> php bin/console debug:form FileType

pour charger le css
> npm run build

lancement du projet 
> php -S localhost:8000 -t ./public/


## contributeurs

Valentin AGUERA et Marie-Laure SARTORI BOUTY
