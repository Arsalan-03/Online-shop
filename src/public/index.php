<?php

require_once './Controllers/UserController.php';
require_once './Controllers/ProductController.php';
require_once './Controllers/CartController.php';

require_once '../Core/App.php';

$app = new App();
$app->run();