# Comission Calculator - Code Refactoring
## Code Structure
- files - contains file with input data
- src
    - Command - contains class for calculating commissions that includes file parsing
    - Service - contains classes for getting data from bin list API, currency exchanger API (inc. base class), class with EU countries and commisson calculator class
- app.php - entry point
- tests - Unit tests

## Installation
- Clone the repository.
```bash
git clone https://github.com/vbaldych/calculator-refactor
```
- Access to the directory.
```bash
cd calculator-refactor-master
```

### Using PHP & Composer

**Requirements**
- PHP (version >= 8.2)
- Composer (recommended version 2.7.7)

**Steps**

1. Install application dependencies.
```bash
composer install
```
2. Run the application
```bash
php src/app.php files/input.txt
```
3. Run the test
```bash
vendor/bin/phpunit --testdox
```

### Using Docker

**Requirements**
- Docker
- docker-compose

**Steps**
1. Build the docker container.
```bash
docker-compose up --build -d
```
2. Install application dependencies.
```bash
docker exec calculator-refactor-master-php composer install
```
3. Run the application.
```bash
docker exec calculator-refactor-master-php php src/app.php files/input.txt
```
4. Run the test.
```bash
docker exec calculator-refactor-master-php vendor/bin/phpunit --testdox
```

## Code analyzing
- For analyzing code with Rector use command
```bash
vendor/bin/rector process --dry-run
```