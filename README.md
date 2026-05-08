# DevTrack 🚀
### Lightweight Jira Alternative for Startups

DevTrack est une application web développée avec Laravel permettant la gestion de projets et de tâches pour les équipes de développement.

L’objectif principal de la plateforme est d’aider les startups à organiser efficacement leur travail, centraliser la communication, suivre l’avancement des projets et améliorer la collaboration entre les membres de l’équipe.

---

# 📌 Contexte du Projet

Une startup installée à Technopark Agadir vient de recruter plusieurs développeurs juniors.

Le Team Lead utilisait différents outils non centralisés comme :
- WhatsApp
- Excel
- Notes personnelles

pour suivre les projets et les tâches.

Cette méthode créait plusieurs problèmes :
- manque d’organisation,
- mauvaise visibilité sur les tâches,
- communication inefficace,
- difficulté de suivi de l’avancement.

La startup nous a alors contactés pour développer **DevTrack**, une plateforme interne simple et efficace permettant :
- la gestion des projets,
- l’attribution des tâches,
- le suivi en temps réel,
- la collaboration entre le Team Lead et les développeurs.

---

# 🎯 Objectifs du Projet

- Centraliser la gestion des projets et tâches
- Faciliter la collaboration d’équipe
- Suivre l’avancement des projets en temps réel
- Sécuriser l’application avec Laravel Policies
- Valider les données avec Form Requests
- Fournir une API REST simple pour les tâches

---

# 👥 Types d’Utilisateurs

## 👨‍💼 Team Lead
Le Team Lead peut :
- créer des projets,
- modifier les projets,
- archiver/restaurer les projets,
- ajouter ou retirer des développeurs,
- créer et gérer les tâches,
- suivre l’avancement des projets.

## 👨‍💻 Developer
Le développeur peut :
- voir uniquement les projets auxquels il participe,
- consulter ses tâches,
- modifier uniquement le statut de ses propres tâches.

---

# ✨ Fonctionnalités Principales

# 🔐 Authentification

- Inscription
- Connexion
- Déconnexion
- Protection des routes avec middleware auth

---

# 📁 Gestion des Projets

- Création de projets
- Modification des projets
- Archivage des projets
- Restauration des projets archivés
- Dashboard des projets
- Gestion des membres

Chaque projet contient :
- un titre,
- une description,
- une deadline,
- des membres,
- des tâches.

---

# ✅ Gestion des Tâches

- Création de tâches
- Attribution à un développeur
- Modification des tâches
- Suppression des tâches
- Gestion des priorités :
  - Low
  - Medium
  - High

- Gestion des statuts :
  - Todo
  - In Progress
  - Done

- Affichage d’un indicateur d’urgence basé sur la deadline

---

# 🔒 Sécurité

Le projet utilise plusieurs mécanismes de sécurité Laravel :

## Policies
Gestion des autorisations :
- seul le lead peut gérer les projets,
- seul le développeur assigné peut modifier le statut de sa tâche.

## Form Requests
Validation centralisée des données :
- validation des formulaires,
- sécurisation des entrées utilisateur.

## Middleware
- authentification obligatoire,
- protection des routes.

---

# 🔌 API REST

DevTrack expose un endpoint API permettant de récupérer les tâches d’un projet.

## Endpoint

```bash
GET /api/projects/{project}/tasks