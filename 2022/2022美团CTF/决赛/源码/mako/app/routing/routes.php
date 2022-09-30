<?php

use app\controllers\Index;
use app\controllers\ImagesController;

/** @var \mako\http\routing\Routes $routes */
$routes->get('/', [ImagesController::class, 'home']);
$routes->post('/upload', [ImagesController::class, 'upload']);
$routes->get('/edit', [ImagesController::class, 'editGet']);
$routes->post('/edit', [ImagesController::class, 'editPost']);
