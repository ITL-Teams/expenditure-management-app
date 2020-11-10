# Expenditure Management App API
This API receives requests from a web client and perform backend operations.

## About
API Gateway that provides access to web services, each service is meant to be independent 
following Microservice Architecture and Domain-Driven-Design structure.

### Code and Testing
In Microservice Architecure each service can run in a different programming language, so we created two 
stacks. First stack is nodejs/express application using typescript base code, app code is going to be 
build into javascript code and then copied to a docker image.
The second suit is a LAMP stack, ready to run php application from index.php

Each microservice defines its own testing suit.

## Project status
This project is currently in development.

## Coding guidelines
Files in each microservice, including package structure will follow domain-driven-design structure.

See the following example, basic structure to create your Microservice:
```
-- example (here goes the microservice name)
  -- Dockerfile (if needed)
  -- src
    -- aplication
    -- domain
    -- infraestructure
  -- test
    -- aplication
    -- domain
    -- infraestructure
  -- e2e
```

## Setup
### Requirements
This project has multiple sub-projects within, however, the basics are:
- [Docker] (19.03.13) and [docker-compose] (1.27.4)

Each subproject will have its own dependencies.

### Get Started
**Example.** These are the steps to execute the example stack and its tests:

Node stack:
1. Go to sub-project directory ``cd services/node-example``
2. Install dependencies: ``npm install``

Containers:
1. Go back to main directory
2. Build example images: ``docker-compose -f docker-compose.example.yaml build``
3. Run containers: ``docker-compose -f docker-compose.example.yaml up``
4. Wait about a minute, mysql container needs some time to start working properly.
You can do this to ensure it is working:
* This will list containers id's: ``docker ps``
* Go to mysql container bash, use its id: ``docker exec -it [container-id] bash``
* Run this command to check if service is ready: ``mysql --password=root``

Run Node stack tests
1. Execute tests: ``npm test``
2. Execute e2e tests: ``npm run e2e``

### Adding new components
If you want to add some code or use case, you should follow this order:
1. Create/update domain components.
   1. Value Objects
   2. Entities
   3. Unit/Integration Tests
2. Create/update domain interface.
   1. Interface Repository in domain layer
   2. Update Repository implementation (Do this if the interface already exists and was updated, this prevent breaking existing tests)
3. Create/update application components.
   1. Application Component (like UserCreator, UserFinder, etc...), this is the use case you want to code
   2. Unit/Integration Tests
4. Create/update infraestructure components.
   * This may vary for each microservice
5. Create/update e2e test
   * This may vary for each microservice

## Contributions
This is a school project, therefore, the project is not ACCEPTING CODE CONTRIBUTIONS (pull requests, or else).

[docker]: https://www.docker.com/
[docker-compose]: https://docs.docker.com/compose/
