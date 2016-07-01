# Simple app for managing notes
The app stores, update and delete notes. The system has 2 components, a RESTful API and a client build in AngularJS.


>  For the API component I used the Dingo Laravel package. The API is public and without authentication.



##Demo

**Client url:**
http://www.e-f.ro/client


**API url:**
http://www.e-f.ro/api

**Swagger url:**
http://www.e-f.ro/swagger-ui

**OpenApi docs url:**
http://www.e-f.ro/api-docs/swagger.json



##Installation


Run `composer install`


Clone `.env.example` to `.env` and make sure your `.env` file has correct database information



##Setup DB

**Install the db script**
> `php artisan migrate`

**If you wan to import the sql by hand, the mysqldump can be found below**
`/notes/database/sql/db.sql`



##API documentation
The OpenAPI swagger json can be found at http://local.domain/api-docs/swagger.json
An instance of swagger-ui can be found at http://local.domain/swagger-ui



##Client

The client was built using AngularJS and can be accessed at the following location: http://local.domain/client

Last step is to setup the API url in the client.

`/notes/public/client/index.html`

Change `var apiEndpoint = "http://notes.app";` to `var apiEndpoint = "http://local.domain";`


##Unit Tests

To run the tests for the API run the below command in the root folder of the project

> `phpunit`

