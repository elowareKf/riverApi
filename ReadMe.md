# River Data API

This project ist a backend server for  a riverdatabase

####to run the project make sure to run the composer install!

## Project target

To build a common backend for all projects which needs a river, section database


## Structure

The project uses two docker container
 - Web server
 - MySql Database

## Using for your database

To connect the PHP script to your own database server create a file named Credentials.php in the services folder with the content:
````php
<?php

class Credentials {
    public static $server = "server name";
    public static $port = 3306;
    public static $database = "database";
    public static $user = "username";
    public static $password = "top secret password";
}
````



## Framework
The PHP web application is built on composer

# Open Issues

## TODO
 - [ ] Implement security against SQL-injection
 - [ ] Implement Writing methods

# License
[Creative Commons Attribution-ShareAlike 4.0 International (CC BY-SA 4.0) License.](https://creativecommons.org/licenses/by-sa/4.0/)
