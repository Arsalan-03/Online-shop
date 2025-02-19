<?php

$autoloader = function (string $className) {

  $directories = [
      '../Core',
      '../Controllers'
  ];

  foreach ($directories as $directory) {
      $path = "$directory/$className.php";

      if (file_exists($path)) {
          require_once $path;
          return true;
      }
  }
  return false;
};

spl_autoload_register($autoloader);

//require_once '../Core/App.php';
$app = new App();
$app->run();