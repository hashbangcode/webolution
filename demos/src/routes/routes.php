<?php

// Routes

$app->get('/', function ($request, $response, $args) {
  // Sample log message
  $this->logger->info("Index '/' route");

  // Render index view
  return $this->view->render($response, 'index.twig');
});

require __DIR__ . '/../../src/routes/color.php';
require __DIR__ . '/../../src/routes/element.php';
require __DIR__ . '/../../src/routes/number.php';
require __DIR__ . '/../../src/routes/text.php';