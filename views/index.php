<?php
// To call this page, in the browser type:
// http://localhost/

use proyecto\Controller\HomeController;
use proyecto\Router;

require __DIR__ . '/../vendor/autoload.php';

echo 'INDEX ';

Router::get("/",[HomeController::class,"bienvenido"]);



