<?php

use App\Http\Controllers\Admin\Core\CitiesController;
use App\Http\Controllers\Admin\Core\KeywordsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Other\FAQsController;
use App\Http\Controllers\Admin\Trainings\ProgramsAndTrainingsController;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\InstancesController;
use App\Http\Controllers\PublicPart\HomeController as PublicHomeController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    /**
     *  Public part of Web App
     */
    Route::get ('/',                              [PublicHomeController::class, 'home'])->name('public.home');

});

/**
 *  Auth routes
 */

Route::prefix('auth')->group(function () {
    /* ToDo:: Remove this later */
    // Route::get ('/',                              [AuthController::class, 'auth'])->name('login');

    Route::get ('/',                              [AuthController::class, 'auth'])->name('auth');
    Route::post('/authenticate',                  [AuthController::class, 'authenticate'])->name('auth.authenticate');
    Route::get ('/logout',                        [AuthController::class, 'logout'])->name('auth.logout');

    /* Create an account */
    Route::get ('/create-account',                [AuthController::class, 'createAccount'])->name('auth.create-account');
    Route::post('/save-account',                  [AuthController::class, 'saveAccount'])->name('auth.save-account');
    Route::get ('/verify-account/{token}',        [AuthController::class, 'verifyAccount'])->name('auth.verify-account');

    /* Restart password */
    Route::get ('/restart-password',              [AuthController::class, 'restartPassword'])->name('auth.restart-password');
    Route::post('/generate-restart-token',        [AuthController::class, 'generateRestartToken'])->name('auth.generate-restart-token');
    Route::get ('/new-password/{token}',          [AuthController::class, 'newPassword'])->name('auth.new-password');
    Route::post('/generate-new-password',         [AuthController::class, 'generateNewPassword'])->name('auth.generate-new-password');
});


/**
 *  Admin routes
 */

