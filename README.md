# Laravel - Exercise 1 - Simple CRUD on REST


## Summary

{summary}

Expected result of this task is an application which allows user to create/read/update/delete row in the table using REST requests.

Sample book structure:
```
[
    'id' => 1,
    'title' => 'Patterns of Enterprise Application Architecture',
    'author' => 'Martin Fowler',
    'price' => '15.96'
]
```


## Goals

In order to complete this exercise you will need to follow these steps:

1. Create `Book` model in `app/Book.php` with proper `namespace`.

2. Create migration to create table `books` with columns listed below:

  * id - primary key, autoincrement
  * title - type: `string`, length: 128, assertions before persisting data from controller:
    * not blank
    * min length = 3
    * max length = 128
  * author - type: `string`, length: 128, assertions before persisting data from controller: 
    * not blank
    * min length = 3
    * max length = 128
  * price - type: `float`, assertions before persisting data from controller: 
    * numeric
    * min value: 0
  
2. Create endpoint to retrieve list of books
  * should be accessed via GET "/api/book"
  * should return array of books as JSON
  
3. Create endpoint to create new book
  * should be accessed via POST "/api/book"
  * should validate if payload is valid
  * if payload is invalid it should return JSON with error messages per each property with **HTTP_UNPROCESSABLE_ENTITY** status code eg:
  ```
  {
    "author": "The author must be between 3 and 128 characters."
  }
  ```
  * if payload is valid it should store `Book` data and return JSON response data of newly created `Book`, eg.:
  ```
  {
    "id": 1,
    "title": "Test Driven Development: By Example",
    "author": "Kent Beck",
    "price": "39.51",
    "created_at": "2016-11-07 19:26:55",
    "updated_at": "2016-11-07 19:26:55"
  }
  ```
  
4. Create endpoint to update existing book
  * should be accessed via PUT "/api/book/{bookId}"
  * should validate if payload is valid
  * should assign title, author from request to `Book` object
  * if `Book` with given `bookId` not exist it should return **NOT_FOUND** status code
  * if payload is invalid it should return JSON with error messages per each property with **HTTP_UNPROCESSABLE_ENTITY** status code eg:
  ```
  {
    "author": "The author must be between 3 and 128 characters."
  }
  ```
  * if payload is valid it should store `Book` data and return JSON response data of newly created `Book`, eg.:
  ```
  {
    "id": 1,
    "title": "Test Driven Development: By Example",
    "author": "Kent Beck",
    "price": "39.51",
    "created_at": "2016-11-07 19:26:55",
    "updated_at": "2016-11-07 19:26:55"
  }
  ```

5. Create endpoint to delete existing book
  * should be accessed via DELETE "/api/book/{bookId}"
  * if `Book` with given `bookId` not exist it should **NOT_FOUND** status code
  * if `Book` with given `bookId` exist it should delete it and return **HTTP_ACCEPTED** status code

Expected result of `php composer test-dox` for completed exercise is listed below:
```
CreateBook
 [x] Should not save book with empty payload
 [x] Should not save book with empty title
 [x] Should not save book with empty author
 [x] Should not save book with empty price
 [x] Should not save book with too short title
 [x] Should not save book with too long title
 [x] Should not save book with too short author
 [x] Should not save book with too long author
 [x] Should not save book with negative price
 [x] Should not save book with invalid string price
 [x] Should save book with proper payload and return its data


DeleteBook
 [x] Should return 404 status code if book not exists
 [x] Should return certain book data if book exists

RetrieveBook
 [x] Should return 404 status code if book not exists
 [x] Should return certain book data if book exists

RetrieveBooks
 [x] Should return books data

UpdateBook
 [x] Should save book with proper payload and return its data
 [x] Should not save book with empty payload
 [x] Should not save book with empty title
 [x] Should not save book with empty author
 [x] Should not save book with empty price
 [x] Should not save book with too short title
 [x] Should not save book with too long title
 [x] Should not save book with too short author
 [x] Should not save book with too long author
 [x] Should not save book with negative price
 [x] Should not save book with invalid string price
```


## Hints

Most of changes should lay in `app` dir. You can also modify files in `database/migrations`, `routes` and `resources`.

If You want to see what goals You have passed You should run: `php composer test-dox`. Each scenario with **[x]** has passed and those with **[ ]** has to be done.

More info about errors during tests You can get running tests with command: `php composer test`

This task is concerned as done when all tests are passing and when code-sniffer and mess-detector do not return errors nor warnings (ignore info about "Remaining deprecation notices" during test).

Remember to commit changes before You change branch.

Remember to install dependencies if You change branch.

### Helpful links

Please remember to read documentation for Laravel 5.3 because it can differ in newer/older versions.

* [Laravel documentation](https://laravel.com/docs/5.3)

## Requirements

 * You must have installed **PHP 5** with **pdo_mysql** and **json** extensions (result of `php -m` should include pdo_mysql and json). On Debian based (Debian/Ubuntu/Mint) Linux You can install it using `sudo apt-get install php5-mysql php5-json`
 * In some cases it may be required to install **xml** extension for php (`sudo apt-get install php-xml`). Especially if you see **Attempt to load class "DOMDocument" from global namespace** 
 * You must have installed **MySQL** or **MariaDB** or run it using docker (see below in Setup/Database configuration)
 
 
## Setup

### To install dependencies

    php composer install

### Run tests

    php composer test

### Run tests as documentation

    php composer test-dox
    
### Run static analytics mess detector

    php composer mess-detector
    
### Run static analytics code sniffer

    php composer code-sniffer


## Run php server

    php artisan serve
    
    
## Database configuration

You must have configured database to be able to run tests and website.

If you have docker and docker-compose then all You have to do is to run `docker-compose up -d` and You have db ready to go. ([Install Docker Engine](https://docs.docker.com/engine/installation/), [Install Docker Compose](https://docs.docker.com/compose/install/), remember to add user to docker group after installing it `sudo usermod -a -G docker YourUserName`)

If You do not have docker then You must install MySQL or MariaDB to be accessed on port `3306` (default port) and there must be created database named `realskill` to which user `realskill` with password `realskill` has access.
```
$ mysql -u root -p
mysql> create database realskill;
mysql> grant usage on *.* to realskill@localhost identified by 'realskill';
mysql> grant all privileges on realskill.* to realskill@localhost ;
```


**Now You can access website via http://127.0.0.1:8000**

Good luck!
