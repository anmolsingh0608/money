<?php

use App\Http\Controllers\AssessmentsController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PSurveyContoller;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckRole;
use App\Models\Assessment;
use Doctrine\DBAL\Driver\API\SQLite\UserDefinedFunctions;
use App\Models\Role;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
Route::get('helper', function(){ hi(); });
Route::get('/signup', [Controller::class, 'sign_up'])->name('sign_up');
Route::post('/save', [Controller::class, 'save'])->name('save');

Route::prefix('admin')->name('admin.')->middleware(['auth:sanctum', 'verified', CheckAdmin::class])->group(function () {

	Route::get('/dashboard', function () {
            return view('dashboard');
        });

    Route::get('/programs/add-video-url', [ProgramController::class, 'addVideoUrl'])->name('program.addVideoUrl');
    Route::get('/sections/add-questions', [SectionController::class, 'addQues'])->name('program.section.addQues');
    Route::get('/sections/add-options', [SectionController::class, 'addOptions'])->name('program.section.addOptions');
    Route::get('/questions/add-exam-question', [QuestionController::class, 'addQues'])->name('question.addQues');
    Route::get('/sections/add-links', [SectionController::class, 'addLinks'])->name('section.addLinks');
    Route::get('/questions/add-exam-options', [QuestionController::class, 'addOptions'])->name('question.addOptions');
    Route::get('/questions/add-exam-answer', [QuestionController::class, 'addAnswers'])->name('question.addAnswers');
    Route::get('/questions/add-sub-question', [QuestionController::class, 'addSubQues'])->name('question.addSubQues');
    Route::get('/sections/add-sub-question', [PSurveyContoller::class, 'addSubQues'])->name('section.addSubQues');
    Route::get('/questions/add-sub-option', [QuestionController::class, 'addSubOpts'])->name('question.addSubOpts');
    Route::get('/sections/add-sub-option', [PSurveyContoller::class, 'addSubOpts'])->name('section.addSubOpts');
    Route::get('/questions/add-feedback-option', [QuestionController::class, 'addFeedbackOpts'])->name('question.feedbackoption');
    Route::get('exams/add-questions-list', [ExamController::class, 'addquest'])->name('exam.addquest');
    Route::get('exams/add-feedbacks-list', [ExamController::class, 'addFeedBack'])->name('exam.addFeedBack');
    Route::get('/sections/{id}', [SectionController::class, 'index'])->name('program.section.index');
    Route::get('/programs/add-survey', [ProgramController::class, 'addSurvey'])->name('program.addSurvey');
    Route::post('/user/password_reset_link', [UsersController::class, 'sendEmail'])->name('user.password_reset_link');
    // Route::get('/programs/sections/edit/{id}', [ProgramController::class, 'editSections'])->name('program.section.edit');
    Route::get('/organizations/show/{id}', [OrganizationController::class, 'show_org']);
    Route::get('/assessments/list', [AssessmentsController::class, 'list'])->name('assessments.list');
    Route::get('/assessments/create/{type}', [AssessmentsController::class, 'create'])->name('assessments.create.type');
    Route::get('/getSections/{id}', [AssessmentsController::class, 'getSections'])->name('getSections');
//Route::get('/dashboard', [OrganizationController::class, 'dashboard']);
    Route::resources([
        'programs' => ProgramController::class,
        'organizations' => OrganizationController::class,
        'sections' => SectionController::class,
        'users' => UsersController::class,
        'exams' => ExamController::class,
        'questions' => QuestionController::class,
        'assessments' => AssessmentsController::class,
        'survey' => SurveyController::class,
        'reports' => ReportController::class,
        'psurvey' => PSurveyContoller::class,
    ]);
});


Route::group(['middleware' => ['auth:sanctum', 'verified', CheckRole::class]], function() {
    Route::get('/', [DashboardController::class, 'user'])->name('user');
    Route::get('/program/{id}', [DashboardController::class, 'program'])->name('program');
    Route::get('/section/{p_id}/{id}', [DashboardController::class, 'section'])->name('section');
    Route::post('/store/{id}', [SurveyController::class, 'store'])->name('store');
    Route::get('/thankyou/{id}', [DashboardController::class, 'thankyou'])->name('thankyou');
    Route::get('/exam/{ass_id}/{id}', [ExamController::class, 'showExam'])->name('examShow');
    Route::post('/exam/save', [ExamController::class,'saveExam'])->name('examSave');
    Route::get('/thanks', function () {
        return view('user/thanks');
    })->name('thanks');
    Route::get('generate-pdf', [ExamController::class, 'pdf'])->name('generate-pdf');
    Route::get('/needhelp', [DashboardController::class, 'needhelp'])->name('needhelp');
    Route::get('/know', [DashboardController::class, 'know'])->name('know');
    Route::POST('exams/progressSave', [DashboardController::class, 'progressSave'])->name('progressSave');
    Route::POST('videoStatus', [DashboardController::class, 'videoStatus'])->name('videoStatus');
});
