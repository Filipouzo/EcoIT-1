# Projet EcoIT

## Description
Projet d'une plateforme consacrée à la formation sur l'éco-conception

Les documents annexes sont disponibles dans le dossier ANNEXES :
- Charte graphique
- Manuel d'utilisation
- Documentation technique

## Récupération du projet

Utiliser GIT Clone pour récupérer le dépôt
```bash
git init
```
```bash
git clone git@github.com:Foreach-Code/EcoIT.git
```

## Installation

```bash
# Installation des dépendances
composer install
# Création de la base de données
php bin/console doctrine:database:create
# Création des tables (migrations)
php bin/console doctrine:migrations:migrate
```


## Utilisation
Deux options pour lancer le serveur de développement PHP :
- Si vous avez installé **Symfony** :
```bash
symfony serve
```
- Si vous utilisez **Composer**, il faut installer le **Web Server Bundle** :
```bash
composer require symfony/web-server-bundle --dev
php bin/console server:start
```

## Copies
Certains documents demandés sont aussi accessibles sur Google
[Drive](https://drive.google.com/drive/folders/1i8P5LOoqdVB7uCjHzryvk7MjH6sr-KBq)