<?php

require 'route.php';

echo '?';

if (Controllers\Controller::RunRouter($routeInfo) === true) {
   exit;
} 
