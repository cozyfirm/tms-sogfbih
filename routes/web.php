<?php

use App\Http\Controllers\Admin\Core\CitiesController;
use App\Http\Controllers\Admin\Core\FileUploadController;
use App\Http\Controllers\Admin\Core\KeywordsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Other\Analysis\AnalysisController;
use App\Http\Controllers\Admin\Other\Analysis\EvaluationsController as AnalysisEvaluationController;
use App\Http\Controllers\Admin\Other\BodiesController;
use App\Http\Controllers\Admin\Other\FAQsController;
use App\Http\Controllers\Admin\Other\InternalEvents\InternalEventsController;
use App\Http\Controllers\Admin\Trainings\AuthorsController;
use App\Http\Controllers\Admin\Trainings\InstancesController;
use App\Http\Controllers\Admin\Trainings\ProgramsAndTrainingsController;
use App\Http\Controllers\Admin\Trainings\Submodules\EvaluationsController as TrainingsEvaluationsController;
use App\Http\Controllers\Admin\Trainings\Submodules\Instances\ApplicationsController as InstancesApplicationsController;
use App\Http\Controllers\Admin\Trainings\Submodules\Instances\EvaluationsController as InstancesEvaluationsController;
use App\Http\Controllers\Admin\Trainings\Submodules\Instances\EventsController;
use App\Http\Controllers\Admin\Trainings\Submodules\Instances\LocationsController as InstanceLocationsController;
use App\Http\Controllers\Admin\Trainings\Submodules\Instances\PresenceController as InstancesPresenceController;
use App\Http\Controllers\Admin\Trainings\Submodules\Instances\TrainersController as InstanceTrainersController;
use App\Http\Controllers\Admin\Trainings\Submodules\LocationsController;
use App\Http\Controllers\Admin\Trainings\Submodules\TrainersController;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Common\NotificationsController;
use App\Http\Controllers\UserData\DownloadController as UserDownloadController;
use App\Http\Controllers\UserData\HomeController as UserDataHomeController;
use App\Http\Controllers\UserData\MyProfileController;
use App\Http\Controllers\UserData\Trainings\ApplicationsController as UserDataApplicationsController;
use App\Http\Controllers\UserData\Trainings\EvaluationsController as UserDataEvaluationsController;
use App\Http\Controllers\UserData\Trainings\TrainingsController as UserTrainingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    /**
     *  Public part of Web App
     */
    Route::get ('/',                              [AuthController::class, 'auth'])->name('public.home');

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

            /** Save author */
            Route::post('/save-author',                [ProgramsAndTrainingsController::class, 'saveAuthor'])->name('system.admin.trainings.save-author');
            Route::post('/fetch-author',               [ProgramsAndTrainingsController::class, 'fetchAuthor'])->name('system.admin.trainings.fetch-author');

            /** Save file */
            Route::post('/save-files',                 [ProgramsAndTrainingsController::class, 'saveFiles'])->name('system.admin.trainings.save-files');
            Route::get ('/download-file/{id}',         [ProgramsAndTrainingsController::class, 'downloadFile'])->name('system.admin.trainings.download-file');
            Route::get ('/remove-file/{id}',           [ProgramsAndTrainingsController::class, 'removeFile'])->name('system.admin.trainings.remove-file');

            /**
             *  Authors
             */
            Route::prefix('authors')->middleware('isAuthenticated')->group(function () {
                Route::get ('/',                           [AuthorsController::class, 'index'])->name('system.admin.trainings.authors');
                Route::get ('/preview/{id}',               [AuthorsController::class, 'preview'])->name('system.admin.trainings.authors.preview');
                Route::get ('/edit/{id}',                  [AuthorsController::class, 'edit'])->name('system.admin.trainings.authors.edit');
                Route::post('/update',                     [AuthorsController::class, 'update'])->name('system.admin.trainings.authors.update');
                Route::get ('/delete/{id}',                [AuthorsController::class, 'delete'])->name('system.admin.trainings.authors.delete');
            });

            /**
             *  Training instances
             */
            Route::prefix('instances')->middleware('isAuthenticated')->group(function () {
                Route::get ('/',                           [InstancesController::class, 'index'])->name('system.admin.trainings.instances');
                Route::get ('/create',                     [InstancesController::class, 'create'])->name('system.admin.trainings.instances.create');
                Route::post('/save',                       [InstancesController::class, 'save'])->name('system.admin.trainings.instances.save');
                Route::get ('/preview/{id}',               [InstancesController::class, 'preview'])->name('system.admin.trainings.instances.preview');
                Route::get ('/edit/{id}',                  [InstancesController::class, 'edit'])->name('system.admin.trainings.instances.edit');
                Route::post('/update',                     [InstancesController::class, 'update'])->name('system.admin.trainings.instances.update');
                Route::get ('/delete/{id}',                [InstancesController::class, 'delete'])->name('system.admin.trainings.instances.delete');

                Route::post('/save-files',                 [InstancesController::class, 'saveFiles'])->name('system.admin.trainings.instances.save-files');
                Route::get ('/download-file/{id}',         [InstancesController::class, 'downloadFile'])->name('system.admin.trainings.instances.download-file');
                Route::get ('/remove-file/{id}',           [InstancesController::class, 'removeFile'])->name('system.admin.trainings.instances.remove-file');

                Route::prefix('photo-gallery')->group(function () {
                    Route::get ('/preview/{id}',                       [InstancesController::class, 'photoGallery'])->name('system.admin.trainings.instances.photo-gallery.preview');
                });

                /**
                 *  Additional APIs
                 */
                Route::prefix('apis')->group(function () {
                    /**
                     *  Trainer APIs
                     */
                    Route::prefix('trainers')->group(function () {
                        Route::post('/save',                            [InstanceTrainersController::class, 'save'])->name('system.admin.trainings.instances.apis.trainers.save');
                        Route::post('/fetch',                           [InstanceTrainersController::class, 'fetch'])->name('system.admin.trainings.instances.apis.trainers.fetch');
                        Route::post('/delete',                          [InstanceTrainersController::class, 'delete'])->name('system.admin.trainings.instances.apis.trainers.delete');
                    });

                    /**
                     *  Events APIs
                     */
                    Route::prefix('events')->group(function () {
                        Route::post('/save',                            [EventsController::class, 'save'])->name('system.admin.trainings.instances.apis.events.save');
                        Route::post('/fetch',                           [EventsController::class, 'fetch'])->name('system.admin.trainings.instances.apis.events.fetch');
                        Route::post('/delete',                          [EventsController::class, 'delete'])->name('system.admin.trainings.instances.apis.events.delete');
                    });

                    /**
                     *  Location APIs
                     */
                    Route::prefix('locations')->group(function () {
                        Route::post('/fetch',                           [InstanceLocationsController::class, 'fetch'])->name('system.admin.trainings.instances.apis.locations.fetch');
                    });
                });

                /**
                 *  Other submodules
                 */
                Route::prefix('submodules')->group(function () {
                    /**
                     *  Reports
                     */
                    Route::prefix('reports')->group(function () {
                        Route::get ('/edit-report/{instance_id}',           [InstancesController::class, 'editReport'])->name('system.admin.trainings.instances.submodules.reports.edit-report');
                        Route::post('/update-report',                       [InstancesController::class, 'updateReport'])->name('system.admin.trainings.instances.submodules.reports.update-report');
                        Route::get ('/download-report/{instance_id}',       [InstancesController::class, 'downloadReport'])->name('system.admin.trainings.instances.submodules.reports.download-report');
                    });

                    /**
                     *  Evaluations
                     */
                    Route::prefix('evaluations')->group(function () {
                        Route::get ('/preview/{instance_id}',               [InstancesEvaluationsController::class, 'preview'])->name('system.admin.trainings.instances.submodules.evaluations.preview');
                        Route::get ('/add-option/{instance_id}',            [InstancesEvaluationsController::class, 'addOption'])->name('system.admin.trainings.instances.submodules.evaluations.add-option');
                        Route::post('/save-option',                         [InstancesEvaluationsController::class, 'saveOption'])->name('system.admin.trainings.instances.submodules.evaluations.save-option');
                        Route::get ('/preview-option/{id}',                 [InstancesEvaluationsController::class, 'previewOption'])->name('system.admin.trainings.instances.submodules.evaluations.preview-option');
                        Route::get ('/edit-option/{id}',                    [InstancesEvaluationsController::class, 'editOption'])->name('system.admin.trainings.instances.submodules.evaluations.edit-option');
                        Route::post('/update-option',                       [InstancesEvaluationsController::class, 'updateOption'])->name('system.admin.trainings.instances.submodules.evaluations.update-option');
                        Route::get ('/delete-option/{id}',                  [InstancesEvaluationsController::class, 'deleteOption'])->name('system.admin.trainings.instances.submodules.evaluations.delete-option');

                        /** Lock evaluation */
                        Route::get ('/lock/{instance_id}',                  [InstancesEvaluationsController::class, 'lock'])->name('system.admin.trainings.instances.submodules.evaluations.lock');
                    });

                    /**
                     *  Applications
                     */
                    Route::prefix('applications')->group(function () {
                        Route::get ('/preview/{instance_id}',                [InstancesApplicationsController::class, 'index'])->name('system.admin.trainings.instances.submodules.applications');
                        Route::get ('/preview-app/{instance_id}',            [InstancesApplicationsController::class, 'previewApp'])->name('system.admin.trainings.instances.submodules.applications.preview');
                        Route::post('/update-status',                        [InstancesApplicationsController::class, 'updateStatus'])->name('system.admin.trainings.instances.submodules.applications.update-status');
                        Route::get ('/download-certificate/{id}',            [InstancesApplicationsController::class, 'downloadCertificate'])->name('system.admin.trainings.instances.submodules.applications.download-certificate');
                    });

                    /**
                     *  Presence
                     */
                    Route::prefix('presence')->group(function () {
                        Route::get ('/preview/{instance_id}',                [InstancesPresenceController::class, 'index'])->name('system.admin.trainings.instances.submodules.presence');
                        Route::post('/update-presence',                      [InstancesPresenceController::class, 'updatePresence'])->name('system.admin.trainings.instances.submodules.presence.update-presence');
                    });
                });
            });

            /**
             *  All other submodules
             */
            Route::prefix('submodules')->group(function () {
                /**
                 *  Trainer submodules
                 */
                Route::prefix('trainers')->middleware('isAuthenticated')->group(function () {
                    Route::get ('/',                           [TrainersController::class, 'index'])->name('system.admin.trainings.submodules.trainers');
                });

                /**
                 *  Locations
                 */
                Route::prefix('locations')->group(function () {
                    Route::get ('/',                           [LocationsController::class, 'index'])->name('system.admin.trainings.submodules.locations');
                    Route::get ('/create',                     [LocationsController::class, 'create'])->name('system.admin.trainings.submodules.locations.create');
                    Route::post('/save',                       [LocationsController::class, 'save'])->name('system.admin.trainings.submodules.locations.save');
                    Route::get ('/preview/{id}',               [LocationsController::class, 'preview'])->name('system.admin.trainings.submodules.locations.preview');
                    Route::get ('/edit/{id}',                  [LocationsController::class, 'edit'])->name('system.admin.trainings.submodules.locations.edit');
                    Route::post('/update',                     [LocationsController::class, 'update'])->name('system.admin.trainings.submodules.locations.update');
                    Route::get ('/delete/{id}',                [LocationsController::class, 'delete'])->name('system.admin.trainings.submodules.locations.delete');
                });

                /**
                 *  Evaluations
                 */
                Route::prefix('evaluations')->middleware('isAuthenticated')->group(function () {
                    Route::get ('/',                           [TrainingsEvaluationsController::class, 'index'])->name('system.admin.trainings.submodules.evaluations');
                });
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

            /**
             *  File uploads
             */
            Route::prefix('file-upload')->group(function () {
                Route::post('/',                               [FileUploadController::class, 'upload'])->name('system.admin.core.file-upload');
            });
        });

        /**
         *  Other:
         *      1. Analysis
         *      2. Internal events
         *      3. Civil bodies
         */

        Route::prefix('core')->group(function () {
            /** Analysis */
            Route::prefix('analysis')->middleware('isAuthenticated')->group(function () {
                Route::get('/',                           [AnalysisController::class, 'index'])->name('system.admin.other.analysis');
                Route::get('/create',                     [AnalysisController::class, 'create'])->name('system.admin.other.analysis.create');
                Route::post('/save',                      [AnalysisController::class, 'save'])->name('system.admin.other.analysis.save');
                Route::get('/preview/{id}',               [AnalysisController::class, 'preview'])->name('system.admin.other.analysis.preview');
                Route::get('/edit/{id}',                  [AnalysisController::class, 'edit'])->name('system.admin.other.analysis.edit');
                Route::post('/update',                    [AnalysisController::class, 'update'])->name('system.admin.other.analysis.update');
                Route::get('/delete/{id}',                [AnalysisController::class, 'delete'])->name('system.admin.other.analysis.delete');

                /**
                 *  Submodules
                 */
                Route::prefix('submodules')->group(function () {
                    /** Evaluations ~ Submissions */
                    Route::prefix('evaluations')->group(function () {
                        Route::get ('/preview/{analysis_id}',               [AnalysisEvaluationController::class, 'preview'])->name('system.admin.other.analysis.submodules.evaluations.preview');
                        Route::get ('/add-option/{analysis_id}',            [AnalysisEvaluationController::class, 'addOption'])->name('system.admin.other.analysis.submodules.evaluations.add-option');
                        Route::post('/save-option',                         [AnalysisEvaluationController::class, 'saveOption'])->name('system.admin.other.analysis.submodules.evaluations.save-option');
                        Route::get ('/preview-option/{id}',                 [AnalysisEvaluationController::class, 'previewOption'])->name('system.admin.other.analysis.submodules.evaluations.preview-option');
                        Route::get ('/edit-option/{id}',                    [AnalysisEvaluationController::class, 'editOption'])->name('system.admin.other.analysis.submodules.evaluations.edit-option');
                        Route::post('/update-option',                       [AnalysisEvaluationController::class, 'updateOption'])->name('system.admin.other.analysis.submodules.evaluations.update-option');
                        Route::get ('/delete-option/{id}',                  [AnalysisEvaluationController::class, 'deleteOption'])->name('system.admin.other.analysis.submodules.evaluations.delete-option');

                        /** Lock evaluation */
                        Route::get ('/lock/{analysis_id}',                  [AnalysisEvaluationController::class, 'lock'])->name('system.admin.other.analysis.submodules.evaluations.lock');
                    });
                });
            });

            /** Internal events */
            Route::prefix('internal-events')->middleware('isAuthenticated')->group(function () {
                Route::get('/',                           [InternalEventsController::class, 'index'])->name('system.admin.other.internal-events');
                Route::get('/create',                     [InternalEventsController::class, 'create'])->name('system.admin.other.internal-events.create');
                Route::post('/save',                      [InternalEventsController::class, 'save'])->name('system.admin.other.internal-events.save');
                Route::get('/preview/{id}',               [InternalEventsController::class, 'preview'])->name('system.admin.other.internal-events.preview');
                Route::get('/edit/{id}',                  [InternalEventsController::class, 'edit'])->name('system.admin.other.internal-events.edit');
                Route::post('/update',                    [InternalEventsController::class, 'update'])->name('system.admin.other.internal-events.update');
                Route::get('/delete/{id}',                [InternalEventsController::class, 'delete'])->name('system.admin.other.internal-events.delete');

                /* File routes */
                Route::post('/save-files',                [InternalEventsController::class, 'saveFiles'])->name('system.admin.other.internal-events.save-files');
                Route::get ('/download-file/{id}',        [InternalEventsController::class, 'downloadFile'])->name('system.admin.other.internal-events.download-file');
                Route::get ('/remove-file/{id}',          [InternalEventsController::class, 'removeFile'])->name('system.admin.other.internal-events.remove-file');
            });

            /** Bodies */
            Route::prefix('bodies')->middleware('isAuthenticated')->group(function () {
                Route::get('/',                           [BodiesController::class, 'index'])->name('system.admin.other.bodies');
                Route::get('/create',                     [BodiesController::class, 'create'])->name('system.admin.other.bodies.create');
                Route::post('/save',                      [BodiesController::class, 'save'])->name('system.admin.other.bodies.save');
                Route::get('/preview/{id}',               [BodiesController::class, 'preview'])->name('system.admin.other.bodies.preview');
                Route::get('/edit/{id}',                  [BodiesController::class, 'edit'])->name('system.admin.other.bodies.edit');
                Route::post('/update',                    [BodiesController::class, 'update'])->name('system.admin.other.bodies.update');
                Route::get('/delete/{id}',                [BodiesController::class, 'delete'])->name('system.admin.other.bodies.delete');

                /* File routes */
                Route::post('/save-files',                [BodiesController::class, 'saveFiles'])->name('system.admin.other.bodies.save-files');
                Route::get ('/download-file/{id}',        [BodiesController::class, 'downloadFile'])->name('system.admin.other.bodies.download-file');
                Route::get ('/remove-file/{id}',          [BodiesController::class, 'removeFile'])->name('system.admin.other.bodies.remove-file');
            });
        });
    });

    /**
     *  User routes
     */
    Route::prefix('user-data')->middleware('isAuthenticated')->group(function () {
        Route::get('/dashboard',                 [UserDataHomeController::class, 'dashboard'])->name('system.user-data.dashboard');

        /**
         *  My profile
         */
        Route::prefix('my-profile')->middleware('isAuthenticated')->group(function () {
            Route::get ('/',                      [MyProfileController::class, 'myProfile'])->name('system.user-data.my-profile');
            Route::get ('/edit',                  [MyProfileController::class, 'edit'])->name('system.user-data.my-profile.edit');
            Route::post('/update',                [MyProfileController::class, 'update'])->name('system.user-data.my-profile.update');

            /**
             *  Education info
             */
            Route::get ('/education',             [MyProfileController::class, 'education'])->name('system.user-data.my-profile.education');
            Route::post('/education-update',      [MyProfileController::class, 'educationUpdate'])->name('system.user-data.my-profile.education.update');
        });

        /**
         *  Trainings
         */
        Route::prefix('trainings')->middleware('isAuthenticated')->group(function () {
            Route::get ('/',                      [UserTrainingsController::class, 'index'])->name('system.user-data.trainings');
            Route::get ('/preview/{id}',          [UserTrainingsController::class, 'preview'])->name('system.user-data.trainings.preview');

            /**
             *  Additional APIs
             */
            Route::prefix('apis')->group(function () {
                /**
                 *  Locations info
                 */
                Route::prefix('locations')->group(function () {
                    Route::post('/fetch',                           [InstanceLocationsController::class, 'fetch'])->name('system.user-data.trainings.apis.locations.fetch');
                });

                /**
                 *  Trainings applications
                 */
                Route::prefix('application')->group(function () {
                    Route::post('/sign-up',                                   [UserDataApplicationsController::class, 'signUp'])->name('system.user-data.trainings.apis.applications.sign-up');
                    Route::get ('/download-certificate/{application_id}',     [UserDataApplicationsController::class, 'downloadCertificate'])->name('system.user-data.trainings.apis.applications.download-certificate');
                });

                /**
                 *  Evaluations submit
                 */
                Route::prefix('evaluations')->group(function () {
                    Route::post('/submit',                                    [UserDataEvaluationsController::class, 'submit'])->name('system.user-data.trainings.apis.evaluations.submit');
                    Route::post('/save',                                      [UserDataEvaluationsController::class, 'save'])->name('system.user-data.trainings.apis.evaluations.save');
                });
            });

            /**
             *  Additional training data visible to user
             */
            Route::prefix('additional-data')->group(function () {
                /** Photo Gallery */
                Route::prefix('photo-gallery')->group(function () {
                    Route::get ('/preview/{instance_id}',                      [UserTrainingsController::class, 'photoGallery'])->name('system.user-data.trainings.additional-data.photo-gallery');
                });
            });
        });

        /**
         *  Download files
         */
        Route::prefix('download')->group(function () {
            Route::get ('/download-file/{id}',                                 [UserDownloadController::class, 'downloadInstanceFile'])->name('system.user-data.download.download-instance-file');
        });
    });

    /**
     *  Common routes used by everyone
     */

    Route::prefix('common-routes')->middleware('isAuthenticated')->group(function () {
        /**
         *  Routes for notifications
         */
        Route::prefix('notifications')->middleware('isAuthenticated')->group(function () {
            Route::post('/reset',                           [NotificationsController::class, 'reset'])->name('system.common-routes.notifications.reset');
            Route::post('/mark-as-read',                    [NotificationsController::class, 'markAsRead'])->name('system.common-routes.notifications.mark-as-read');
        });
    });
});
