# P6 OPC - Snowtricks - Jonathan Billard

[![Maintainability](https://api.codeclimate.com/v1/badges/32a44790ed6666a0f23f/maintainability)](https://codeclimate.com/github/Kaloss38/P6_snowtricks/maintainability)

Here, my first project with SYMFONY, let's clone to start it !

## Starting project

### requirements

- PHP 7.4+
- Composer
- Symfony @CLI

### Packages Installation

First, clone or download project then install all composer packages with command line : ``composer install``

### Create Database & create tricks fixtures

- Before creating database, setting database line in .env file

_your .env, database url line example_:
```
    DATABASE_URL="mysql://root:password@127.0.0.1:3306/snowtricks?serverVersion=mariadb-10.4.11" 
```
- Then, to create your database, run this command line : ``symfony console doctrine:database:create``

### Mailer settings

- Change mailer DSN in .env with your SMTP informations

_your .env, mailer gmail DSN line example_:
```
    MAILER_DSN="gmail://email@gmail.com:Password@default" 
```

> :warning: **Gmail SHOULD NOT be used on production, use it in development only**

### Run local server

to run local server, run this command line : ``symfony serv``

### Symfony packages ( installed with composer )

- [Mailer & Gmail Smtp](https://symfony.com/doc/current/mailer.html)
- [String component](https://symfony.com/doc/current/components/string.html)
- [TwigErrorRenderer](https://symfony.com/doc/current/controller/error_pages.html)



