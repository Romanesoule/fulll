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
# Créer une flotte
php ./fleet create:fleet {userId}

# Enregistrer un véhicule
php ./fleet register:vehicle {fleetId} {plateNumber}

# Localiser un véhicule
php ./fleet park:vehicle {fleetId} {plateNumber} {lat} {lng} {alt}

```
---

## Persistance des données

Les données sont stockées dans une base SQLite 
 - `database.sqlite`
 - `database_test.sqlite` (pour les tests).

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

### Exécuter les tests CI

```bash
vendor/behat/behat/bin/behat --profile=ci
```

Génère un rapport `JUnit` dans `build/logs/behat-junit.xml`