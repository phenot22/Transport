<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\LoginHistoryController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\TruckerController;

Route::get('/', function () {
    return view('auth/adminlogin');
});


//AUTHCoNTROLLER
Route::get('adminlogin',[AuthController::class,'adminLogin'])->name('adminlogin');
Route::get('companylogin',[AuthController::class,'companyLogin'])->name('companylogin');
Route::get('truckerslogin',[AuthController::class,'truckersLogin'])->name('truckerslogin');
Route::get('registration',[AuthController::class,'registration'])->name('registration');
Route::get('truckersregistration',[AuthController::class,'registration1'])->name('truckersregistration');
Route::post('post-registration',[AuthController::class,'postRegistration'])->name('registration.post');
Route::post('post-truckerregistration',[AuthController::class,'postTruckerRegistration'])->name('truckerregistration.post');
Route::post('post-loginadmin',[AuthController::class,'postadminLogin'])->name('adminlogin.post');
Route::post('post-logincompany',[AuthController::class,'postcompanyLogin'])->name('companylogin.post');
Route::post('post-logintrucker',[AuthController::class,'postTruckerLogin'])->name('truckerlogin.post');
Route::post('post-login',[AuthController::class,'postadminLogin'])->name('adminlogin.post');
Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');
Route::get('notifications',[AuthController::class,'notifications'])->name('notifications');
Route::get('company',[AuthController::class,'company'])->name('company');
Route::get('truckers',[AuthController::class,'truckers'])->name('truckers');
Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard');
Route::get('/truckers', [AuthController::class, 'truckersList'])->name('truckers');
Route::post('/notifications/{id}/read', [AuthController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::post('/notifications/{id}/unread', [AuthController::class, 'markAsUnread'])->name('notifications.markAsUnread');
Route::get('logout',[AuthController::class,'logout'])->name('logout');



//TRIPCONTROLLER
Route::get('pendingtrips',[TripController::class,'pendingTrips'])->name('pendingtrips');
Route::get('completedtrips',[TripController::class,'completedtrips'])->name('completedtrips');
Route::get('/trip/index',[TripController::class,'index'])->name('trip.index');
Route::get('/trips', [TripController::class, 'index'])->name('index');
Route::get('/trip/create',[TripController::class,'create'])->name('trip.create');
Route::post('/trip',[TripController::class,'store'])->name('trip.store');
Route::get('/trip/{trip}/edit',[TripController::class,'edit'])->name('trip.edit');
Route::put('/trip/{trip}/update',[TripController::class,'update'])->name('trip.update');
Route::delete('/trip/{trip}/destroy',[TripController::class,'destroy'])->name('trip.destroy');
Route::get('archive', [TripController::class, 'archived'])->name('archive');
Route::post('/archive/restore/{id}', [TripController::class, 'restore'])->name('archived.restore');
Route::post('/trips/select/{id}', [TripController::class, 'selectTrip'])->name('trips.select');
Route::post('/company/selectedtrips/cancel/{id}', [TripController::class, 'cancel'])->name('trip.cancel');
Route::post('/company/pendingtrips/reject{id}', [TripController::class, 'reject'])->name('trip.reject');
Route::post('/company/pendingtrips/reject{id}', [TripController::class, 'reject1'])->name('trip.reject1');
Route::post('/trucker/selectedtrips/cancel{id}', [TripController::class, 'cancel1'])->name('trip.cancel1');


//COMPANYCONTROLLER
Route::get('company/trips',[CompanyController::class,'trips'])->name('company.trips');
Route::get('company/selectedtrips',[CompanyController::class,'selectedtrips'])->name('company.selectedtrips');
Route::delete('/company/{id}/delete', [CompanyController::class, 'destroy'])->name('delete.company');
Route::delete('/company/index/{id}/delete', [CompanyController::class, 'destroy1'])->name('delete1.company');
Route::get('/company/index', [CompanyController::class, 'truckersList1'])->name('company.index');
Route::get('/company/completedtrips',[CompanyController::class,'completed'])->name('company.completedtrips');
Route::get('/company/pendingtrips',[CompanyController::class,'pending'])->name('company.pendingtrips');
Route::get('/company/notifications',[CompanyController::class,'notifications'])->name('company.notifications');
Route::post('/company/notifications/{id}/read', [CompanyController::class, 'markAsRead'])->name('notifications.markAsRead1');
Route::post('/company/notifications/{id}/unread', [CompanyController::class, 'markAsUnread'])->name('notifications.markAsUnread1');

Route::put('/company/{id}/update', [CompanyController::class, 'update'])->name('update.company');
Route::get('/company/{id}/edit', [CompanyController::class, 'edit'])->name('edit.company');


//TRUCKERCONTROLLER
Route::put('/trucker/{id}/update', [TruckerController::class, 'update'])->name('trucker.update');
Route::get('/trucker/{id}/edit', [TruckerController::class, 'edit'])->name('trucker.edit');


Route::post('/trucker/assign/{id}', [TruckerController::class, 'assignTrip'])->name('trucker.assign');
Route::delete('/trucker/{id}/delete', [TruckerController::class, 'destroy'])->name('delete.trucker');
Route::get('/trucker/index', [TruckerController::class, 'index'])->name('trucker.index');
Route::get('/trucker/selectedtrips',[TruckerController::class,'selected'])->name('trucker.selectedtrips');
Route::get('/trucker/completedtrips',[TruckerController::class,'completed'])->name('trucker.completedtrips');
Route::post('/trucker/complete/{id}', [TruckerController::class, 'complete'])->name('trucker.complete');
Route::get('/trucker/notifications',[TruckerController::class,'notifications'])->name('trucker.notifications');
Route::post('/trucker/notifications/{id}/read', [TruckerController::class, 'markAsRead'])->name('notifications.markAsRead2');
Route::post('/trucker/notifications/{id}/unread', [TruckerController::class, 'markAsUnread'])->name('notifications.markAsUnread2');


//FORGOTPASSWORDCONTROLLER
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot.password.form');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetOTP'])->name('forgot.password');
Route::get('/reset-password/{email}', [ForgotPasswordController::class, 'showResetForm'])->name('reset.password.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password');


//ADMINCONTROLLER
Route::get('admin', [AdminController::class, 'index'])->name('admin');
Route::post('/completedtrips/settle/{id}', [AdminController::class, 'settle'])->name('admin.settle');

//LOGINHISTORYCONTROLLER    
Route::get('/loginhistory', [LoginHistoryController::class, 'index'])->name('loginhistory');


