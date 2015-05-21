<?php 

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);
define('ROUTE_DIR', ROOT.DS.'albus'.DS.'Routes'.DS.'*.php');

require ROOT.DS.'albus'.DS.'Core'.DS.'autoloader.php';

// All user defined routes should be defined in albus/Routes/<filename>.php
// Configuration of dependencies are in albus/Routes/default.php
foreach (glob(ROUTE_DIR) as $userRoute) {
    require $userRoute;
}
