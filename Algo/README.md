# ALGO

FizzBuzz CLI

---

## Utilisation

```bash
php bin/fizzbuzz.php <début> <fin>
```

### Exemples :

```bash
php bin/fizzbuzz.php 1 100
php bin/fizzbuzz.php 10 30
```

---

## Conditions

- Les deux arguments doivent être des entiers positifs.
- Le début doit être inférieur ou égal à la fin.
- La plage maximale autorisée est de 5 000.

---

## Sécurité

- Empêche l'exécution de commandes avec une plage trop large
- Affiche des messages en cas d’erreur