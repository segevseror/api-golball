<?php

require 'route.php';

if (Controllers\Controller::RunRouter($routeInfo) === true) {
   exit;
} 