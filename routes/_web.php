<?php

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckRole;

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
    return view('auth/login');
});
Route::get('/signup', [Controller::class, 'sign_up'])->name('sign_up');
Route::post('/save', [Controller::class, 'save'])->name('save');
Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {
     
    Route::prefix('admin')->name('admin.')->middleware([CheckAdmin::class])->group(function () 
    {
    
        Route::middleware(['auth:sanctum', 'verified'])->get('dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('/programs/add-video-url', [ProgramController::class, 'addVideoUrl'])->name('program.addVideoUrl');
        Route::get('/sections/add-questions', [SectionController::class, 'addQues'])->name('program.section.addQues');
        Route::get('/sections/add-options', [SectionController::class, 'addOptions'])->name('program.section.addOptions');
        Route::get('/sections/{id}', [SectionController::class, 'index'])->name('program.section.index');
        Route::get('/programs/add-survey', [ProgramController::class, 'addSurvey'])->name('program.addSurvey');
        // Route::get('/programs/sections/edit/{id}', [ProgramController::class, 'editSections'])->name('program.section.edit');
        Route::get('/organizations/show/{id}', [OrganizationController::class, 'show_org']);
        Route::resources([
            'programs' => ProgramController::class,
            'organizations' => OrganizationController::class,
            'sections' => SectionController::class,
        ]);
    });
});