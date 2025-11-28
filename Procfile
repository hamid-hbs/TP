#✅ 1. Démarrer les conteneurs

# Si tu utilises docker-compose.yml, la commande est :

# docker compose up -d


# up → démarre les services

# -d → mode détaché (en arrière-plan)

# ✅ 2. Voir les conteneurs qui tournent
# docker ps

# ✅ 3. Voir les logs d’un conteneur
# docker logs nom_du_conteneur


# Exemple :

# docker logs app
# docker logs nginx
# docker logs mysql

# ✅ 4. Accéder au conteneur Laravel (php-fpm)
# docker exec -it app bash


# Ensuite tu peux faire :

# php artisan migrate
# php artisan cache:clear
# composer install

# ✅ 5. Accéder au conteneur MySQL
# docker exec -it mysql bash


# Puis :

# mysql -u root -p

# ✅ 6. Arrêter les conteneurs
# docker compose down

# ✅ 7. Rebuild (si tu modifies Dockerfile)
# docker compose build --no-cache
# docker compose up -d

# ✅ 8. Supprimer tout (dangereux)
# docker system prune -a


# ⚠️ Cela supprime toutes les images et conteneurs non utilisés.
