<?php

Auth::routes();

Route::get('/', function(){
	return view('frontend.layouts.carousel');
});

Route::get('/galleries', function(){
	return view('frontend.layouts.galleries');
});

Route::get('/contactus', function(){
	return view('frontend.layouts.contact_us');
});

Route::get('/online/reservation','FrontEndController@onlineReservation');

Route::get('/online/reservation/bedspacer','FrontEndController@displayBedSpacerRooms');

Route::get('/online/reservation/private','FrontEndController@displayPrivateRooms');

Route::get('/online/{id}/reservationForm','FrontEndController@reservationForm');

Route::post('/online/{id}/reserve','FrontEndController@reserve');

//for Other users
Route::group(['middleware' => ['isActive','auth']], function()
{
Route::post('/send','FrontEndController@mail');

Route::get('/client','ClientController@index');

// Route::get('/client/financial','ClientController@financial');

Route::get('/client/{id}/reservationEdit','ClientController@reservationEdit');

Route::post('/client/{id}/reseveEdit','ClientController@reseveEdit');

Route::post('/client/editAccount','HomeController@editAccount');

Route::get('/sample', function(){
	return view('admin.sample');
});

Route::get('/tenant/account', 'HomeController@account');

Route::get('/tenant/financial','HomeController@financial');
});

Route::group(['middleware' => ['isAdmin','isActive','auth']], function()
{
	//Admin Routes
	Route::get('/admin','AdminController@index');

	Route::get('/admin/occupantsDatatable','AdminController@occupantsDatatable');

	Route::post('/admin/{id}/leaveTenant','AdminController@leaveTenant');

	Route::get('/admin/{id}/addTenant','AdminController@addTenant');

	Route::get('/admin/{id}/addTenantRoom','AdminController@addTenantRoom');

	Route::get('/admin/assignClient','AdminController@assignClient');

	Route::post('/admin/storeAssign','AdminController@storeAssign');

	Route::get('/admin/{id}/changeRoom','AdminController@changeRoom');

	Route::post('/admin/{id}/roomChanged','AdminController@roomChanged');

	Route::get('/admin/{id}/availAmenity','AdminController@availAmenity');

	Route::post('/admin/{id}/availed','AdminController@availed');

	//Manage Users Routes
	Route::get('/manage-users/getUsersDatatable','ManageUsersController@getUsersDatatable');

	Route::get('/manage-users/inactiveUserDatatable','ManageUsersController@inactiveUser');

	Route::post('/manage-users/{id}/setActive','ManageUsersController@setActive');

	//Manage Rooms Routes
	Route::get('/manage-rooms/getRoomsDatatable','ManageRoomsController@getRoomsDatatable');

	Route::get('/manage-rooms/{id}/leaveTenantForm','ManageRoomsController@leaveTenantForm');

	Route::get('/manage-rooms/{id}/leaveTenant','ManageRoomsController@leaveTenant');
	
	//Manage Amenities
	Route::get('/manage-amenities/getAmenitiesDatatable','ManageAmenitiesController@getAmenitiesDatatable');
	
	Route::get('/manage-amenities/{id}/avail','ManageAmenitiesController@avail');

	Route::post('/manage-amenities/{id}/addAvail','ManageAmenitiesController@addAvail');

	//Reservations Route
	Route::get('/reservations/index','ReservationsController@index');

	Route::get('/reservations/reservationDatatable','ReservationsController@reservationDatatable');

	Route::get('/reservations/cancelReservationDatatable','ReservationsController@cancelReservationDatatable');

	Route::get('/reservations/addResevation','ReservationsController@addResevation');

	Route::post('/reservations/storeReservation','ReservationsController@storeReservation');

	Route::get('/reservations/{id}/editReservation','ReservationsController@editReservation');

	Route::post('/reservations/{id}/storeEditReservation','ReservationsController@storeEditReservation');

	Route::post('/reservations/{id}/cancel','ReservationsController@cancel');

	Route::get('/reservations/{id}/formPay','ReservationsController@formPay');

	Route::post('/reservations/{id}/payResevation','ReservationsController@payResevation');

	//Process Billings 
	Route::get('/process/billing','ProcessBillingController@index');

	Route::get('/process/tenant_payments','ProcessBillingController@tenant_payments');

	Route::post('/process/{id}/payTenant','ProcessBillingController@payTenant');

	Route::post('/process/payAdvance','ProcessBillingController@payAdvance');

	Route::get('/process/getProcessDatatable','ProcessBillingController@getProcessDatatable');

	Route::get('/process/paymentsDatatable','ProcessBillingController@paymentsDatatable');

	//Financials Route
	Route::get('/billing/index','BillingController@index');

	// Route::get('/billing/getDatatable','BillingController@getDatatable');

	Route::get('/billing/financial_table','BillingController@financial_table');

	Route::get('/billing/automateBill','BillingController@automateBill');


	//Generate reports
	Route::get('/reports/monthly','GenerateReportsController@monthly');

	Route::get('/reports/mReportsDatatable','GenerateReportsController@mReportsDatatable');

	Route::get('/reports/occupancy','GenerateReportsController@occupancy');

	Route::get('/reports/cReportsDatatable','GenerateReportsController@cReportsDatatable');

	//Resource for CRUD
	Route::resource('/manage-users','ManageUsersController');

	Route::resource('/manage-rooms','ManageRoomsController');

	Route::resource('/manage-amenities','ManageAmenitiesController');

});




