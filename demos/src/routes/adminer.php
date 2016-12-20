<?php

use Hashbangcode\Wevolution\Evolution\EvolutionStorage;

function adminer_object() {

  class AdminerSoftware extends Adminer {

    function login($login, $password) {
      return true;
    }

  }

  return new AdminerSoftware();
}


$app->any('/adminer', function ($request, $response, $args) {

  if (!isset($_GET['username']) && !isset($_GET['db']) && !isset($_GET['file'])) {
    $database = realpath(__DIR__ . '/../../database/database.sqlite');
    header('Location: http://localhost:8000/adminer?sqlite=&username=&db=' . $database);
  }

  include __DIR__ . "/../../database/adminer.php";
});


$app->any('/clear_database', function ($request, $response) {

  $database = realpath(__DIR__ . '/../../database') . '/database.sqlite';
  $evolution = new EvolutionStorage();
  $evolution->setupDatabase('sqlite:' . $database);
  $evolution->clearDatabase();

  return $response->withStatus(302)->withHeader('Location', '/');
});