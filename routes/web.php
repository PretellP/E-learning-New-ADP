<?php

use App\Http\Controllers\Admin\{
    AdminController,
    AdminCourseController,
    FolderController,
    AdminAnnouncementsController,
    AdminCertificationsController,
    AdminCompaniesController,
    AdminCourseCategoriesController,
    AdminCourseSectionsController,
    AdminDynamicQuestionsController,
    AdminDynamicAlternativeController,
    AdminEventsController,
    AdminExamsController,
    AdminFreeCoursesController,
    AdminRoomsController,
    AdminUsersController,
    AdminOwnerCompaniesController,
    AdminMiningUnitsController,
    AdminSectionChaptersController,
};
use App\Http\Controllers\Aula\Common\{
    AulaHomeController,
    AulaCourseController,
    AulaFolderController,
    AulaProfileController
};
use App\Http\Controllers\Aula\Participant\{
    AulaCoursePartController,
    QuizController,
    AulaEvaluationController,
    AulaOnlineLessonController,
    AulaFreeCourseController,
    AulaMyProgressController,
    AulaSurveysController
};
use App\Http\Controllers\Aula\Instructor\{
    AulaCourseInstController,
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);


Route::group(['middleware' => ['auth', 'check.valid.user']], function () {

    // RUTAS DE LA INTERFAZ ADMINISTRADOR ------------------ 

    Route::group(['middleware' => 'check.role:admin', 'prefix' => 'admin'], function () {

        // ---- ADMIN DASHBOARD PRINCIPAL VIEW --------
        Route::get('/inicio', [AdminController::class, 'index'])->name('admin.home.index');

        // --------------- USERS -------------------------

        Route::group(['prefix' => 'usuarios'], function () {

            Route::controller(AdminUsersController::class)->group(function () {

                Route::get('/', 'index')->name('admin.users.index');
                Route::get('/registrar/obtener-empresas', 'registerGetCompanies')->name('admin.users.registerGetCompanies');
                Route::get('/editar/{user}', 'edit')->name('admin.user.edit');
                Route::post('/registrar/validar-dni', 'registerValidateDni')->name('admin.users.validateDni');
                Route::post('/editar/validar-dni', 'editValidateDni')->name('admin.user.editValidateDni');
                Route::post('/registrar', 'store')->name('admin.user.store');
                Route::post('/actualizar/{user}', 'update')->name('admin.user.update');
                Route::delete('/eliminar/{user}', 'destroy')->name('admin.user.delete');
            });
        });

        // --------------  COMPANIES --------------------

        Route::group(['prefix' => 'empresas'], function () {

            Route::controller(AdminCompaniesController::class)->group(function () {

                Route::get('/', 'index')->name('admin.companies.index');
                Route::get('/editar/{company}', 'edit')->name('admin.companies.edit');
                Route::post('/registrar', 'store')->name('admin.companies.store');
                Route::post('/editar/validar-ruc', 'EditvalidateRuc')->name('admin.companies.validateRuc');
                Route::post('/actualizar/{company}', 'update')->name('admin.companies.update');
                Route::delete('/eliminar/{company}', 'destroy')->name('admin.companies.delete');
            });
        });

        // ---------------- OWNER COMPANIES ---------------

        Route::group(['prefix' => 'empresas-titulares'], function () {

            Route::controller(AdminOwnerCompaniesController::class)->group(function () {

                Route::get('/', 'index')->name('admin.ownerCompanies.index');
                Route::get('/editar/{company}', 'edit')->name('admin.ownerCompany.edit');
                Route::post('/validar-registro', 'registerValidate')->name('admin.ownerCompany.registerValidate');
                Route::post('/validar-edición', 'editValidate')->name('admin.ownerCompanies.editValidate');
                Route::post('/registrar', 'store')->name('admin.ownerCompanies.store');
                Route::post('/actualizar/{company}', 'update')->name('admin.ownerCompany.update');
                Route::delete('/eliminar/{company}', 'destroy')->name('admin.ownerCompany.delete');
            });
        });

        /* ---------------- MINING UNITS ----------------------*/

        Route::group(['prefix' => 'unidades-mineras'], function () {

            Route::controller(AdminMiningUnitsController::class)->group(function () {

                Route::get('/', 'index')->name('admin.miningUnits.index');
                Route::get('/editar/{miningUnit}', 'getDataEdit')->name('admin.miningUnits.getDataEdit');
                Route::post('/registrar', 'store')->name('admin.miningUnits.store');
                Route::post('/actualizar/{miningUnit}', 'update')->name('admin.mininUnits.update');
                Route::delete('/eliminar/{miningUnit}', 'destroy')->name('admin.miningUnits.delete');
            });
        });

        // --------------- ROOMS -------------------------

        Route::group(['prefix' => 'salas'], function () {

            Route::controller(AdminRoomsController::class)->group(function () {

                Route::get('/', 'index')->name('admin.rooms.index');
                Route::get('/editar/{room}', 'edit')->name('admin.room.edit');
                Route::post('/registrar', 'store')->name('admin.rooms.store');
                Route::post('/registrar/validar-nombre', 'registerValidateName')->name('admin.rooms.registerValidateName');
                Route::post('/editar/validar-nombre', 'editValidateName')->name('admin.rooms.editValidateName');
                Route::post('/actualizar/{room}', 'update')->name('admin.room.update');
                Route::delete('/eliminar/{room}', 'destroy')->name('admin.rooms.delete');
            });
        });

        // --------------- COURSES ----------------------

        Route::group(['prefix' => 'cursos'], function () {

            Route::controller(AdminCourseController::class)->group(function () {

                Route::get('/', 'index')->name('admin.courses.index');
                Route::get('/editar/{course}', 'edit')->name('admin.courses.edit');
                Route::get('/ver/{course}', 'show')->name('admin.courses.show');
                Route::post('/registrar', 'store')->name('admin.courses.store');
                Route::post('/actualizar/{course}', 'update')->name('admin.courses.update');
                Route::delete('/eliminar/{course}', 'destroy')->name('admin.courses.delete');
            });


            Route::group(['prefix' => 'carpetas'], function () {

                Route::controller(FolderController::class)->group(function () {

                    Route::get('/ver-carpeta/{folder}', 'show')->name('admin.courses.folder.view');
                    Route::post('/ccrear-carpeta/{course}', 'store')->name('folder.create');
                    Route::post('/subfolder/{folder}', 'storeSubfolder')->name('subfolder.create');
                    Route::patch('/{folder}/actualizar', 'update')->name('folder.update');
                    Route::delete('/{folder}/eliminar', 'destroy')->name('folder.destroy');

                    // ------FOLDER FILES --------------

                    Route::get('/{folder}/archivos', 'showFiles')->name('admin.files.index');
                    Route::get('/archivo/{file}/descargar', 'downloadFile')->name('admin.folders.file.download');
                    Route::post('/{folder}/añadirArchivo', 'storeFile')->name('admin.folders.file.store');
                    Route::delete('/archivo/{file}/eliminar', 'destroyFile')->name('admin.folders.file.destroy');
                });
            });
        });

        // --------------- FREE COURSES -----------------

        Route::group(['prefix' => 'cursos-libres'], function () {

            Route::controller(AdminFreeCoursesController::class)->group(function () {

                Route::get('/', 'index')->name('admin.freeCourses.index');
                Route::get('/obtener-categorias', 'getCategoriesRegisterCourse')->name('admin.freecourses.getCategoriesRegister');
                Route::get('/curso/{course}', 'show')->name('admin.freeCourses.courses.index');
                Route::get('/editar/{course}', 'edit')->name('admin.freecourse.courses.edit');
                Route::post('/registrar', 'store')->name('admin.freecourses.courses.store');
                Route::post('/actualizar/{course}', 'update')->name('admin.freeCourses.courses.update');
                Route::post('/curso/eliminar/{course}', 'destroy')->name('admin.freecourses.courses.delete');
            });

            Route::group(['prefix' => 'categorías'], function () {

                Route::controller(AdminCourseCategoriesController::class)->group(function () {

                    Route::get('/{category}', 'index')->name('admin.freeCourses.categories.index');
                    Route::get('/editar/{category}', 'edit')->name('admin.freecourses.categories.edit');
                    Route::post('/registrar', 'store')->name('admin.freeCourses.categories.store');
                    Route::post('/actualizar/{category}', 'update')->name('admin.freecourses.categories.update');
                    Route::post('/eliminar/{category}', 'destroy')->name('admin.freecourses.categories.delete');
                });
            });

            Route::group(['prefix' => 'secciones'], function () {

                Route::controller(AdminCourseSectionsController::class)->group(function () {

                    Route::get('/editar/{section}', 'edit')->name('admin.freeCourses.sections.edit');
                    Route::post('/curso/{course}/secciones/registrar', 'store')->name('admin.freeCourses.sections.store');
                    Route::post('/actualizar-orden/{section}', 'updateOrder')->name('admin.freecourses.sections.updateOrder');
                    Route::post('/actualizar/{section}', 'update')->name('admin.freeCourses.sections.update');
                    Route::post('/eliminar/{section}', 'destroy')->name('admin.freeCourses.sections.delete');
                });
            });

            Route::group(['prefix' => 'capítulos'], function () {

                Route::controller(AdminSectionChaptersController::class)->group(function () {

                    Route::get('/obtener-capítulos/{section}', 'getDataTable')->name('admin.freeCourses.chapters.getDataTable');
                    Route::get('/editar/{chapter}', 'edit')->name('admin.freeCourses.chapters.edit');
                    Route::get('/obtener-video/{chapter}', 'getVideoData')->name('admin.freeCourses.chapters.getVideoData');
                    Route::post('/sección/{section}/registrar-capítlo', 'store')->name('admin.freeCourses.chapters.store');
                    Route::post('/actualizar/{chapter}', 'update')->name('admin.freeCourses.chapters.update');
                    Route::post('/capítulos/eliminar/{chapter}', 'destroy')->name('admin.freeCourses.chapters.delete');
                });
            });
        });


        // -------------------- EXAMS ---------------------

        Route::group(['prefix' => 'examenes'], function () {

            Route::controller(AdminExamsController::class)->group(function () {

                Route::get('/', 'index')->name('admin.exams.index');
                Route::get('/editar/{exam}', 'edit')->name('admin.exams.edit');
                Route::post('/registrar', 'store')->name('admin.exams.store');
                Route::post('/actualizar/{exam}', 'update')->name('admin.exams.update');
                Route::post('/eliminar/{exam}', 'destroy')->name('admin.exams.destroy');
            });

            Route::controller(AdminDynamicQuestionsController::class)->group(function () {

                Route::get('/ver/{exam}', 'index')->name('admin.exams.showQuestions');
                Route::get('/ver-enunciado/{question}', 'show')->name('admin.exams.questions.show');
                Route::get('/obtener-tipo-de-enunciado', 'getQuestionType')->name('admin.exams.questions.getType');
                Route::post('/registrar-enunciado/{exam}', 'store')->name('admin.exams.questions.store');
                Route::post('/actualizar-enunciado/{question}', 'update')->name('admin.exams.questions.update');
                Route::post('/eliminar-enunciado/{question}', 'destroy')->name('admin.exams.questions.destroy');
            });

            Route::controller(AdminDynamicAlternativeController::class)->group(function () {

                Route::post('/alternativa/{alternative}/eliminar', 'destroy')->name('admin.exams.alternatives.destroy');
                Route::post('/alternativa/{alternative}/eliminar-archivo', 'destroyFile')->name('admin.exams.alternatives.deleteFile');
            });
        });



        // --------------- EVENTS ------------------------

        Route::group(['prefix' => 'eventos'], function () {

            Route::controller(AdminEventsController::class)->group(function () {

                Route::get('/', 'index')->name('admin.events.index');
                Route::get('/ver/{event}', 'show')->name('admin.events.show');
                Route::get('/crear/obtener-data', 'create')->name('admin.events.create');
                Route::get('/editar/{event}/obtener-data', 'edit')->name('admin.events.edit');
                Route::get('/obtener-usuarios/{event}', 'getUsersTable')->name('admin.events.getUsersTable');
                Route::post('/registrar', 'store')->name('admin.events.store');
                Route::post('/actualizar/{event}', 'update')->name('admin.events.update');
                Route::delete('/eliminar/{event}', 'destroy')->name('admin.events.destroy');
            });

            Route::controller(AdminCertificationsController::class)->group(function () {

                Route::post('/registrar-participantes/{event}', 'store')->name('admin.events.certifications.store');
                Route::post('/actualizar-asistencia/{certification}', 'updateAssist')->name('admin.events.certification.updateAssist');
                Route::delete('/eliminar-certificado/{certification}', 'destroy')->name('admin.events.certifications.destroy');
               
            });             
        });


        // --------------- ANNOUNCEMENTS ----------------

        Route::get('/anuncios', [AdminAnnouncementsController::class, 'index'])->name('admin.announcements.index');
    });


    // -------  RUTAS DE LA INTERFAZ AULA ---------------

    Route::group(['middleware' => 'aula', 'prefix' => 'aula'], function () {

        Route::get('/inicio', [AulaHomeController::class, 'index'])->name('aula.index');
        Route::get('/perfil', [AulaProfileController::class, 'index'])->name('aula.profile.index');

        Route::get('/e-learning', [AulaCourseController::class, 'index'])->name('aula.course.index');

        Route::group(['middleware' => 'check.role:participants'], function () {

            Route::get('/e-learning/Alumno/{course}', [AulaCoursePartController::class, 'show'])->name('aula.course.participant.show');
            Route::get('/e-learning/Alumno/{course}/evaluaciones', [AulaEvaluationController::class, 'index'])->name('aula.course.evaluation.index');
            Route::get('/e-learning/Alumno/{certification}/pregunta/{num_question}', [QuizController::class, 'show'])->name('aula.course.quiz.show');
            Route::get('/e-learning/Alumno/{course}/curso-online', [AulaOnlineLessonController::class, 'index'])->name('aula.course.onlinelesson.index');
            Route::get('/e-learning/Alumno/clase-online/{event}', [AulaOnlineLessonController::class, 'show'])->name('aula.course.onlinelesson.show');


            Route::get('/cursos-libres', [AulaFreeCourseController::class, 'index'])->name('aula.freecourse.index');
            Route::get('/cursos-libres/categoria/{category}', [AulaFreeCourseController::class, 'showCategory'])->name('aula.freecourse.showCategory');
            Route::get('/cursos-libres/curso/{course}/{current_chapter}', [AulaFreeCourseController::class, 'showChapter'])->name('aula.freecourse.showChapter');
            Route::post('/cursos-libres/iniciar/{course}', [AulaFreeCourseController::class, 'start'])->name('aula.freecourse.start');
            Route::post('/cursos-libres/AjaxSavetime/{current_chapter}', [AulaFreeCourseController::class, 'updateProgressTime'])->name('aula.freecourse.saveTime');
            Route::patch('/cursos-libres/actualizar/{current_chapter}/{new_chapter}/{course}', [AulaFreeCourseController::class, 'updateChapter'])->name('aula.freecourse.update');


            Route::get('/mi-progreso', [AulaMyProgressController::class, 'index'])->name('aula.myprogress.index');

            Route::get('/encuestas', [AulaSurveysController::class, 'index'])->name('aula.surveys.index');
            Route::get('/encuesta/{user_survey}/{num_question}', [AulaSurveysController::class, 'show'])->name('aula.surveys.show');
            Route::post('/encuestas/iniciar/{userSurvey}', [AulaSurveysController::class, 'start'])->name('aula.surveys.start');
            Route::patch('/encuestas/actualizar/{user_survey}/{group_id}', [AulaSurveysController::class, 'update'])->name('aula.surveys.update');
        });

        Route::group(['middleware' => 'check.role:instructor'], function () {
            Route::get('/e-learning/Instructor/{course}', [AulaCourseInstController::class, 'show'])->name('aula.course.instructor.show');
        });


        Route::get('/e-learning/{course}/carpetas', [AulaFolderController::class, 'index'])->name('aula.course.folder.index');
        Route::get('/e-learning/{course}/carpeta/{folder}', [AulaFolderController::class, 'show'])->name('aula.course.folder.show');

        Route::get('/e-learning/Carpeta/descargar/{file}', [AulaFolderController::class, 'downloadFile'])->name('aula.file.download');

        Route::get('/e-learning/ajax-certification/{certification}', [AulaEvaluationController::class, 'getAjaxCertification'])->name('aula.course.ajax.certification');

        Route::post('/e-learning/{certification}', [QuizController::class, 'start'])->name('aula.course.quiz.start');
        Route::patch('/e-learning/{certification}/{exam}/pregunta/{num_question}/{key}/{evaluation}', [QuizController::class, 'update'])->name('aula.course.quiz.update');
    });
});
