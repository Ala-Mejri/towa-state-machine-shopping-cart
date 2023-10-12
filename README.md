# Towa state machine shopping cart

## I. Environment
- php: 8.1
- symfony: 6.3
- database: sqlite
- OS: windows 10


## II. Setup
### 1. Dependencies installation
- composer install

### 2. Assets setup
- npm install
- npm run dev

### 3. Database steup
- symfony console make:migration
- symfony console doctrine:migrations:migrate
- symfony console doctrine:fixtures:load

### 4. Starting the server
- symfony server:start
- Visit http://localhost:8000

### 5. Delete expired carts
- symfony console app:remove-expired-carts


## III. Testing
### 1. Database steup
- symfony console doctrine:database:create -e test
- symfony console doctrine:migrations:migrate -e test
- symfony console doctrine:fixtures:load -e test

### 2. Running the tests
- php bin/phpunit


## IV. Login credentials
### Admin credentials
- Email: admin@towa.de 
- Password: 123456

### User credentials
- Email: user@towa.de
- Password: 123456


## Possible future Improvements
-	Using DTOs for requests and responses.
- Using DDD architecture.
-	Using JavaScript modules.
-	Using Docker.
-	Adding more unit, integration and functional tests to cover the totality of the code.

## Choices
-	I did not use Docker as I built the project using personal equipment (windows).
-	I already tested the project with mariaDB, but I decided to switch to sqlite before pushing the project to reduce env issues (since I did not use Docker).​

Looking forward to your feedback :)