Route::prefix('system')->middleware('isAuthenticated')->group(function () {
    Route::prefix('admin')->middleware('isAdmin')->group(function (){
        Route::get('/dashboard',                 [HomeController::class, 'index'])->name('system.home');

        /**
         *  Users routes;
         */
        Route::prefix('users')->middleware('isAuthenticated')->group(function () {
            Route::get ('/',                          [UsersController::class, 'index'])->name('system.admin.users');
            Route::get ('/create',                    [UsersController::class, 'create'])->name('system.admin.users.create');
            Route::post('/save',                      [UsersController::class, 'save'])->name('system.admin.users.save');
            Route::get ('/preview/{username}',        [UsersController::class, 'preview'])->name('system.admin.users.preview');
            Route::get ('/edit/{username}',           [UsersController::class, 'edit'])->name('system.admin.users.edit');
            Route::post('/update',                    [UsersController::class, 'update'])->name('system.admin.users.update');
            Route::post('/update-profile-image',      [UsersController::class, 'updateProfileImage'])->name('system.admin.users.update-profile-image');
        });

        /**
         *  Other section
         *  1. FAQs
         */
        Route::prefix('other')->group(function () {
            /**
             *  FAQs section
             */
            Route::prefix('faq')->middleware('isAuthenticated')->group(function () {
                Route::get ('/',                               [FAQsController::class, 'faqIndex'])->name('system.admin.other.faq');
                Route::get ('/create',                         [FAQsController::class, 'faqCreate'])->name('system.admin.other.faq.create');
                Route::post('/save',                           [FAQsController::class, 'faqSave'])->name('system.admin.other.faq.save');
                Route::get ('/edit/{id}',                      [FAQsController::class, 'faqEdit'])->name('system.admin.other.faq.edit');
                Route::post('/update',                         [FAQsController::class, 'faqUpdate'])->name('system.admin.other.faq.update');
                Route::get ('/delete/{id}',                    [FAQsController::class, 'faqDelete'])->name('system.admin.other.faq.delete');
            });
        });

        /**
         *  Programs and trainings:
         *      1. Trainings programs
         *      2. Trainings instances
         *
         */
        Route::prefix('trainings')->middleware('isAuthenticated')->group(function () {
            /** Preprocessing view */
            Route::get ('/home',                       [ProgramsAndTrainingsController::class, 'home'])->name('system.admin.trainings.home');
            /** CRUD Routes */
            Route::get ('/',                           [ProgramsAndTrainingsController::class, 'index'])->name('system.admin.trainings');
            Route::get ('/create',                     [ProgramsAndTrainingsController::class, 'create'])->name('system.admin.trainings.create');
            Route::post('/save',                       [ProgramsAndTrainingsController::class, 'save'])->name('system.admin.trainings.save');
            Route::get ('/preview/{id}',               [ProgramsAndTrainingsController::class, 'preview'])->name('system.admin.trainings.preview');
            Route::get ('/edit/{id}',                  [ProgramsAndTrainingsController::class, 'edit'])->name('system.admin.trainings.edit');
            Route::post('/update',                     [ProgramsAndTrainingsController::class, 'update'])->name('system.admin.trainings.update');
            Route::get ('/delete/{id}',                [ProgramsAndTrainingsController::class, 'delete'])->name('system.admin.trainings.delete');

            Route::prefix('instances')->middleware('isAuthenticated')->group(function () {
                Route::get ('/',                           [InstancesController::class, 'index'])->name('system.admin.trainings.instances');
                Route::get ('/create',                     [InstancesController::class, 'create'])->name('system.admin.trainings.instances.create');
                Route::post('/save',                       [InstancesController::class, 'save'])->name('system.admin.trainings.instances.save');
                Route::get ('/preview/{id}',               [InstancesController::class, 'preview'])->name('system.admin.trainings.instances.preview');
                Route::get ('/edit/{id}',                  [InstancesController::class, 'edit'])->name('system.admin.trainings.instances.edit');
                Route::post('/update',                     [InstancesController::class, 'update'])->name('system.admin.trainings.instances.update');
                Route::get ('/delete/{id}',                [InstancesController::class, 'delete'])->name('system.admin.trainings.instances.delete');
            });
        });

        /**
         *  Core section:
         *  1. Keywords
         */
        Route::prefix('core')->group(function () {
            /**
             *  FAQs section
             */
            Route::prefix('keywords')->group(function () {
                Route::get ('/',                                    [KeywordsController::class, 'index'])->name('system.admin.core.keywords');
                Route::get ('/preview-instances/{key}',             [KeywordsController::class, 'previewInstances'])->name('system.admin.core.keywords.preview-instances');
                Route::get ('/new-instance/{key}',                  [KeywordsController::class, 'newInstance'])->name('system.admin.core.keywords.new-instance');

                Route::post('/save-instance',                       [KeywordsController::class, 'saveInstance'])->name('system.admin.core.keywords.save-instance');
                Route::get ('/edit-instance/{id}',                  [KeywordsController::class, 'editInstance'])->name('system.admin.core.keywords.edit-instance');
                Route::post('/update-instance',                     [KeywordsController::class, 'updateInstance'])->name('system.admin.core.keywords.update-instance');
                Route::get ('/delete-instance/{id}',                [KeywordsController::class, 'deleteInstance'])->name('system.admin.core.keywords.delete-instance');
            });

            /**
             *  Settings:
             *      1. Countries
             *      2. Cities and municipalities
             *      3. Keywords !?
             */
            Route::prefix('settings')->middleware('isAuthenticated')->group(function () {
                /** Cities and municipalities */
                Route::prefix('cities')->group(function () {
                    Route::get ('/',                           [CitiesController::class, 'index'])->name('system.admin.core.settings.cities');
                    Route::get ('/create',                     [CitiesController::class, 'create'])->name('system.admin.core.settings.cities.create');
                    Route::post('/save',                       [CitiesController::class, 'save'])->name('system.admin.core.settings.cities.save');
                    Route::get ('/preview/{id}',               [CitiesController::class, 'preview'])->name('system.admin.core.settings.cities.preview');
                    Route::get ('/edit/{id}',                  [CitiesController::class, 'edit'])->name('system.admin.core.settings.cities.edit');
                    Route::post('/update',                     [CitiesController::class, 'update'])->name('system.admin.core.settings.cities.update');
                    Route::get ('/delete/{id}',                [CitiesController::class, 'delete'])->name('system.admin.core.settings.cities.delete');
                });
            });
        });

        /**
         *  Blog:: ToDo
         */
        Route::prefix('blog')->middleware('isAuthenticated')->group(function () {
            Route::get ('/',                               [AdminBlogController::class, 'index'])->name('system.admin.blog');
            Route::get ('/create',                         [AdminBlogController::class, 'create'])->name('system.admin.blog.create');
            Route::post('/save',                           [AdminBlogController::class, 'save'])->name('system.admin.blog.save');
            Route::get ('/preview/{id}',                   [AdminBlogController::class, 'preview'])->name('system.admin.blog.preview');
            Route::get ('/edit/{id}',                      [AdminBlogController::class, 'edit'])->name('system.admin.blog.edit');
            Route::post('/update',                         [AdminBlogController::class, 'update'])->name('system.admin.blog.update');
            Route::get ('/delete/{id}',                    [AdminBlogController::class, 'delete'])->name('system.admin.blog.delete');

            /*
             *  Work with images
             */
            Route::post('/add-to-gallery',                 [AdminBlogController::class, 'addToGallery'])->name('system.admin.blog.add-to-gallery');
            Route::get ('/delete-from-gallery/{id}',       [AdminBlogController::class, 'deleteFromGallery'])->name('system.admin.blog.delete-from-gallery');

            Route::get ('/edit-image/{id}/{what}',         [AdminBlogController::class, 'editImage'])->name('system.admin.blog.edit-image');
            Route::post('/update-image',                   [AdminBlogController::class, 'updateImage'])->name('system.admin.blog.update-image');
        });
    });
});
