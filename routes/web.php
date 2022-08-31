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
        $router->post('signin', 'api\AuthController@signin');
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

        $router->group(['prefix' => 'country'], function () use ($router) {
            $router->get('select', 'CountryController@select');
            // $router->get('select2', 'CountryController@select2');
            $router->get('all', 'CountryController@all');
            $router->post('datatables', 'CountryController@datatables');

            $router->post('', 'CountryController@store');
            $router->get('{id}', 'CountryController@show');
            $router->put('{id}', 'CountryController@update');
            $router->delete('{id}', 'CountryController@destroy');
        });

        $router->group(['prefix' => 'province'], function () use ($router) {
            $router->get('select', 'ProvinceController@select');
            // $router->get('select2', 'ProvinceController@select2');
            $router->get('by-name', 'ProvinceController@byName');
            $router->get('all', 'ProvinceController@all');
            $router->post('datatables', 'ProvinceController@datatables');

            $router->post('', 'ProvinceController@store');
            $router->get('{id}', 'ProvinceController@show');
            $router->put('{id}', 'ProvinceController@update');
            $router->delete('{id}', 'ProvinceController@destroy');
        });

        $router->group(['prefix' => 'city'], function () use ($router) {
            $router->get('select', 'CityController@select');
            // $router->get('select2', 'CityController@select2');
            $router->get('by-name', 'CityController@byName');
            $router->get('all', 'CityController@all');
            $router->post('datatables', 'CityController@datatables');

            $router->post('', 'CityController@store');
            $router->get('{id}', 'CityController@show');
            $router->put('{id}', 'CityController@update');
            $router->delete('{id}', 'CityController@destroy');
        });

        $router->group(['prefix' => 'subdistrict'], function () use ($router) {
            $router->get('select', 'SubdistrictController@select');
            // $router->get('select2', 'SubdistrictController@select2');
            $router->get('by-name', 'SubdistrictController@byName');
            $router->get('all', 'SubdistrictController@all');
            $router->post('datatables', 'SubdistrictController@datatables');

            $router->post('', 'SubdistrictController@store');
            $router->get('{id}', 'SubdistrictController@show');
            $router->put('{id}', 'SubdistrictController@update');
            $router->delete('{id}', 'SubdistrictController@destroy');
        });

        $router->group(['prefix' => 'village'], function () use ($router) {
            // $router->get('select', 'SubdistrictController@select');
            // $router->get('select2', 'SubdistrictController@select2');
            $router->get('by-name', 'VillageController@byName');
            $router->get('all', 'VillageController@all');
            $router->post('datatables', 'VillageController@datatables');

            $router->post('', 'VillageController@store');
            $router->get('{id}', 'VillageController@show');
            $router->put('{id}', 'VillageController@update');
            $router->delete('{id}', 'VillageController@destroy');
        });

        $router->group(['prefix' => 'types'], function () use ($router) {
            $router->get('by-code', 'TypesController@byCode');
            $router->get('bySeq', 'TypesController@bySeq');
            $router->get('getAllRoles', 'TypesController@getAllRoles');
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
            $router->get('reset/{id}', 'UsersController@reset');
            $router->get('session', 'UsersController@session');
            $router->get('select', 'UsersController@select');
            $router->get('select/{id}', 'UsersController@selectwithsamebp');
            $router->get('all', 'UsersController@allUser');
            $router->get('prospect-owner', 'UsersController@prospectowner');
            $router->post('datatables', 'UsersController@datatables');
            $router->post('datatables/{id}', 'UsersController@datatablesbp');

            $router->post('', 'UsersController@store');
            $router->get('{id}', 'UsersController@show');
            $router->put('{id}', 'UsersController@update');
            $router->delete('{id}', 'UsersController@destroy');
        });

        $router->group(['prefix' => 'bpcustomer'], function () use ($router) {
            $router->get('select', 'BpCustomerController@select');
            $router->get('select/{id}', 'BpCustomerController@selectBp');
            $router->get('', 'BpCustomerController@all');
            $router->post('datatables', 'BpCustomerController@datatables');
            $router->post('datatables/{id}', 'BpCustomerController@datatablesbp');

            $router->post('', 'BpCustomerController@store');
            $router->get('{id}', 'BpCustomerController@show');
            $router->post('{id}', 'BpCustomerController@update');
            $router->delete('{id}', 'BpCustomerController@destroy');
        });

        $router->group(['prefix' => 'customer'], function () use ($router) {
            $router->get('select', 'CustomerController@select');
            // $router->get('select2', 'CustomerController@select2');
            $router->get('all', 'CustomerController@allUser');
            $router->post('datatables', 'CustomerController@datatables');

            $router->post('', 'CustomerController@store');
            $router->get('{id}', 'CustomerController@show');
            $router->put('{id}', 'CustomerController@update');
            $router->delete('{id}', 'CustomerController@destroy');
        });

        $router->group(['prefix' => 'dailyactivity'], function () use ($router) {
            $router->get('bp/{id}', 'DailyActivityController@all');
            $router->post('datatables/{id}', 'DailyActivityController@datatables');

            $router->get('{id}', 'DailyActivityController@show');
        });

        $router->group(['prefix' => 'competitor'], function () use ($router) {
            $router->get('select', 'CompetitorController@select');
            $router->post('deleteimages', 'CompetitorController@deleteImages');
            $router->post('datatables', 'CompetitorController@datatables');
            $router->post('datatables/{id}', 'CompetitorController@datatablesbp');

            $router->post('', 'CompetitorController@store');
            $router->get('{id}', 'CompetitorController@show');
            $router->post('{id}', 'CompetitorController@update');
            $router->delete('{id}', 'CompetitorController@destroy');
        });

        $router->group(['prefix' => 'customfield'], function () use ($router) {
            $router->get('select', 'CustomFieldController@select');
            $router->get('select/{id}', 'CustomFieldController@selectBp');
            $router->get('withbp/{id}', 'CustomFieldController@WithBp');
            $router->post('selectwithbp/{id}', 'CustomFieldController@selectWithBp');
            $router->post('datatables', 'CustomFieldController@datatables');
            $router->post('datatables/{id}', 'CustomFieldController@datatablesbp');

            $router->post('', 'CustomFieldController@store');
            $router->get('{id}', 'CustomFieldController@show');
            $router->put('{id}', 'CustomFieldController@update');
            $router->delete('{id}', 'CustomFieldController@destroy');
        });

        $router->group(['prefix' => 'file'], function () use ($router) {
            $router->get('all', 'FilesController@all');
            $router->post('datatables', 'FilesController@datatables');

            $router->post('prospect', 'FilesController@storeProspect');

            $router->get('{id}', 'FilesController@show');
            $router->put('{id}', 'FilesController@update');
            $router->delete('{id}', 'FilesController@destroy');
        });

        $router->group(['prefix' => 'contact'], function () use ($router) {
            $router->get('all', 'ContactPersonController@all');
            $router->post('datatables', 'ContactPersonController@datatables');

            $router->post('', 'ContactPersonController@store');
            $router->post('/massStore', 'ContactPersonController@massStore');
            $router->get('{id}', 'ContactPersonController@show');
            $router->put('{id}', 'ContactPersonController@update');
            $router->delete('{id}', 'ContactPersonController@destroy');
        });

        $router->group(['prefix' => 'product'], function () use ($router) {
            $router->get('select', 'ProductController@select');
            $router->get('select/{id}', 'ProductController@selectwithbp');
            $router->get('', 'ProductController@all');
            $router->post('datatables', 'ProductController@datatables');

            $router->post('', 'ProductController@store');
            $router->get('{id}', 'ProductController@show');
            $router->put('{id}', 'ProductController@update');
            $router->delete('{id}', 'ProductController@destroy');
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
            $router->get('bp/{id}', 'ScheduleController@all');

            $router->post('', 'ScheduleController@store');
            $router->get('{id}', 'ScheduleController@show');
            $router->put('{id}', 'ScheduleController@update');
            $router->delete('{id}', 'ScheduleController@destroy');
        });

        $router->group(['prefix' => 'prospect'], function () use ($router) {
            $router->get('lastid', 'ProspectController@lastid');
            $router->get('select', 'ProspectController@select');
            $router->get('selectref', 'ProspectController@selectref');
            $router->get('', 'ProspectController@all');
            $router->post('datatables/{id}', 'ProspectController@datatablesbp');
            $router->post('datatables', 'ProspectController@datatables');
            $router->post('customer', 'ProspectController@storeCustomer');
            $router->post('product', 'ProspectController@storeProduct');

            $router->post('', 'ProspectController@store');
            $router->get('{id}', 'ProspectController@show');
            $router->put('{id}', 'ProspectController@update');
            $router->delete('{id}', 'ProspectController@destroy');
        });

        $router->group(['prefix' => 'prospectactivity'], function () use ($router) {
            $router->get('', 'ProspectActivityController@all');
            $router->post('details', 'ProspectActivityController@details');

            $router->post('', 'ProspectActivityController@store');
            $router->get('{id}', 'ProspectActivityController@show');
            $router->put('{id}', 'ProspectActivityController@update');
            $router->delete('{id}', 'ProspectActivityController@destroy');
        });

        $router->group(['prefix' => 'prospectassign'], function () use ($router) {
            $router->get('', 'ProspectAssignController@all');
            $router->post('details', 'ProspectAssignController@details');

            $router->post('', 'ProspectAssignController@store');
            $router->get('{id}', 'ProspectAssignController@show');
            $router->put('{id}', 'ProspectAssignController@update');
            $router->delete('{id}', 'ProspectAssignController@destroy');
        });

        $router->group(['prefix' => 'prospectcustomfield'], function () use ($router) {
            $router->get('', 'ProspectCustomFieldController@all');

            $router->post('', 'ProspectCustomFieldController@store');
            $router->get('{id}', 'ProspectCustomFieldController@show');
            $router->put('{id}', 'ProspectCustomFieldController@update');
            $router->delete('{id}', 'ProspectCustomFieldController@destroy');
        });

        $router->group(['prefix' => 'prospectproduct'], function () use ($router) {
            $router->get('', 'ProspectProductController@all');
            $router->post('details', 'ProspectProductController@details');

            $router->post('', 'ProspectProductController@store');
            $router->get('{id}', 'ProspectProductController@show');
            $router->put('{id}', 'ProspectProductController@update');
            $router->delete('{id}', 'ProspectProductController@destroy');
        });
    });

    $router->group(['namespace' => 'Security'], function () use ($router) {

        $router->get('450905094', 'PermissionController@permission');

        $router->group(['prefix' => 'menus'], function () use ($router) {
            $router->get('select', 'MenusController@select');
            $router->post('datatables', 'MenusController@datatables');

            $router->post('', 'MenusController@store');
            $router->get('{id}', 'MenusController@show');
            $router->put('{id}', 'MenusController@update');
            $router->delete('{id}', 'MenusController@destroy');
        });

        $router->group(['prefix' => 'feature'], function () use ($router) {
            $router->post('datatables/{id}', 'FeaturesController@datatables');

            $router->post('', 'FeaturesController@store');
            $router->get('{id}', 'FeaturesController@show');
            $router->put('{id}', 'FeaturesController@update');
            $router->delete('{id}', 'FeaturesController@destroy');
        });

        $router->group(['prefix' => 'permission'], function () use ($router) {
            $router->post('role', 'PermissionController@role');
            $router->get('menu', 'PermissionController@menu');

            $router->post('', 'PermissionController@store');
            $router->get('{id}', 'PermissionController@show');
            $router->put('{id}', 'PermissionController@update');
            $router->delete('{id}', 'PermissionController@destroy');
        });

        $router->group(['prefix' => 'home'], function () use ($router) {
            $router->get('{id}', 'HomeController@index');
            // $router->post('datatables', 'MenusController@datatables');

            // $router->post('', 'MenusController@store');
            // $router->get('{id}', 'MenusController@show');
            // $router->put('{id}', 'MenusController@update');
            // $router->delete('{id}', 'MenusController@destroy');
        });

        $router->group(['prefix' => 'profile'], function () use ($router) {
            $router->get('{id}', 'ProfileController@index');
            // $router->post('datatables', 'MenusController@datatables');

            // $router->post('', 'MenusController@store');
            // $router->get('{id}', 'MenusController@show');
            // $router->put('{id}', 'MenusController@update');
            // $router->delete('{id}', 'MenusController@destroy');
        });
    });

    $router->group(['prefix' => 'api'], function () use ($router) {
        $router->get('RJXvksjS', 'api\AuthController@verifyToken');
        $router->get('pIeYujTv', 'api\AuthController@signOut');

        $router->group(['namespace' => 'api\Masters'], function () use ($router) {
            $router->group(['prefix' => 'types'], function () use ($router) {
                $router->get('by-code', 'TypesController@byCode');
                $router->get('{id}', 'TypesController@show');
            });

            $router->group(['prefix' => 'user'], function () use ($router) {
                $router->get('', 'UsersController@all');
                $router->post('', 'UsersController@store');
                $router->get('{id}', 'UsersController@show');
                $router->put('{id}', 'UsersController@update');
                $router->delete('{id}', 'UsersController@destroy');
                $router->put('{id}/attach-device', 'UsersController@attachDevice');
            });

            $router->group(['prefix' => 'businesspartner'], function () use ($router) {
                $router->get('', 'BusinessPartnerController@all');
                $router->post('', 'BusinessPartnerController@store');
                $router->get('{id}', 'BusinessPartnerController@show');
                $router->put('{id}', 'BusinessPartnerController@update');
                $router->delete('{id}', 'BusinessPartnerController@destroy');
            });

            $router->group(['prefix' => 'schedule'], function () use ($router) {
                $router->get('count', 'ScheduleController@scheduleCount');
                $router->get('', 'ScheduleController@all');
                $router->post('', 'ScheduleController@store');
                $router->get('{id}', 'ScheduleController@show');
                $router->put('{id}', 'ScheduleController@update');
                $router->delete('{id}', 'ScheduleController@destroy');
            });

            $router->group(['prefix' => 'bpcustomer'], function () use ($router) {
                $router->get('', 'BpCustomerController@all');
                $router->post('', 'BpCustomerController@store');
                $router->get('{id}', 'BpCustomerController@show');
                $router->put('{id}', 'BpCustomerController@update');
                $router->delete('{id}', 'BpCustomerController@destroy');
            });

            $router->group(['prefix' => 'customer'], function () use ($router) {
                $router->get('', 'CustomerController@all');
                $router->post('', 'CustomerController@store');
                $router->get('{id}', 'CustomerController@show');
                $router->put('{id}', 'CustomerController@update');
                $router->delete('{id}', 'CustomerController@destroy');
            });

            $router->group(['prefix' => 'country'], function () use ($router) {
                $router->get('by-name', 'CountryController@byName');
                $router->get('', 'CountryController@all');
                $router->post('', 'CountryController@store');
                $router->get('{id}', 'CountryController@show');
                $router->put('{id}', 'CountryController@update');
                $router->delete('{id}', 'CountryController@destroy');
            });

            $router->group(['prefix' => 'province'], function () use ($router) {
                $router->get('by-name', 'ProvinceController@byName');
                $router->get('', 'ProvinceController@all');
                $router->post('', 'ProvinceController@store');
                $router->get('{id}', 'ProvinceController@show');
                $router->put('{id}', 'ProvinceController@update');
                $router->delete('{id}', 'ProvinceController@destroy');
            });

            $router->group(['prefix' => 'city'], function () use ($router) {
                $router->get('by-name', 'CityController@byName');
                $router->get('', 'CityController@all');
                $router->post('', 'CityController@store');
                $router->get('{id}', 'CityController@show');
                $router->put('{id}', 'CityController@update');
                $router->delete('{id}', 'CityController@destroy');
            });

            $router->group(['prefix' => 'subdistrict'], function () use ($router) {
                $router->get('by-name', 'SubdistrictController@byName');
                $router->get('', 'SubdistrictController@all');
                $router->post('', 'SubdistrictController@store');
                $router->get('{id}', 'SubdistrictController@show');
                $router->put('{id}', 'SubdistrictController@update');
                $router->delete('{id}', 'SubdistrictController@destroy');
            });

            $router->group(['prefix' => 'prospect'], function () use ($router) {
                $router->get('count', 'ProspectController@prospectCount');
                $router->get('', 'ProspectController@all');
                $router->post('', 'ProspectController@store');
                $router->get('{id}', 'ProspectController@show');
                $router->put('{id}', 'ProspectController@update');
                $router->delete('{id}', 'ProspectController@destroy');
            });

            $router->group(['prefix' => 'prospectactivity'], function () use ($router) {
                $router->get('', 'ProspectActivityController@all');
                $router->post('', 'ProspectActivityController@store');
                $router->get('{id}', 'ProspectActivityController@show');
                $router->put('{id}', 'ProspectActivityController@update');
                $router->delete('{id}', 'ProspectActivityController@destroy');
            });

            $router->group(['prefix' => 'prospectproduct'], function () use ($router) {
                $router->get('', 'ProspectProductController@all');
                $router->post('', 'ProspectProductController@store');
                $router->get('{id}', 'ProspectProductController@show');
                $router->put('{id}', 'ProspectProductController@update');
                $router->delete('{id}', 'ProspectProductController@destroy');
            });

            $router->group(['prefix' => 'contactperson'], function () use ($router) {
                $router->get('', 'ContactPersonController@all');
                $router->post('', 'ContactPersonController@store');
                $router->get('{id}', 'ContactPersonController@show');
                $router->put('{id}', 'ContactPersonController@update');
                $router->delete('{id}', 'ContactPersonController@destroy');
            });

            $router->group(['prefix' => 'prospectassign'], function () use ($router) {
                $router->get('', 'ProspectAssignController@all');
                $router->post('', 'ProspectAssignController@store');
                $router->get('{id}', 'ProspectAssignController@show');
                $router->put('{id}', 'ProspectAssignController@update');
                $router->delete('{id}', 'ProspectAssignController@destroy');
            });

            $router->group(['prefix' => 'chat'], function () use ($router) {
                $router->get('conversation', 'ChatController@getConversation');
                $router->get('users-unread-messages', 'ChatController@usersUnreadMessages');
                $router->get('read', 'ChatController@readMessage');
                $router->get('', 'ChatController@all');
                $router->post('', 'ChatController@store');
                $router->get('{id}', 'ChatController@show');
                $router->put('{id}', 'ChatController@update');
                $router->delete('{id}', 'ChatController@destroy');
            });

            $router->group(['prefix' => 'village'], function () use ($router) {
                $router->get('by-name', 'VillageController@byName');
                $router->get('', 'VillageController@all');
                $router->post('', 'VillageController@store');
                $router->get('{id}', 'VillageController@show');
                $router->put('{id}', 'VillageController@update');
                $router->delete('{id}', 'VillageController@destroy');
            });

            $router->group(['prefix' => 'files'], function () use ($router) {
                $router->get('', 'FilesController@all');
                $router->post('', 'FilesController@store');
                $router->get('{id}', 'FilesController@show');
                $router->put('{id}', 'FilesController@update');
                $router->delete('{id}', 'FilesController@destroy');
            });

            $router->group(['prefix' => 'competitor'], function () use ($router) {
                $router->get('', 'CompetitorController@all');
                $router->post('', 'CompetitorController@store');
                $router->get('{id}', 'CompetitorController@show');
                $router->put('{id}', 'CompetitorController@update');
                $router->delete('{id}', 'CompetitorController@destroy');
            });

            $router->group(['prefix' => 'dailyactivity'], function () use ($router) {
                $router->get('count', 'DailyActivityController@dailyActivityCount');
                $router->get('', 'DailyActivityController@all');
                $router->post('', 'DailyActivityController@store');
                $router->get('{id}', 'DailyActivityController@show');
                $router->put('{id}', 'DailyActivityController@update');
                $router->delete('{id}', 'DailyActivityController@destroy');
            });
        });

        $router->group(['namespace' => 'api\Security'], function () use ($router) {
            $router->group(['prefix' => 'menus'], function () use ($router) {

                $router->post('', 'MenusController@store');
                $router->get('{id}', 'MenusController@show');
                $router->put('{id}', 'MenusController@update');
                $router->delete('{id}', 'MenusController@destroy');
            });
        });
    });
});
