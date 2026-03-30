# 🏟️ PlayReserve - Plateforme de Réservation de Terrains Sportifs

## 📝 Description
PlayReserve est une plateforme web permettant la réservation en ligne de terrains sportifs. Les utilisateurs peuvent réserver des terrains, les propriétaires de clubs peuvent gérer leurs installations, et un administrateur supervise l'ensemble de la plateforme.

## 👥 Rôles Utilisateurs
- **Admin** : Gère toute la plateforme (clubs, utilisateurs, réservations)
- **Owner** : Propriétaire d'un club, gère ses terrains et réservations
- **Membre** : Utilisateur qui réserve des terrains

---

## 🛠️ Prérequis

Avant de commencer, assurez-vous d'avoir installé:

- **PHP** >= 8.1
- **Composer** (Gestionnaire de dépendances PHP)
- **SQLite** ou **MySQL** (Base de données)
- **Node.js** et **NPM** (Optionnel pour les assets)

---

## 📦 Installation Complète

### Étape 1: Créer le projet Laravel

```bash
# Créer un nouveau projet Laravel
composer create-project laravel/laravel playreserve

# Entrer dans le dossier
cd playreserve