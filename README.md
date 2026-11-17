# Mini-Projet Deefy

**Auteur :** CHARLES Samuel  
**Ressource :** Développement Web S3 — BUT Informatique S3 (IUT Nancy-Charlemagne)

---

## Tableau de bord des fonctionnalités

| N° | Fonctionnalité | Statut | Autorisation appliquée | Détails / Action |
|---|---|---|---|---|
| 1 | **Mes playlists** | Réalisée | Utilisateur authentifié | `?action=mes-playlists` : affiche la liste des playlists appartenant à l'utilisateur connecté (ou toutes pour l'admin). |
| 2 | **Afficher une playlist cliquable** | Réalisée | Utilisateur authentifié propriétaire de la playlist (ou admin) | `?action=display-playlist&id=...` : affiche la playlist et la stocke en session (`$_SESSION['playlist']`) comme playlist courante. |
| 3 | **Ajouter une piste** | Réalisée | Utilisateur authentifié propriétaire de la playlist | `?action=add-track` (accessible depuis l'affichage d'une playlist) : formulaire d'ajout avec upload de fichier `.mp3`, stockage en BD et ajout à la playlist courante. |
| 4 | **Créer une playlist vide** | Réalisée | Utilisateur authentifié | `?action=add-playlist` : crée une playlist en BD, l'associe à l'utilisateur dans `user2playlist` et la définit comme playlist courante en session. |
| 5 | **Afficher la playlist courante** | Réalisée | Utilisateur authentifié propriétaire de la playlist | `?action=playlist` : affiche la playlist actuellement stockée en session. |
| 6 | **S'inscrire** | Réalisée | Public | `?action=add-user` : validation de l'email, double saisie du mot de passe (longueur minimale 10 caractères), hash bcrypt (`cost = 12`) et création avec le rôle `1` (`STANDARD`). |
| 7 | **S'authentifier** | Réalisée | Public | `?action=signin` : vérification des identifiants via `password_verify()` et stockage de l'utilisateur en session. |

### Compléments techniques et sécurité
- **Mots de passe :** hachage avec `password_hash(..., PASSWORD_DEFAULT, ['cost' => 12])` et vérification via `password_verify()`.
- **Injections SQL :** toutes les requêtes passent par PDO avec des requêtes préparées (`DeefyRepository`).
- **Failles XSS :** filtrage des entrées (`filter_var`) et échappement HTML (`htmlspecialchars`) lors de l'affichage.
- **HTML :** structure HTML5 valide générée par le `Dispatcher` et les `Renderer`.

---

## Comptes de test

Les utilisateurs pré-remplis par le script SQL sont les suivants :

| Email | Mot de passe | Rôle | Playlists possédées |
|---|---|---|---|
| `user1@mail.com` | `user1` | Standard (`1`) | `1` (*Best of Slaughter to Prevail*), `2` (*Best of Falling In Reverse*) |
| `user2@mail.com` | `user2` | Standard (`1`) | `3` (*Best of Slipknot*), `5` (*Best of David*) |
| `user3@mail.com` | `user3` | Standard (`1`) | `4` (*Best of System Of A Down*), `6` (*Best of Gojira*), `7` (*Best of Lorna Shore*) |
| `user4@mail.com` | `user4` | Standard (`1`) | Aucune |
| `admin@mail.com` | `admin` | Admin (`100`) | Accès à toutes les playlists |

---

## Installation et configuration

### 1. Base de données
Le script de création et de remplissage de la base de données se trouve dans [deefy/sql/deefy_db.sql](deefy/sql/deefy_db.sql) (adapté avec les colonnes `nom_liste` dans `playlist` et `date_podcast` dans `track`).

Importer ce script dans une base MySQL/MariaDB nommée `deefy` :
```bash
mysql -u <utilisateur> -p deefy < deefy/sql/deefy_db.sql
```

### 2. Fichier de configuration BD
Le fichier de configuration n'est pas versionné (ignoré par `.gitignore`). Créer le fichier `deefy/Config.db.ini` avec vos paramètres de connexion :
```ini
dsn = "mysql:host=localhost;dbname=deefy;charset=utf8"
username = "root"
password = ""
```

### 3. Autoloader Composer
Dans le répertoire `deefy/`, installer/générer l'autoloader PSR-4 :
```bash
cd deefy
composer install
```

### 4. Lancement
Le point d'entrée de l'application est [deefy/index.php](deefy/index.php).

