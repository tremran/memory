# Jeu de Mémoire

## Pré-requis

* PHP 7
* composer
* MySQL


## Comment jouer en 9 étapes

1. Cloner le dossier
```
git clone https://github.com/tremran/memory.git
```
2. Générer les dépendances
```
cd memory
composer install
```
3. Renommer le fichier src/config/config.example.ini en config.ini et spécifier les informations de BDD
4. Dans mysql créer la base de donnée, par exemple :
```
mysql -uDBUSER -pDBPASSWORD -e"create database memory"
```
5. Depuis la console générer le schéma de la base de données :
```
vendor\bin\doctrine orm:schema-tool:create
```
6. Générer le fichier css
```
php .\bin\generate_css.php
```
7. Lancer le serveur interne de PHP en spécifiant le fichier "front/index.php" comme contrôleur
```
php -S localhost:8001 front/index.php
```
8. Dans un navigateur accéder à http://localhost:8001
9. Have fun !