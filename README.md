
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

### Description implementation
* As this application is an API and it has not business logic. I decided to do most of the logic on the controller to avoid an extra application layer. The controller gets a request and validates the input data. Then persist this action using the entity and repository.
* It was added the authentication in the RequestSubscriber for simplicity as this is called before every request. In a proper solution Authentication component could be used instead.
* The exception subscriber will handle errors and covert exceptions in proper JSON errors.
* Two different data objets are used. The DTO to validate the request and the Entity to store and retrieve from the database.
* Some functionalities from the ORM are wrapped on the repository and an interface has been created.

### How to run
Run container:
* docker-compose build
* docker-compose up

Install dependencies:
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
