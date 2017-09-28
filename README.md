# PHP Symfony 2.8 scaffolding for RealSkill

You can quickly create Symfony tasks by cloning the scaffolding repo. You don't have to bother with configuration.

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
