# Backend

Gestion de flotte de véhicules

---

## Installation

```bash
composer install
```
---

## Commandes CLI

```bash
./fleet create <userId> # returns fleetId on the standard output
./fleet register-vehicle <fleetId> <vehiclePlateNumber>
./fleet localize-vehicle <fleetId> <vehiclePlateNumber> lat lng [alt]

```
---

## Persistance des données

Les données sont stockées dans une base SQLite 
 - `database.sqlite`
 - `database_test.sqlite` (pour les tests).
---

## Visualisation des données

Il est possible de visualiser la donnée rapidement pour vérifier le contenu:
- Avec un IDE comme PhpStorm, via l'onglet `Database` vous pourrez parcourir les données 
- Via le terminal si vous avez `sqlite3` installé : 

  ```bash
  #Charger la base de données
  sqlite3 database.sqlite
  ```

  ```sql
  .tables -- Liste les tables
  SELECT * FROM fleets; -- Affiche les données de la table 'fleets'  
  .exit -- Quitte SQLite        
  ```

## Tests

### Lancer les tests localement

```bash
vendor/behat/behat/bin/behat
```

### Test indépendants


- #### Enregistrer un vehicule
```bash
vendor/behat/behat/bin/behat --suite=park_suite
```
- #### Localiser un vehicule
```bash
vendor/behat/behat/bin/behat --suite=park_suite
```

### Exécuter les tests avec le profil CI

```bash
vendor/behat/behat/bin/behat --profile=ci
```

Génère un rapport `JUnit` dans `build/logs/behat-junit.xml`

---

## Étapes de la CI

Lancement des workflows automatiques à chaque push sur la branche main.

- Récupération du dernier code source
- Installation de PHP
- Installation de composer
- Lancement des tests Behat avec le profil CI
- Téléchargement du rapport de tests JUnit
