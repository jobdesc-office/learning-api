<?php

use Illuminate\Support\Facades\Crypt;

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('t2IF5xRe', function () {
    $types = new ReflectionClass(DBTypes::class);
    return response()->json($types->getConstants());
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('signin', 'AuthController@signin');
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('signin', 'AuthController@signin');
    });
    $router->get('t2IF5xRe', function () {
        $types = new ReflectionClass(DBTypes::class);
        return response()->json($types->getConstants());
    });
});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('RJXvksjS', 'AuthController@verifyToken');
    $router->get('pIeYujTv', 'AuthController@signOut');

    $router->group(['namespace' => 'Masters'], function () use ($router) {
        $router->group(['prefix' => 'types'], function () use ($router) {
            $router->get('by-code', 'TypesController@byCode');
            $router->post('datatables', 'TypesController@datatables');

            $router->post('', 'TypesController@store');
            $router->get('{id}', 'TypesController@show');
            $router->put('{id}', 'TypesController@update');
            $router->delete('{id}', 'TypesController@destroy');
        });

        $router->group(['prefix' => 'typeschildren'], function () use ($router) {
            $router->post('datatables', 'TypesChildrenController@datatablesNonFilter');
            $router->post('datatables/{id}', 'TypesChildrenController@datatables');
            $router->get('parent', 'TypesChildrenController@parent');
            $router->get('parent/{id}', 'TypesChildrenController@showParent');
            $router->get('children', 'TypesChildrenController@children');

            $router->post('', 'TypesController@store');
            $router->get('{id}', 'TypesController@show');
            $router->put('{id}', 'TypesController@update');
            $router->delete('{id}', 'TypesController@destroy');
        });

        $router->group(['prefix' => 'user'], function () use ($router) {
            $router->get('select', 'UsersController@select');
            $router->get('select2', 'UsersController@select2');
            $router->get('all', 'UsersController@allUser');
            $router->post('datatables', 'UsersController@datatables');

            $router->post('', 'UsersController@store');
            $router->get('{id}', 'UsersController@show');
            $router->put('{id}', 'UsersController@update');
            $router->delete('{id}', 'UsersController@destroy');
        });

        $router->group(['prefix' => 'businesspartner'], function () use ($router) {
            $router->get('select', 'BusinessPartnerController@select');
            $router->post('datatables', 'BusinessPartnerController@datatables');

            $router->post('', 'BusinessPartnerController@store');
            $router->get('{id}', 'BusinessPartnerController@show');
            $router->put('{id}', 'BusinessPartnerController@update');
            $router->delete('{id}', 'BusinessPartnerController@destroy');
        });

        $router->group(['prefix' => 'schedule'], function () use ($router) {
            $router->post('datatables', 'ScheduleController@datatables');

            $router->post('', 'ScheduleController@store');
            $router->get('{id}', 'ScheduleController@show');
            // $router->put('{id}', 'ScheduleController@update');
            // $router->delete('{id}', 'ScheduleController@destroy');
        });
    });

    $router->group(['namespace' => 'Security'], function () use ($router) {
        $router->group(['prefix' => 'menus'], function () use ($router) {
            $router->get('select', 'MenusController@select');
            $router->post('datatables', 'MenusController@datatables');

            $router->post('', 'MenusController@store');
            $router->get('{id}', 'MenusController@show');
            $router->put('{id}', 'MenusController@update');
            $router->delete('{id}', 'MenusController@destroy');
        });
    });

    $router->group(['prefix' => 'api'], function () use ($router) {
        $router->get('RJXvksjS', 'AuthController@verifyToken');
        $router->get('pIeYujTv', 'AuthController@signOut');

        $router->group(['namespace' => 'Masters'], function () use ($router) {
            $router->group(['prefix' => 'types'], function () use ($router) {
                $router->get('by-code', 'TypesController@byCode');
            });

            $router->group(['prefix' => 'user'], function () use ($router) {
                $router->get('', 'UsersController@all');
                $router->post('', 'UsersController@store');
                $router->get('{id}', 'UsersController@show');
                $router->put('{id}', 'UsersController@update');
                $router->delete('{id}', 'UsersController@destroy');
            });

            $router->group(['prefix' => 'businesspartner'], function () use ($router) {
                $router->get('', 'BusinessPartnerController@all');
                $router->post('', 'BusinessPartnerController@store');
                $router->get('{id}', 'BusinessPartnerController@show');
                $router->put('{id}', 'BusinessPartnerController@update');
                $router->delete('{id}', 'BusinessPartnerController@destroy');
            });

            $router->group(['prefix' => 'schedule'], function () use ($router) {
                $router->get('', 'ScheduleController@all');
                $router->post('', 'ScheduleController@store');
                $router->get('{id}', 'ScheduleController@show');
                $router->put('{id}', 'ScheduleController@update');
                $router->delete('{id}', 'ScheduleController@destroy');
            });
        });

        $router->group(['namespace' => 'Security'], function () use ($router) {
            $router->group(['prefix' => 'menus'], function () use ($router) {

                $router->post('', 'MenusController@store');
                $router->get('{id}', 'MenusController@show');
                $router->put('{id}', 'MenusController@update');
                $router->delete('{id}', 'MenusController@destroy');
            });
        });
    });
});
