для миграции редактируем схему ./bootstrap/db/schema.xml
в контейнере 
```
$ docker-compose exec php-fpm bash
$ export `cat .env`
```
## обновляем модели php
```
$ ./vendor/bin/propel model:build
```
## создаем миграции
```
$ ./vendor/bin/propel migration:diff
```
## применяем миграции
```
$ ./vendor/bin/propel migration:up
```
## REST по городам
```
GET http://localhost:8080/api/v1/cities
GET http://localhost:8080/api/v1/cities/1
POST http://localhost:8080/api/v1/cities
{
"name":"Москва"
}

PUT http://localhost:8080/api/v1/cities/1
{
"name":"Москва"
}

DELETE http://localhost:8080/api/v1/cities/1
```
### достопримечательности в городе
```
GET http://localhost:8080/api/v1/cities/1/sights
```

### путешественники побывавшие в городе
```
GET http://localhost:8080/api/v1/cities/1/travelers
```


### REST по достопримечательностям
```
GET http://localhost:8080/api/v1/sights
GET http://localhost:8080/api/v1/sights/1
POST http://localhost:8080/api/v1/sights
{
"name":"Эрмитаж"
}

PUT http://localhost:8080/api/v1/sights/1
{
"name":"Эрмитаж"
}

DELETE http://localhost:8080/api/v1/sights/1
```

### REST по путешественникам
```
GET http://localhost:8080/api/v1/travelers
GET http://localhost:8080/api/v1/travelers/1
```

### создаем путешественника и какие посещал города
```
POST http://localhost:8080/api/v1/travelers
{
"name":"Дмитрий",
"cities_visit": [7]
}

PUT http://localhost:8080/api/v1/travelers/1
{
"name":"Дмитрий",
"cities_visit": [7]
}

DELETE http://localhost:8080/api/v1/travelers/1
```

### города, которые посетил путешественник
```
http://localhost:8080/api/v1/travelers/1/cities
```


1. форма создания покупки и числа
2. вывод покупок