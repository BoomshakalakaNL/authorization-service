<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', [
    'prefix' => 'api/v1',
    'namespace' => 'App\Http\Controllers\V1',
    'middleware' => ['api.throttle'],
    'limit' => 100,
    'expires' => 5
], function ($api) {
    $api->resource('permissions', 'PermissionController');
    $api->get('permissions/{permission}/activities', 'PermissionActivityController@indexPermission');
    $api->post('permissions/{permission}/activities', 'PermissionActivityController@storePermission');
    $api->delete('permissions/{permission}/activities/{activity}', 'PermissionActivityController@destroyPermission');

    $api->resource('activities', 'ActivityController');
    $api->get('activities/{activity}/permissions', 'PermissionActivityController@indexActivity');
    $api->post('activities/{activity}/permissions', 'PermissionActivityController@storeActivity');
    $api->delete('activities/{activity}/permissions/{permission}', 'PermissionActivityController@destroyActivity');
});


$router->get('/', function () use ($router) {
    return 'AuthorizationService.Verbeek';
});
