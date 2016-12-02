# Symfony 2.8 - Exercise 5 - Simple CRUD on REST


## Summary

Expected result of this task is an application which allows user to create/read/update/delete row in the table using REST requests.

Sample employee structure:
```
[
    'id' => 1,
    'name' => 'Martin'
    'surname' => 'Fowler'
    'email' => 'martin.fowler@fake.pl'
    'daysInOffice' => 2,
    'bio' => 'Lorem ipsum dolor sit amet.'
]
```

To make working with JSON requests easy we have installed and configured **symfony-json-request-transformer** bundle so:
```
A request with JSON content like:
{
  "foo": "bar"
}
will be decoded automatically so can access the foo property like:

$request->request->get('foo');
```

If you have solved **Symfony 2 - Exercise 4 - Simple CRUD** then You can copy `Employee` entity to this branch and step 1 will be done.
`git checkout task/4-simple-crud -- src/AppBundle/Entity/Employee.php`

In this exercise creating any form is not required. If You want to experiment with created app You can use for example chrome extansion called **[Postman](https://chrome.google.com/webstore/detail/postman/fhbjgbiflinjbdggehcddcbncdddomop?utm_source=chrome-ntp-icon)**.

## Goals

In order to complete this exercise you will need to follow these steps:

1. Create `Employee` entity in `AppBundle/Entity/Employee.php` with proper `namespace`. Entity should contain properties listed below with setters and getters for each one.

  * id - primary key, autoincrement
  * name - type: `string`, length: 64, required, assertions:
    * not blank
    * min length = 3
    * max length = 64
  * surname  - type: `string`, length: 64, required, assertions: 
    * not blank
    * min length = 3
    * max length = 64
  * email  - type: `string`, length: 254, required, unique, assertions:
    * not blank
    * email
    * max length = 254
  * bio  - type: `string`, length: 400, not required, assertions:
    * max length = 400
  * daysInOffice  - type: `smallint`, required, assertions:
    * not blank
    * range(2,5)
    * min range message = "You must be at least {{ limit }} days working in the office."
    * max range message = "You cannot work more than {{ limit }} days in the office."
  
2. Create endpoint to retrieve list of employees
  * should be accessed via GET "/api/employee"
  * should return array of employees as JSON
  
3. Create endpoint to create new employee
  * should be accessed via POST "/api/employee"
  * should assign name, surname, email, bio, daysInOffice from request to `Employee` object
  * should validate if `Employee` after assigning data is valid
  * if `Employee` is invalid it should return JSON with property success equal false and errors containing array of error messages per each property with **PRECONDITION_FAILED** status code - use specially created for this purpose `violation_list_converter` service to convert errors from `validator` service to array eg:
  ```
  {
    "success": false,
    "errors": {
      "name": "This value should not be blank."
    }
  }
  ```
  * if unique constraint will throw exception it should return JSON response with property success equal false and errors containing info for `email` property that `Such email exists in DB.` with **CONFLICT** status code like below:
  ```
  {
    "success": false,
    "errors": {
      "email": "Such email exists in DB."
    }
  }
  ```
  * if `Employee` is valid it should create it and return JSON response with property `success` set to to true and id set to newly created object id like below:
  ```
  {
    "success": true,
    "id": 15
  }
  ```
  
4. Create endpoint to update existing employee
  * should be accessed via PUT "/api/employee/{employeeId}"
  * should assign name, surname, email, bio, daysInOffice from request to `Employee` object
  * should validate if `Employee` after assigning data is valid
  * if `Employee` with given `employeeId` not exist it should return **NOT_FOUND** status code and JSON with property `success` set to false
  * if `Employee` is invalid it should return JSON with property success equal false and errors containing array of error messages per each property with **PRECONDITION_FAILED** status code - use specially created for this purpose `violation_list_converter` service to convert errors from `validator` service to array eg:
    ```
    {
      "success": false,
      "errors": {
        "name": "This value should not be blank."
      }
    }
    ```
    * if unique constraint will throw exception it should return JSON response with property success equal false and errors containing info for `email` property that `Such email exists in DB.` with **CONFLICT** status code like below:
    ```
    {
      "success": false,
      "errors": {
        "email": "Such email exists in DB."
      }
    }
    ```
    * if `Employee` is valid it should create it and return JSON response with property `success` set to to true and id set to newly created object id like below:
    ```
    {
      "success": true,
      "id": 15
    }
    ```

5. Create endpoint to delete existing employee
  * should be accessed via DELETE "/api/employee/{employeeId}"
  * if `Employee` with given `employeeId` not exist it should **NOT_FOUND** status code and JSON with property `success` set to false
  * if `Employee` with given `employeeId` exist it should delete him and return JSON with property `success` set to true

Expected result of `php app/composer test-dox` for completed exercise is listed below:
```
AppBundle\Tests\Entity\Employee
 [x] Should not allow to save employee without name
 [x] Should not allow to save employee without surname
 [x] Should not allow to save employee without email
 [x] Should not allow to save employee without days in office
 [x] Should not allow to save employee with same email that exists in db
 [x] Should allow to save employee without bio
 [x] Should have defined length of each string field and trim if is longer

AppBundle\Tests\Feature\CreateEmployee
 [x] Should return precondition failed with proper errors if empty data is send
 [x] Should return precondition failed with proper errors if all send employee properties are empty
 [x] Should return precondition failed with proper errors if name is to short
 [x] Should return precondition failed with proper errors if name is to long
 [x] Should return precondition failed with proper errors if surname is to short
 [x] Should return precondition failed with proper errors if surname is to long
 [x] Should return precondition failed with proper errors if email is invalid
 [x] Should return precondition failed with proper errors if email is to long
 [x] Should return precondition failed with proper errors if bio is to long
 [x] Should return precondition failed with proper errors if days in office is invalid
 [x] Should return precondition failed with proper errors if days in office has to low value
 [x] Should return precondition failed with proper errors if days in office has to high value
 [x] Should save employee if proper data is given and return its id
 [x] Should not require bio

AppBundle\Tests\Feature\DeleteEmployee
 [x] Should return 404 if employee not exists and json with property status set to false
 [x] Should delete certain employee

AppBundle\Tests\Feature\RetrieveEmployee
 [x] Should return employees array

AppBundle\Tests\Feature\UpdateEmployee
 [x] Should save employee if proper data is given and return its id
 [x] Should not require bio
 [x] Should return precondition failed with proper errors if empty data is send
 [x] Should return precondition failed with proper errors if all send employee properties are empty
 [x] Should return precondition failed with proper errors if name is to short
 [x] Should return precondition failed with proper errors if name is to long
 [x] Should return precondition failed with proper errors if surname is to short
 [x] Should return precondition failed with proper errors if surname is to long
 [x] Should return precondition failed with proper errors if email is invalid
 [x] Should return precondition failed with proper errors if email is to long
 [x] Should return precondition failed with proper errors if bio is to long
 [x] Should return precondition failed with proper errors if days in office is invalid
 [x] Should return precondition failed with proper errors if days in office has to low value
 [x] Should return precondition failed with proper errors if days in office has to high value
```


## Hints

Most of changes should lay in `src` dir. You can also modify templates in `app/Resources/views`. If needed You can also modify config and other files in `app` dir.

If You want to see what goals You have passed You should run: `php app/composer test-dox`. Each scenario with **[x]** has passed and those with **[ ]** has to be done.

More info about errors during tests You can get running tests with command: `php app/composer test`

This task is concerned as done when all tests are passing and when code-sniffer and mess-detector do not return errors nor warnings (ignore info about "Remaining deprecation notices" during test).

Remember to commit changes before You change branch.

Remember to install dependencies if You change branch.

### Helpful links

Please remember to read documentation for Symfony 2.8 because it can differ in newer/older versions.

* [Symfony documentation](https://symfony.com/doc/2.8/page_creation.html)

## Requirements

 * You must have installed **PHP 5** with **pdo_mysql** and **json** extensions (result of `php -m` should include pdo_mysql and json). On Debian based (Debian/Ubuntu/Mint) Linux You can install it using `sudo apt-get install php5-mysql php5-json`
 * In some cases it may be required to install **xml** extension for php (`sudo apt-get install php-xml`). Especially if you see **Attempt to load class "DOMDocument" from global namespace** 
 * You must have installed **MySQL** or **MariaDB** or run it using docker (see below in Setup/Database configuration)
 
## Setup

### To install dependencies

    php app/composer install

### Run tests

    php app/composer test

### Run tests as documentation

    php app/composer test-dox
    
### Run static analytics mess detector

    php app/composer mess-detector
    
### Run static analytics code sniffer

    php app/composer code-sniffer


## Run php server

    php app/console server:run
    
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
