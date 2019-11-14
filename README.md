# invillia-php-test
Test project for Invillia company

### TL/DR: Too Long/Didn't Read
  - A little bit lazy? Straight to the point, just follow the recipe, more explanations below.

        docker-compose up -d
        docker-compose exec php sh
        composer install
        bin/console doctrine:schema:create

        # run the tests
        ./bin/phpunit

### Docker (environment)

- The project has a docker-compose.yml file, you just need to run the command bellow and it will create tree containers, Apache, Php, Mysql respectively.
  - docker-compose up -d

- Outside the container the code will be in the 'html' folder, and inside the Apache and Php containers will be in the '/var/www/html' folder

### The Code Dependencies

- To the project to work we need to bring the project dependencies. Access the PHP container and run de composer.
  - docker-compose exec php sh
  - composer install

### Database

- To create the database schema first enter on the PHP container, then run the doctrine create schema command.
  - docker-compose exec php sh
  - bin/console doctrine:schema:create

### Tests
  - To run the tests just enter on the PHP container and execute the command:
      - ./bin/phpunit

### Endpoints
  - /api/people
  - /api/people/{id}
  - /api/shiporders
  - /api/shiporders/{id}
  - /upload

### Instructions
  - Access the upload screen /upload and submit the two files at the sametime, the 'happy way' is working
  - The files are in html/tests/Service/Assets
  - If you run the tests, clean the database before using the upload feature (same data)