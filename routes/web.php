<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\RoomController;

use App\Http\Controllers\TeacherLoginController;
use App\Http\Controllers\StudentLoginController;
use App\Http\Controllers\MainController;

use App\Http\Controllers\LoginController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get("/adminlogin", function(){
    return view('auth.adminlogin');
});


Route::group(['middleware' => 'auth:admin', 'prefix' => '/admin'], function(){
    Route::get('/dashboard', [AdminController::class, 'index'])->name("admin.dashboard");
    Route::prefix('/schedules')->group(function(){
        Route::get('/', [ScheduleController::class, 'index'])->name("admin.schedules");
        Route::post('/', [ScheduleController::class, 'get'])->name("admin.getschedules");
        Route::post('/calendar', [ScheduleController::class, 'get_calendar'])->name("admin.getcalendar");
        Route::post('/add', [ScheduleController::class, 'create'])->name("admin.addschedule");
        Route::post('/delete', [ScheduleController::class, 'delete'])->name("admin.deleteschedule");
        Route::post('/update', [ScheduleController::class, 'update'])->name("admin.updateschedule");
    });

    Route::prefix('subjects')->group(function(){
        Route::get('/', [SubjectController::class, 'index'])->name("admin.subjects");
        Route::post('/', [SubjectController::class, 'get'])->name("admin.getsubjects");
        Route::post('/add', [SubjectController::class, 'create'])->name("admin.addsubject");
        Route::post('/delete', [SubjectController::class, 'delete'])->name("admin.deletesubject");
        Route::post('/update', [SubjectController::class, 'update'])->name("admin.updatesubject");
    });

    Route::prefix('teachers')->group(function(){
        Route::get('/', [TeacherController::class, 'index'])->name("admin.teachers");
        Route::post('/', [TeacherController::class, 'get'])->name("admin.getteachers");
        Route::post('/add', [TeacherController::class, 'create'])->name("admin.addteacher");
        Route::post('/delete', [TeacherController::class, 'delete'])->name("admin.deleteteacher");
        Route::post('/update', [TeacherController::class, 'update'])->name("admin.updateteacher");
    });
    Route::prefix('rooms')->group(function(){
        Route::get('/', [RoomController::class, 'index'])->name("admin.rooms");
        Route::post('/', [RoomController::class, 'get'])->name("admin.getrooms");
        Route::post('/add', [RoomController::class, 'create'])->name("admin.addroom");
        Route::post('/delete', [RoomController::class, 'delete'])->name("admin.deleteroom");
        Route::post('/update', [RoomController::class, 'update'])->name("admin.updateroom");
    });

});

Route::get("/teacher", [MainController::class, 'index']);

//adminlogin
Route::prefix("/adminlogin")->group(function(){
    Route::get('/', [AdminLoginController::class, 'index']);
    Route::post('/', [AdminLoginController::class, 'dologin'])->name("admin.login");
});

//studentlogin
Route::prefix('/sudentlogin')->group(function(){
    Route::get('/', [StudentLoginController::class, 'index']);
    Route::post('/', [StudentLoginController::class, 'dologin']);
});

Route::get("/login", [LoginController::class, 'index'])->name("login");
// //teacherlogin
// Route::prefix("")