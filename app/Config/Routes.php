<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
// $routes->setDefaultController('Home');
$routes->setDefaultController('LapakController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');
$routes->get('api/lapak', 'LapakController::index');
$routes->get('api/lapak/(:num)', 'LapakController::show/$1');
$routes->get('api/lapak/count', 'LapakController::countItems');
$routes->get('api/lapak/search', 'LapakController::search');
// $routes->post('api/lapak', 'LapakController::create');
// $routes->put('api/lapak/(:num)', 'LapakController::update/$1');
// $routes->delete('api/lapak/(:num)', 'LapakController::delete/$1');

// $routes->post('api/register', 'AuthController::register');
$routes->post('api/login', 'AuthController::login');
$routes->post('api/refresh-token', 'AuthController::refreshToken');;

$routes->group('/',['filter' => 'auth'], function ($routes) {
    $routes->get('api/logout', 'AuthController::logout');

    $routes->get('api/protected', 'ProtectedController::index');

    $routes->post('api/lapak', 'LapakController::create');
    $routes->put('api/lapak/(:num)', 'LapakController::update/$1');
    $routes->delete('api/lapak/(:num)', 'LapakController::delete/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
