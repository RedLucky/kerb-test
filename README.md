# Kerb test parking
## installation
1. copy `.env.development` to `.env`
2. setup the database on `.env` :
```
DB_CONNECTION=pgsql
DB_HOST=(YOUR_HOST_DB)
DB_PORT=(YOUR_PORT_DB)
DB_DATABASE=(YOUR_DB)
DB_USERNAME=(YOUR_DB_USERNAME)
DB_PASSWORD=(YOUR_DB_PASSWORD)
```
3. install and migrate the db with the folowing command : 
```
composer install
php artisan migrate --seed 
```
## List Endpoint

| method | function | endpoint | Bearer key
| ----- | ------ | ------ | ------ |
| POST | login | localhost/kerb-test/public/api/login | No
| GET | Check Availability | localhost/kerb-test/public/api/check_available | YES
| POST | Booking | localhost/kerb-test/public/api/book | YES
| GET | Calculate Price | localhost/kerb-test/public/api/calculate_price | YES
| POST | Pay | localhost/kerb-test/public/api/payment | YES

