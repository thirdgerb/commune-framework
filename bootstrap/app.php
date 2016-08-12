<?php

if(!defined('PROJECT_PATH')){
    define('PROJECT_PATH',realpath(__DIR__.'/../'));
}
/*
 *
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Commune\Foundation\Application(
    BASE_PATH,
    PROJECT_PATH
);

require PROJECT_PATH.'/bootstrap/init.php';

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
