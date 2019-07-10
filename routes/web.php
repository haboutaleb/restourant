<?php

Auth::routes();
Route::get('/','HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/logout', 'Auth\LoginController@userLogout')->name('logout');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('password.update');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/email','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.email');

# Admin Login
Route::group(['prefix' => 'admin-panel', 'namespace' => 'Auth\Admin'], function() {
	Route::get('/login', 'AdminLoginController@showAdminLoginForm')->name('admin-panel.login');
	Route::post('/login', 'AdminLoginController@adminLogin')->name('admin.submit.login');
	Route::post('/logout', 'AdminLoginController@adminLogout')->name('admin.logout');
});

# Admin routes
Route::group(['prefix' => 'admin-panel', 'middleware' => 'auth:admin', 'namespace' => 'Back'], function()
{
	Route::get('/', 'AdminController@home')->name('admin-panel');
    Route::get('/orders','OrderController@index')->name('order');
    Route::get('/orders/create','OrderController@create')->name('order.create');
    Route::get('/orders/edit','OrderController@edit')->name('order.edit');

	// admin -> jops Routes
	// Route::resource('jops', 'JopController', ['except' => ['show']]);
	// Route::post('ajax-change-jop-status', 'JopController@ChangeJopStatus');
	// Route::post('/jops/ajax-delete-jop', 'JopController@DeleteJop');
	// Route::post('/jops/all/ajax-restore-jop', 'JopController@RestoreJop');
	// Route::post('/jops/all/ajax-remove-jop', 'JopController@RemoveJop');
	// Route::get('/jops/all/trashed', 'JopController@Trashed')->name('jops.trashed');

	// admin -> departments Routes
	// Route::resource('departments', 'DepartmentController', ['except' => ['show']]);
	// Route::post('ajax-change-department-status', 'DepartmentController@ChangeDepartmentStatus');
	// Route::post('/departments/ajax-delete-department', 'DepartmentController@DeleteDepartment');
	// Route::post('/departments/all/ajax-restore-department', 'DepartmentController@RestoreDepartment');
	// Route::post('/departments/all/ajax-remove-department', 'DepartmentController@RemoveDepartment');
	// Route::get('/departments/all/trashed', 'DepartmentController@Trashed')->name('departments.trashed');

	// admin -> Items Routes
	Route::resource('items', 'ItemController');
	Route::post('ajax-change-item-status', 'ItemController@ChangeItemStatus');
	Route::post('/items/ajax-delete-item', 'ItemController@DeleteItem');
	Route::post('/items/all/ajax-restore-item', 'ItemController@RestoreItem');
	Route::post('/items/all/ajax-remove-item', 'ItemController@RemoveItem');
	Route::get('/items/all/trashed', 'ItemController@Trashed')->name('items.trashed');

	// admin -> cities Routes
	Route::resource('tables', 'TableController');
	Route::post('ajax-change-table-status', 'TableController@ChangeTableStatus');
	Route::post('/tables/ajax-delete-table', 'TableController@DeleteTable');
	Route::post('/tables/all/ajax-restore-table', 'TableController@RestoreTable');
	Route::post('/tables/all/ajax-remove-table', 'TableController@RemoveTable');
	Route::get('/tables/all/trashed', 'TableController@Trashed')->name('tables.trashed');

	// admin -> categories Routes
	Route::resource('categories', 'CategoryController');
	Route::post('ajax-change-category-status', 'CategoryController@ChangeCategoryStatus');
	Route::post('/categories/ajax-delete-category', 'CategoryController@DeleteCategory');
	Route::post('/categories/all/ajax-restore-category', 'CategoryController@RestoreCategory');
	Route::post('/categories/all/ajax-remove-category', 'CategoryController@RemoveCategory');
	Route::get('/categories/all/trashed', 'CategoryController@Trashed')->name('categories.trashed');

	// admin -> users Routes
	Route::resource('users', 'UserController', ['except' => ['show']]);
	// Route::post('ajax-change-user-status', 'UserController@ChangeUserStatus');
	// Route::post('/users/ajax-delete-user', 'UserController@DeleteUser');
	// Route::post('/users/all/ajax-restore-user', 'UserController@RestoreUser');
	// Route::post('/users/all/ajax-remove-user', 'UserController@RemoveUser');
	// Route::get('/users/all/trashed', 'UserController@Trashed')->name('users.trashed');

	// admin -> Admins Routes
	Route::resource('admins', 'AdminController');
	Route::get('admin/{id}/profile', 'AdminController@adminProfile')->name('admins.profile');
	Route::post('/admin/{id}/profile', 'AdminController@AdminUpdateProfile')->name('admins.updateprofile');
	Route::post('ajax-change-admin-status', 'AdminController@ChangeAdminStatus');
	Route::post('ajax-delete-admin', 'AdminController@DeleteAdmin');
	Route::post('/admins/all/ajax-restore-admin', 'AdminController@RestoreAdmin');
	Route::post('/admins/all/ajax-remove-admin', 'AdminController@RemoveAdmin');
	Route::get('/admins/all/trashed', 'AdminController@Trashed')->name('admins.trashed');

	// admin -> Settings Routes
	// Route::resource('settings', 'SettingController');
	// Route::post('ajax-change-setting-status', 'SettingController@ChangeSettingStatus');
	// Route::post('ajax-delete-setting', 'SettingController@DeleteSetting');
	// Route::post('/settings/all/ajax-restore-setting', 'SettingController@RestoreSetting');
	// Route::post('/settings/all/ajax-remove-setting', 'SettingController@RemoveSetting');
	// Route::get('/settings/all/trashed', 'SettingController@Trashed')->name('settings.trashed');

	// admin -> contacts Routes
	// Route::resource('contacts', 'ContactController', ['except' => ['show']]);
});

# Staff Routes
Route::group(['namespace' => 'Back', 'middleware' => 'web'], function() {
	// Route::get('/user/{id}/profile', 'UserController@UserProfile')->name('users.profile');
	// Route::post('/user/{id}/profile', 'UserController@UserUpdateProfile')->name('users.updateprofile');
	// // Route::get('/company/{id}/profile', 'UserController@CompanyProfile')->name('users.company');
	// Route::get('/user/department/{id}', 'UserController@Department')->name('users.department');
	// Route::post('/user/{user_id}/jop/{jop_id}', 'UserController@SetUserJob');
	// Route::post('/user/{id}/profile/project', 'UserController@SetStudentProject')->name('users.updateProject');
	// Route::get('/user/{id}/courses', 'UserController@courses')->name('users.courses');
	// Route::post('/contact', 'UserController@SendMessage')->name('users.contact');
	// Route::get('/companies', 'UserController@Companies')->name('users.companies');
	// Route::get('/jobs', 'UserController@jobs')->name('users.jops');
	// Route::get('/my-jobs', 'UserController@MyJobs')->name('users.my-jobs');
	// Route::post('/user/{user_id}/courses', 'UserController@AddNewCourse')->name('users.add-course');
	// Route::get('/search', 'UserController@Search')->name('users.search');
});
