# P6 OPC - Snowtricks - Jonathan Billard

Here, my first project with STMFONY, let's clone to start it !

## Starting project

### requirements

- PHP 7.4+

### Packages Installation

First, clone project then install all composer packages with command line : ``composer install``

### Create Database & create tricks fixtures

- Before creating database, setting database line in .env file

_your .env, database url line example_:
```
    DATABASE_URL="mysql://root@127.0.0.1:3306/snowtricks?serverVersion=mariadb-10.4.11" 
```
- Then, to create your database, run this command line : ``symfony console doctrine:database:create``

### Mailer settings

- Change mailer DSN in .env with your SMTP informations

_your .env, mailer gmail DSN line example_:
```
    MAILER_DSN="gmail://email@gmail.com:Password@default" 
```

> :warning: **Gmail SHOULD NOT be used on production, use it in development only**

### Maintainability Code Climate Badge

[![Maintainability](https://api.codeclimate.com/v1/badges/32a44790ed6666a0f23f/maintainability)](https://codeclimate.com/github/Kaloss38/P6_snowtricks/maintainability)

