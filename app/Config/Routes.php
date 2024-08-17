<?php

use App\Controllers\UserController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->group('api', function($routes) {
    $routes->get('users', 'UserController::show');  
    $routes->post('users', 'UserController::create');  
    $routes->put('users/(:num)', 'UserController::update/$1');
    $routes->delete('users/(:num)', 'UserController::delete/$1');
    });

// $routes->group('api', ['filter' => 'jwt'], function($routes) {
//         $routes->get('users', 'UserController::index');
//         $routes->get('users/(:segment)', 'UserController::show/$1');
    
//     });

    $routes->get('tasks', 'TaskController::show');
    $routes->get('tasks', 'TaskController::index');
    $routes->post('tasks', 'TaskController::create');  
    $routes->put('tasks/(:num)', 'TaskController::update/$1');
    $routes->delete('tasks/(:num)', 'TaskController::delete/$1');

    $routes->get('projects', 'ProjectController::show');
    $routes->post('projects', 'ProjectController::create');  
    $routes->put('projects/(:num)', 'ProjectController::update/$1');
    $routes->delete('projects/(:num)', 'ProjectController::delete/$1');
