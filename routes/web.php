<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\check;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PagesController::class, 'index'])->name('index');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
   Route::get('/dashboard', [PagesController::class, 'patientDashboard']) ->name('dashboard');
});



//---------------------------------------/
Route::post("/login/custom",[LoginController::class,"login"]);

Route::group(['middleware' => ['isDoctor']], function() {
  Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor-dashboard');
  Route::post('/doctor', [DoctorController::class, 'store'])->name('doctor-dashboard');
  Route::get('/doctor/show/patient',[DoctorController::class, 'showPatient']);
  Route::post('/doctor/find/patient',[DoctorController::class, 'findPatient']);
});

Route::group(['middleware' => ['isPatient']], function() {
    Route::get("/patient",[PatientController::class,"index"]);
});

Route::group(['middleware' => ['isNurse']], function() {
    Route::get('/nurse', [PagesController::class, 'nurseDashboard'])->name('nurse-dashboard');

    Route::get('/nurse/reserve', [PagesController::class, 'nurseReserve'])->name('nurse-reserve');

    Route::get('/nurse/working-hours', [PagesController::class, 'nurseWorkHourException'])->name('working-hours');
});

Route::get("/dashboard/user/",[check::class,"checkRole"]);
Route::view('/noacess','noacess');

Route::get('/doctor/find-patient', function () {
    return view('pages.doctor-find-patient');
});
