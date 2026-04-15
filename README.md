# PlayReserve - Plateforme de Reservation de Terrains Sportifs

## Description
PlayReserve est une plateforme web pour reserver des terrains de sport en ligne. Les utilisateurs peuvent reserver des terrains, les proprietaires de clubs peuvent gerer leurs terrains, et il y a un administrateur pour gerer le tout.
   
## Roles Utilisateurs
- Admin : Gere toute la plateforme.
- Owner : Proprietaire d'un club, gere ses terrains.
- Membre : Utilisateur qui fait les reservations.

## Installation

Pour lancer le projet :

1. Cloner le projet.
2. Installer les dependances avec `composer install` et `npm install`.
3. Creer le fichier `.env` et generer la cle avec `php artisan key:generate`.
4. Configurer la base de donnes.
5. Lancer les migrations avec `php artisan migrate --seed`.
6. Lancer le serveur avec `php artisan serve`.

## Technologies utilisees
- Laravel
- Tailwind CSS
- MySQL / SQLite
- Stripe (pour le paiement)