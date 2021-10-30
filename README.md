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

| method | function | endpoint | Bearer key | params 
| ----- | ------ | ------ | ------ | ----- |
| POST | login | localhost/kerb-test/public/api/login | No | username:admin, password:123456
| GET | Check Availability | localhost/kerb-test/public/api/check_available | YES | 
| POST | Booking | localhost/kerb-test/public/api/book | YES | customer_id : 1, bay_id : 1-3, owner_id : 1
| GET | Calculate Price | localhost/kerb-test/public/api/calculate_price | YES | book_id
| POST | Pay | localhost/kerb-test/public/api/payment | YES | book_id

