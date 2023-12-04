
#videos
 # https://www.youtube.com/watch?v=2exXt7XLPBQ
 # https://www.youtube.com/watch?v=0SS6bJczlgs

 
https://dev.to/aschmelyun/the-beauty-of-docker-for-local-laravel-development-13c0

https://laraveldocker.com/

https://www.cloudsigma.com/deploying-laravel-nginx-and-mysql-with-docker-compose/

# github repos

# https://github.com/aschmelyun/docker-compose-laravel/tree/main
# https://github.com/parisnakitakejser/video-tutorial-docker/tree/master/docker-application-setup/setup-laravel-project-with-nginx-and-mariadb
# https://github.com/parisnakitakejser/video-tutorial-docker/tree/master/docker-application-setup




docker-compose up -d --build

docker-compose run --rm composer update
docker-compose run --rm compose install --ignore-platform-req=ext-gd -ignore-platform-req=ext-gd

# after running showing this to be inserted

chmod -R 755 bootstrap/cache
php artisan cache:clear


docker-compose run --rm npm install
docker-compose run --rm npm install -g npm@8.6.0

docker-compose run --rm npm run dev
docker-compose run --rm artisan migrate
docker-compose run --rm artisan migrate:fresh --seed
docker-compose exec php php /var/www/html/artisan migrate --seed


 composer:
    image: composer:latest
    container_name: composer
    volumes:
      - ./src:/var/www/html
    working_dir:  /var/www/html
    networks:
     - laravel

  npm:
    image: node:13.7
    container_name: npm
    volumes:
      - ./src:/var/www/html
    working_dir: /var/www/html
    entrypoint: ['npm']
    networks:
     - laravel

 
