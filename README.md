
### Description of folders structure
* docker: config files to run docker
* features: specification for behat tests
* src/Controller: entry points to the application
* src/DTO: DTO used to validate request
* src/Entity: Entity record
* src/Repository: Repository record
* src/EventSubscribers:
 * ExceptionSubscriber: Handle errors
 * RequestSubscriber: Handle authentication and request

### How to run
Run container:
* docker-compose build
* docker-compose up

Install dependecies:
* docker exec -it challenge_oetker_php_1 composer install

Run migrations
* docker exec -it challenge_oetker_php_1 bin/console doctrine:migrations:migrate

Run tests
* docker exec -it challenge_oetker_php_1 vendor/bin/behat

Open swagger (api-key: 12345):
* http://localhost:8888/api/doc

### Improvements:
* Test can be improved by asserting changes on the DB
* Authentication can be improved using symfony component for authentication
