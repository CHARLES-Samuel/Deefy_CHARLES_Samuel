# Mini-Projet Deefy

**Auteur :** CHARLES Samuel  
**Ressource :** Développement Web S3 — BUT Informatique S3 (IUT Nancy-Charlemagne)

---

## Tableau de bord des fonctionnalités

| N° | Fonctionnalité | Statut | Autorisation appliquée | Détails / Action |
|---|---|---|---|---|
| 1 | **Mes playlists** | Réalisée | Utilisateur authentifié | `?action=mes-playlists` : affiche la liste des playlists appartenant à l'utilisateur connecté (ou toutes les playlists pour l'administrateur). |
| 2 | **Afficher une playlist cliquable** | Réalisée | Utilisateur authentifié propriétaire de la playlist (ou admin) | `?action=display-playlist&id=...` : affiche la playlist sélectionnée, ses pistes avec lecteur audio, et la stocke en session (`$_SESSION['playlist']`) comme playlist courante. |
| 3 | **Ajouter une piste** | Réalisée | Utilisateur authentifié propriétaire de la playlist | `?action=add-track` (accessible depuis l'affichage d'une playlist) : formulaire d'ajout avec upload sécurisé de fichier `.mp3` (`audio/mpeg`), stockage dans `deefy/assets/audio/`, enregistrement en BD et ajout à la playlist courante. |
| 4 | **Créer une playlist vide** | Réalisée | Utilisateur authentifié | `?action=add-playlist` : crée une playlist en BD, l'associe à l'utilisateur dans `user2playlist` et la définit comme playlist courante en session. |
| 5 | **Afficher la playlist courante** | Réalisée | Utilisateur authentifié propriétaire de la playlist | `?action=playlist` : affiche la playlist actuellement stockée en session. |
| 6 | **S'inscrire** | Réalisée | Public (non connecté) | `?action=add-user` : validation de l'email, double saisie du mot de passe (longueur minimale 10 caractères), hash bcrypt (`cost = 12`) et création avec le rôle `1` (`STANDARD`). |
| 7 | **S'authentifier** | Réalisée | Public (non connecté) | `?action=signin` : vérification des identifiants via `password_verify()` et stockage de l'utilisateur en session. |
| 8 | **Se déconnecter** *(Bonus)* | Réalisée | Utilisateur authentifié | `?action=signout` : suppression des variables de session (`user`, `playlist`), destruction de la session et adaptation dynamique du menu (affichage de *Déconnexion* uniquement si connecté, et de *Connexion / Inscription* uniquement si déconnecté). |

---

## Compléments techniques, Sécurité et Design

- **Sécurité des mots de passe :** hachage avec `password_hash(..., PASSWORD_DEFAULT, ['cost' => 12])` et vérification via `password_verify()`.
- **Parade contre les injections SQL :** toutes les requêtes SQL passent par PDO avec des requêtes préparées (`DeefyRepository`).
- **Parade contre les failles XSS :** filtrage des entrées utilisateur (`filter_var`) et échappement HTML systématique (`htmlspecialchars`) lors du rendu.
- **Validité HTML & Mise en page :**
  - Structure HTML5 valide générée par le `Dispatcher` et les `Renderer`.
  - Utilisation du framework **Bootstrap 5.3** combiné à une feuille de style personnalisée ([deefy/assets/css/style.css](deefy/assets/css/style.css)) et des illustrations dédiées ([deefy/assets/img/](deefy/assets/img/)) sur un thème sombre *Metal / Hardcore*.

---

## Données et Comptes de test

### 1. Utilisateurs pré-enregistrés
Les comptes suivants sont créés par le script SQL (et rappelés sur la page d'accueil pour faciliter les tests) :

| Email | Mot de passe | Rôle | Playlists possédées |
|---|---|---|---|
| `user1@mail.com` | `user1` | Standard (`1`) | `1` (*Best of Slaughter to Prevail*), `2` (*Best of Falling In Reverse*) |
| `user2@mail.com` | `user2` | Standard (`1`) | `3` (*Best of Slipknot*), `5` (*Best of David*) |
| `user3@mail.com` | `user3` | Standard (`1`) | `4` (*Best of System Of A Down*), `6` (*Best of Gojira*), `7` (*Best of Lorna Shore*) |
| `user4@mail.com` | `user4` | Standard (`1`) | Aucune (permet de tester un compte sans playlist) |
| `admin@mail.com` | `admin` | Admin (`100`) | Accès à toutes les playlists (`1` à `7`) |

### 2. Fichiers audio de test inclus
Trois fichiers `.mp3` de test sont versionnés dans [deefy/assets/audio/](deefy/assets/audio/) (`demolisher.mp3`, `ronald.mp3`, `joseph.mp3`) et associés aux 19 pistes de la base de données afin que tous les lecteurs `<audio>` soient directement fonctionnels lors du test des playlists.

---

## Installation et Configuration

### 1. Base de données
Le script de création et de remplissage de la base de données se trouve dans [deefy/sql/deefy_db.sql](deefy/sql/deefy_db.sql) (schéma avec les colonnes `nom_liste` dans `playlist` et `date_podcast` dans `track`).

Importer ce script dans votre base MySQL/MariaDB :
```bash
mysql -u <utilisateur> -p <nom_base> < deefy/sql/deefy_db.sql
```

### 2. Fichier de configuration BD (`Config.db.ini`)
Le fichier de configuration n'est pas partagé sur Git (ignoré via `.gitignore`). Créer le fichier `deefy/Config.db.ini` avec vos paramètres de connexion :
```ini
dsn = "mysql:host=localhost;dbname=deefy;charset=utf8"
username = "root"
password = ""
```

### 3. Autoloader Composer
Dans le répertoire `deefy/`, générer l'autoloader PSR-4 (`iutnc\deefy\` → `src/classes`) :
```bash
cd deefy
composer install
```

### 4. Lancement de l'application
Le point d'entrée de l'application est [deefy/index.php](deefy/index.php).
