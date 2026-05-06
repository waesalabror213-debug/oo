<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'UserController::index');
$routes->get('location/(:num)', 'UserController::detail/$1');

// API Endpoints
$routes->get('api/puaskuliner', 'UserController::apiPuaskuliner');

// Auth Routes
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::attemptRegister');
$routes->get('logout', 'AuthController::logout');

// User Protected Routes
$routes->group('', ['filter' => 'auth:user,admin'], function ($routes) {
    $routes->get('favorites', 'UserController::favorites');
    $routes->post('location/(:num)/review', 'UserController::addReview/$1');
    $routes->get('location/(:num)/favorite', 'UserController::toggleFavorite/$1');
    $routes->get('submit', 'UserController::submit');
    $routes->post('submit', 'UserController::storeSubmission');
    $routes->get('location/(:num)/close', 'UserController::requestClosure/$1');
    $routes->get('review/edit/(:num)', 'UserController::editReview/$1');
    $routes->post('review/update/(:num)', 'UserController::updateReview/$1');
});


