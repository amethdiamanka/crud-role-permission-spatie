# Package Ameth Diamanka

Gestion avancée des rôles et permissions pour Laravel aprés l'installation et la configuration de "spatie/laravel-permissions".

## Descrition

Apres l'installation et la configuration du package "spatie/laravel-permission".
Vous pouvez aller sur : 
-  /diamanka/permissions/create (pour la création des permissions)
-  /diamanka/permissions (pour voir la liste des permissions)
-  /diamanka/roles/create (pour la création des roles)
-  /diamanka/roles (pour voir la liste des roles)


## Installation
```bash
composer require ameth/diamanka

```
## Publication service provider
```bash
php artisan vendor:publish --provider="Ameth\\Diamanka\\Providers\\DiamankaServiceProvider"

```
## Publication views
```bash
php artisan vendor:publish --tag="views"


