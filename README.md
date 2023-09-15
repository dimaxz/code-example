для миграции редактируем схему ./bootstrap/db/schema.xml
в контейнере 
$ docker-compose exec php-fpm bash
$ export `cat .env`
# обновляем модели php
$ ./vendor/bin/propel model:build

# создаем миграции
$ ./vendor/bin/propel migration:diff

# применяем миграции
$ ./vendor/bin/propel migration:up