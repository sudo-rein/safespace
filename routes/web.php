<?php

use App\Http\Controllers\Counselor\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\HomeController;
use App\Http\Controllers\Student\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Counselor\ReviewQueueController;
use App\Http\Controllers\Counselor\IncidentController;
use App\Http\Controllers\Counselor\CaseController;
use App\Http\Controllers\Counselor\ReportExportController;
use App\Http\Controllers\Student\MessageController;

use App\Http\Controllers\Counselor\MessageController as CounselorMessageController;

use App\Http\Controllers\Counselor\StudentDataController;

Route::get('/', function () {
    return view('welcome');
});

// Sends each role to its own home
Route::get('/dashboard', function () {
    return auth()->user()->isCounselor()
        ? redirect()->route('counselor.dashboard')
        : redirect()->route('student.home');
})->middleware('auth')->name('dashboard');


// testing area
//privacy
Route::view('/privacy', 'privacy.notice')->name('privacy');


// Student area
Route::middleware(['auth', 'student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');

        Route::get('/report', [ReportController::class, 'create'])->name('report.create');
        Route::post('/report', [ReportController::class, 'store'])->name('report.store');
        Route::get('/report/{incident}/confirmation', [ReportController::class, 'confirmation'])->name('report.confirmation');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{incident}', [ReportController::class, 'show'])->name('reports.show');

        Route::post('/reports/{incident}/messages', [MessageController::class, 'store'])->name('reports.messages');
    });

// Counselor area
Route::middleware(['auth', 'counselor'])
    ->prefix('counselor')
    ->name('counselor.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/queue', [ReviewQueueController::class, 'index'])->name('queue');
        Route::get('/notifications/{id}/read', [DashboardController::class, 'readNotification'])->name('notifications.read');
        Route::get('/incidents/{incident}', [IncidentController::class, 'show'])->name('incidents.show');
        Route::get('/incidents/{incident}/attachments/{attachment}', [IncidentController::class, 'attachment'])->name('incidents.attachment');
        Route::post('/incidents/{incident}/risk', [IncidentController::class, 'overrideRisk'])->name('incidents.risk');
        Route::post('/incidents/{incident}/case', [CaseController::class, 'open'])->name('incidents.case.open');
        Route::get('/cases/{case}', [CaseController::class, 'show'])->name('cases.show');
        Route::post('/cases/{case}/notes', [CaseController::class, 'addNote'])->name('cases.notes');
        Route::post('/cases/{case}/interventions', [CaseController::class, 'addIntervention'])->name('cases.interventions');
        Route::post('/cases/{case}/follow-ups', [CaseController::class, 'addFollowUp'])->name('cases.followups');
        Route::post('/cases/{case}/follow-ups/{followUp}/done', [CaseController::class, 'completeFollowUp'])->name('cases.followups.done');
        Route::post('/cases/{case}/status', [CaseController::class, 'updateStatus'])->name('cases.status');
        Route::post('/cases/{case}/close', [CaseController::class, 'close'])->name('cases.close');
        Route::get('/cases/{case}/pdf', [CaseController::class, 'pdf'])->name('cases.pdf');Route::get('/reports', [ReportExportController::class, 'index'])->name('reports');
        Route::get('/reports/periodic', [ReportExportController::class, 'periodic'])->name('reports.periodic');


        Route::post('/incidents/{incident}/messages', [CounselorMessageController::class, 'store'])->name('incidents.messages');
        Route::get('/students', [StudentDataController::class, 'index'])->name('students');
        Route::get('/students/{user}/export', [StudentDataController::class, 'export'])->name('students.export');
        
    });
    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';