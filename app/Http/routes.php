<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//authentication
// Authentication routes...
Route::get('/', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::group(['middleware' => 'auth'], function () {
//user
    Route::get('view/users/list', 'UserController@index');
    Route::get('get/users/data', ['as' => 'get.users.data', 'uses' => 'UserController@getAllUsersData']);
    Route::get('users/export', 'UserController@export');
    Route::post('/deactivate/user', 'UserController@deactivateUser');
    Route::post('/create/user', 'UserController@createUser');
    Route::post('/edit/user', 'UserController@editUser');

    Route::get('admin', 'AdminController@index')->name('index');
    Route::get('dashboard', 'AdminController@viewDashboard')->name('home');


    /*
        |-------------------------------------------------------------------------
        |	User Routes
        |-------------------------------------------------------------------------
        */
    Route::get('user/matrix', 'UserController@showUserMatrix')->name('user.matrix');
    Route::post('user/matrix', 'UserController@updateUserMatrix')->name('user.matrix');
    Route::get('user/role/{user}/edit', 'UserController@editUserRoles')->name('user.role.edit');
    Route::post('user/role/{user}', 'UserController@updateUserRoles')->name('user.role.update');
    Route::resource('user', 'UserController',
        ['names' => [
            'create' => 'user.create',
            'destroy' => 'user.destroy',
            'edit' => 'user.edit',
            'index' => 'user.index',
            'show' => 'user.show',
            'store' => 'user.store',
            'update' => 'user.update'
        ]
        ]
    );

    /*
        |-------------------------------------------------------------------------
        |	Role Routes
        |-------------------------------------------------------------------------
        */
    Route::get('role/matrix', 'RoleController@showRoleMatrix')->name('role.matrix');
    Route::post('role/matrix', 'RoleController@updateRoleMatrix')->name('role.matrix');
    Route::get('role/permission/{role}/edit', 'RoleController@editRolePermissions')->name('role.permission.edit');
    Route::post('role/permission/{role}', 'RoleController@updateRolePermissions')->name('role.permission.update');
    Route::get('role/user/{role}/edit', 'RoleController@editRoleUsers')->name('role.user.edit');
    Route::post('role/user/{role}', 'RoleController@updateRoleUsers')->name('role.user.update');
    Route::post('/deactivate/role', 'RoleController@deactivateRole')->name('deactivate.role');
    Route::get('role/data', 'RoleController@getAllRolesData')->name('roles.data');
    Route::resource('role', 'RoleController',
        ['names' => [
            'create' => 'role.create',
            'destroy' => 'role.destroy',
            'edit' => 'role.edit',
            'index' => 'role.index',
            'show' => 'role.show',
            'store' => 'role.store',
            'update' => 'role.update'
        ]
        ]
    );

    /*
        |-------------------------------------------------------------------------
        |	Permission Routes
        |-------------------------------------------------------------------------
        */
    Route::get('permission/role/{role}/edit', 'PermissionController@editRole')->name('permission.role.edit');
    Route::post('permission/role/{role}', 'PermissionController@updateRole')->name('permission.role.update');
    Route::get('permission/data', 'PermissionController@getAllPermissionsData')->name('permissions.data');
    Route::post('/deactivate/permission', 'PermissionController@deactivatePermission')->name('deactivate.permission');


    Route::resource('permission', 'PermissionController',
        ['names' => [
            'create' => 'permission.create',
            'destroy' => 'permission.destroy',
            'edit' => 'permission.edit',
            'index' => 'permission.index',
            'show' => 'permission.show',
            'store' => 'permission.store',
            'update' => 'permission.update'
        ]
        ]
    );


//Customer
    Route::get('view/customer/list', 'CustomerController@index');
    Route::get('get/customers/data', ['as' => 'get.customers.data', 'uses' => 'CustomerController@getAllCustomersData']);
    Route::get('customers/export', 'CustomerController@export');
    Route::post('/deactivate/customer', 'CustomerController@deativateCustomer');
    Route::post('/create/customer', 'CustomerController@createCustomer');
    Route::post('/edit/customer', 'CustomerController@editCustomer');
    Route::get('/data/customers', 'CustomerController@getCustomersData');

//employees
    Route::get('view/employees/list', 'EmployeeController@index');
    Route::get('get/employees/data', ['as' => 'get.employees.data', 'uses' => 'EmployeeController@getAllEmployeesData']);
    Route::get('employees/export', 'EmployeeController@export');
    Route::get('employees/create', 'EmployeeController@employeeCreateView');
    Route::post('/deactivate/employee', 'CustomerController@deativateEmployee');
    Route::post('/create/employee', 'EmployeeController@createEmployee');
    Route::post('/edit/employee', 'EmployeeController@editEmployee');
    Route::get('/edit/employee/view/{employee_id}', 'EmployeeController@editEmployeeView');

//designations
    Route::get('get/designations/data', 'DesignationController@getDesignationData');
    Route::post('/create/designation', 'DesignationController@createDesignation');

//orders

    Route::get('view/orders/list/{status}', 'OrderController@viewOrders');
    Route::get('get/orders/data/{status}', ['uses' => 'OrderController@getOrdersData']);
    Route::post('create/order', ['uses' => 'OrderController@createOrder']);
    Route::post('make/payment/order', ['uses' => 'OrderController@makePayment']);
    Route::post('close/order', ['uses' => 'OrderController@closeOrder']);

    Route::get('order/create/view', 'OrderController@orderCreateView');

//materials

    Route::get('/data/materials', 'MaterialController@getMaterialsData');
    Route::get('/view/materials', 'MaterialController@index');
    Route::get('/get/all/materials/data', 'MaterialController@getAllMaterials');
    Route::post('/create/material', 'MaterialController@createMaterial');
    Route::post('/edit/material', 'MaterialController@editMaterial');
    Route::post('/upload/material/image', 'MaterialController@uploadMaterialImage');
    Route::post('/deactivate/material', 'MaterialController@deactivateMaterial');
    Route::get('/view/images', 'MaterialController@viewMaterialImages');


//clothe types
    Route::get('/data/clothe/types', 'ClotheTypeController@getClotheTypesData');

//measurements
    Route::get('view/customer/measurements/{customer_id}', 'MeasurementController@index');
    Route::get('get/customer/measurements/{customer_id}', 'MeasurementController@getMeasurements');
    Route::get('view/measurement/details/{measurement_id}', 'MeasurementController@viewMeasurementDetails');
    Route::get('add/measurement/{customer_id}', 'MeasurementController@addMeasurementView');
    Route::post('/save/measurement', 'MeasurementController@saveMeasurementsData');
    Route::post('/edit/measurement', 'MeasurementController@editMeasurement');
    Route::post('/deactivate/measurement', 'MeasurementController@deactivateMeasurement');

//expenses
    Route::get('view/expenses', 'ExpenseController@index');
    Route::get('get/all/expenses/data', 'ExpenseController@getExpenseData');
    Route::post('/create/expense', 'ExpenseController@saveExpense');
    Route::post('/deactivate/expense', 'ExpenseController@deactivateExpense');
    Route::post('/edit/expense', 'ExpenseController@editExpense');

//expenses category
//Route::get('view/expenses','ExpenseController@index');
    Route::get('get/expense/categories', 'ExpenseController@getExpenseCategories');
    Route::post('/create/expense/category', 'ExpenseController@saveExpenseCategory');
//Route::post('/deactivate/expense','ExpenseController@deactivateExpense');
//Route::post('/edit/expense','ExpenseController@editExpense');

//documents
    Route::get('view/documents', 'DocumentController@index');
    Route::get('get/all/documents/data', 'DocumentController@getAllDocuments');
    Route::post('/create/document', 'DocumentController@saveDocument');
    Route::post('/deactivate/document', 'DocumentController@deactivateDocument');
    Route::post('/edit/document', 'DocumentController@editDocument');
    Route::get('/download/document/{document_id}', 'DocumentController@downloadDocument');

});



