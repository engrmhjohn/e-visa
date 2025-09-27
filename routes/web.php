<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CMSController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FrontviewController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\MaintenanceController;

Route::controller(FrontviewController::class)->group(function () {
    Route::get('/', 'index')->name('/');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', [CMSController::class, 'dashboard'])->name('dashboard');
    Route::get('/apply-now', [ApplicationController::class, 'showApplicationForm'])->name('apply.now');
    Route::post('/apply-now/step/1', [ApplicationController::class, 'saveStep1'])->name('apply.save.step1');
    Route::post('/apply-now/step/2', [ApplicationController::class, 'saveStep2'])->name('apply.save.step2');
    Route::post('/apply-now/step/3', [ApplicationController::class, 'saveStep3'])->name('apply.save.step3');
    Route::post('/apply-now/step/4', [ApplicationController::class, 'saveStep4'])->name('apply.save.step4');
    Route::post('/apply-now/step/5', [ApplicationController::class, 'saveStep5'])->name('apply.save.step5');
    Route::post('/apply-now/step/6', [ApplicationController::class, 'saveStep6'])->name('apply.save.step6');
    Route::post('/apply-now/step/7', [ApplicationController::class, 'saveStep7'])->name('apply.save.step7');
    Route::post('/apply-now/step/8', [ApplicationController::class, 'saveStep8'])->name('apply.save.step8');
    Route::post('/apply-now/step/9', [ApplicationController::class, 'saveStep9'])->name('apply.save.step9');
    Route::post('/apply-now/step/10', [ApplicationController::class, 'saveStep10'])->name('apply.save.step10');
    Route::get('/application/submitted/{application}', [ApplicationController::class, 'showSubmitted'])->name('application.submitted');
    Route::controller(ApplicationController::class)->group(function () {
        Route::get('/application/track', 'showTrack')->name('application.track');
        Route::post('/track-application-status', 'searchApplication')->name('search.application');
    });
    Route::delete('/application/delete/{id}', [CMSController::class, 'deleteApplication'])->name('application.delete');
    Route::get('/application/{application}/pdf', [PdfController::class, 'generateApplicationPdf'])->name('application.pdf.download');
    Route::get('/application/{application}/pdf/view', [PdfController::class, 'viewApplicationPdf'])->name('application.pdf.view');

    Route::get('/optimize:clear', [MaintenanceController::class, 'optimizeClear']);
    Route::get('/storage:link', [MaintenanceController::class, 'storageLink']);

    Route::controller(CMSController::class)->prefix('/admin')->group(function () {
        Route::get('/manage-my-application', 'manageMyApplication')->name('manage_my_application');
        Route::get('/edit-student-database/{id}', 'editStudentDatabase')->name('edit_student_database');
        Route::post('/update-student-database', 'updateStudentDatabase')->name('update_student_database');
        Route::delete('/delete-student-database/{id}', 'deleteStudentDatabase')->name('delete_student_database');
    });

    Route::middleware(['super_admin'])->group(function () {
        Route::controller(AdminController::class)->prefix('/admin')->name('admin.')->group(function () {
            Route::get('/role/{id}/{newRole}', 'role')->name('role');
            Route::get('/manage-admin', 'manageAdmin')->name('manage_admin');
            Route::get('/pending-user', 'pendingUser')->name('pending_user');
            Route::get('/admin-user', 'adminUser')->name('admin_user');
            Route::get('/super-admin-user', 'superAdminUser')->name('super_admin_user');
            Route::delete('/delete-admin/{id}', 'deleteAdmin')->name('delete_admin');
            Route::get('/edit-admin/{id}', 'editAdmin')->name('edit_admin');
            Route::post('/update-user-name-by-admin', 'updateUserNameByAdmin')->name('update_user_name_by_admin');
            Route::post('/update-user-email-by-admin', 'updateUserEmailByAdmin')->name('update_user_email_by_admin');
            Route::post('/update-user-photo-by-admin', 'updateUserPhotoByAdmin')->name('update_user_photo_by_admin');
            Route::post('/update-user-password-by-admin', 'updateUserPasswordByAdmin')->name('update_user_password_by_admin');
            Route::post('/update-user-phone-by-admin', 'updateUserPhoneByAdmin')->name('update_user_phone_by_admin');
        });
        Route::controller(CMSController::class)->prefix('/admin')->group(function () {
            Route::get('/manage-visa-application', 'manageVisaApplication')->name('manage_visa_application');
        });
        Route::get('/admin/application/{id}/edit-status', [CMSController::class, 'editStatus'])->name('application.edit.status');
        Route::post('/admin/application/{id}/update-status', [CMSController::class, 'updateStatus'])->name('application.update.status');
    });
});
