This is a cookie-cutter, limited booking API. 

To start off:
```sh
docker compose build
docker compose up -d
```

In the _php container:
```sh
composer install
php bin/console doctrine:schema:create
php bin/console doctrine:database:create
php bin/console doctrine:fixtures:load
```

Available endpoints:
```sh
GET: /v1/reservations - returning list of reservations
GET: /v1/reservations/{reservationId} - returning data concerning reservation
GET: /v1/reservations/holders - returning list of all reservation holders
POST: /v1/reservations - creates reservation
POST: /v1/reservations/{reservationId} - updates reservation
DELETE: /v1/reservations/{reservationId} - deletes reservation
```
Postman Collection available in the root folder. 