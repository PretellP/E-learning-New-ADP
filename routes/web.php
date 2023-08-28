<?php

use App\Http\Controllers\{
    HomeController
};
use App\Http\Controllers\Admin\{
    AdminController,
    AdminCourseController,
    FolderController,
    DocumentController,
    AdminAnnouncementsController,
    AdminCompaniesController,
    AdminEvaluationsController,
    AdminEventsController,
    AdminFreeCoursesController,
    AdminRoomsController,
    AdminUsersController
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
use Illuminate\Support\Facades\Route;



Route::get('/', function(){
    return redirect()->route('login');
});

Auth::routes(['register' => false]);


Route::group(['middleware' => 'auth'], function(){

// RUTAS DE LA INTERFAZ ADMINISTRADOR ------------------ 
    
    Route::group(['middleware' => 'check.role:admin'], function(){
        // ---- ADMIN DASHBOARD PRINCIPAL VIEW --------
        Route::get('/admin/inicio', [AdminController::class, 'index'])->name('admin.home.index');

        // --------------- USERS -------------------------

        Route::get('/admin/usuarios', [AdminUsersController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/usuarios/registrar/obtener-empresas', [AdminUsersController::class, 'registerGetCompanies'])->name('admin.users.registerGetCompanies');
        Route::get('/admin/usuarios/editar/{user}', [AdminUsersController::class, 'edit'])->name('admin.user.edit');
        Route::post('/admin/usuarios/registrar/validar-dni', [AdminUsersController::class, 'registerValidateDni'])->name('admin.users.validateDni');
        Route::post('/admin/usuarios/editar/validar-dni', [AdminUsersController::class, 'editValidateDni'])->name('admin.user.editValidateDni');
        Route::post('/admin/usuarios/registrar', [AdminUsersController::class, 'store'])->name('admin.user.store');
        Route::post('/admin/usuarios/actualizar/{user}', [AdminUsersController::class, 'update'])->name('admin.user.update');
        Route::delete('/admin/usuarios/eliminar/{user}', [AdminUsersController::class, 'destroy'])->name('admin.user.delete');


        // ---------------  COMPANIES --------------------

        Route::get('/admin/empresas', [AdminCompaniesController::class, 'index'])->name('admin.companies.index');
        Route::get('/admin/empresas/editar/{company}', [AdminCompaniesController::class, 'edit'])->name('admin.companies.edit');
        Route::post('/admin/empresas/registrar', [AdminCompaniesController::class, 'store'])->name('admin.companies.store');
        Route::post('/admin/empresas/editar/validar-ruc', [AdminCompaniesController::class, 'EditvalidateRuc'])->name('admin.companies.validateRuc');
        Route::post('/admin/empresas/actualizar/{company}', [AdminCompaniesController::class, 'update'])->name('admin.companies.update');
        Route::delete('/admin/empresas/eliminar/{company}', [AdminCompaniesController::class, 'destroy'])->name('admin.companies.delete');

        // --------------- ROOMS -------------------------

        Route::get('/admin/salas', [AdminRoomsController::class, 'index'])->name('admin.rooms.index');
        Route::get('/admin/salas/editar/{room}', [AdminRoomsController::class, 'edit'])->name('admin.room.edit');
        Route::post('/admin/salas/registrar', [AdminRoomsController::class, 'store'])->name('admin.rooms.store');
        Route::post('/admin/salas/registrar/validar-nombre', [AdminRoomsController::class, 'registerValidateName'])->name('admin.rooms.registerValidateName');
        Route::post('/admin/salas/editar/validar-nombre', [AdminRoomsController::class, 'editValidateName'])->name('admin.rooms.editValidateName');
        Route::post('/admin/salas/actualizar/{room}', [AdminRoomsController::class, 'update'])->name('admin.room.update');
        Route::delete('/admin/salas/eliminar/{room}', [AdminRoomsController::class, 'destroy'])->name('admin.rooms.delete');


        // --------------- COURSES ----------------------



        // --------------- FREE COURSES -----------------

        Route::get('/admin/free-courses', [AdminFreeCoursesController::class, 'index'])->name('admin.freeCourses.index');

        // --------------- EVALUATIONS -------------------

        Route::get('/admin/evaluaciones', [AdminEvaluationsController::class, 'index'])->name('admin.evaluations.index');

        // --------------- EVENTS ------------------------

        Route::get('/admin/eventos', [AdminEventsController::class, 'index'])->name('admin.events.index');

         // --------------- ANNOUNCEMENTS ----------------

         Route::get('/admin/anuncios', [AdminAnnouncementsController::class, 'index'])->name('admin.announcements.index');


        // ----- ALL COURSES VIEW LIST  ---------------------
        Route::get('/admin/Cursos/', [AdminCourseController::class, 'index'])->name('admin.course.index');
        // ----- COURSE FOLDERS VIEWS-----------------------
        Route::get('/admin/Cursos/{course}', [AdminCourseController::class, 'show'])->name('admin.course.show');
        // ------ folder view  ------------------------------
        Route::get('/admin/Cursos/{course}/Carpeta/{folder}', [FolderController::class, 'show'])->name('admin.course.folder.view');
        Route::get('/admin/Cursos/Carpeta/descargar/{file}', [DocumentController::class, 'download'])->name('file.download');
        Route::post('/admin/Cursos/Crear/{course}', [FolderController::class, 'create'])->name('folder.create');
        Route::post('/admin/Cursos/Crear/subfolder/{folder}', [FolderController::class, 'createSubfolder'])->name('subfolder.create');
        Route::post('/admin/Cursos/Carpeta/{folder}/añadirArchivo', [DocumentController::class, 'create'])->name('file.create');
        Route::patch('/admin/Cursos/Carpeta/{folder}/actualizar', [FolderController::class, 'update'])->name('folder.update');
        Route::delete('/admin/Cursos/Carpeta/archivo/{file}/eliminar', [DocumentController::class, 'destroy'])->name('file.destroy');
        Route::delete('/admin/Cursos/Carpeta/{folder}/eliminar', [FolderController::class, 'destroy'])->name('folder.destroy');
        
    });


// -------  RUTAS DE LA INTERFAZ AULA ---------------

    Route::group(['middleware' => 'aula'], function(){
        Route::get('/aula/inicio', [AulaHomeController::class, 'index'])->name('aula.index');
        Route::get('/aula/perfil', [AulaProfileController::class, 'index'])->name('aula.profile.index');
        Route::get('/aula/e-learning', [AulaCourseController::class, 'index'])->name('aula.course.index');

        Route::group(['middleware' => 'check.role:participants'], function(){
            Route::get('/aula/e-learning/Alumno/{course}', [AulaCoursePartController::class, 'show'])->name('aula.course.participant.show');
            Route::get('/aula/e-learning/Alumno/{course}/evaluaciones', [AulaEvaluationController::class, 'index'])->name('aula.course.evaluation.index');
            Route::get('/aula/e-learning/Alumno/{certification}/pregunta/{num_question}', [QuizController::class, 'show'])->name('aula.course.quiz.show');
            Route::get('/aula/e-learning/Alumno/{course}/curso-online', [AulaOnlineLessonController::class, 'index'])->name('aula.course.onlinelesson.index');
            Route::get('/aula/e-learning/Alumno/clase-online/{event}', [AulaOnlineLessonController::class, 'show'])->name('aula.course.onlinelesson.show');


            Route::get('/aula/cursos-libres', [AulaFreeCourseController::class, 'index'])->name('aula.freecourse.index');
            Route::get('/aula/cursos-libres/categoria/{category}', [AulaFreeCourseController::class, 'showCategory'])->name('aula.freecourse.showCategory');
            Route::get('/aula/cursos-libres/curso/{course}/{current_chapter}', [AulaFreeCourseController::class, 'showChapter'])->name('aula.freecourse.showChapter');
            Route::post('/aula/cursos-libres/iniciar/{course}', [AulaFreeCourseController::class, 'start'])->name('aula.freecourse.start');
            Route::post('/aula/cursos-libres/AjaxSavetime/{current_chapter}', [AulaFreeCourseController::class, 'updateProgressTime'])->name('aula.freecourse.saveTime');
            Route::patch('/aula/cursos-libres/actualizar/{current_chapter}/{new_chapter}/{course}', [AulaFreeCourseController::class, 'updateChapter'])->name('aula.freecourse.update');


            Route::get('/aula/mi-progreso', [AulaMyProgressController::class, 'index'])->name('aula.myprogress.index');

            Route::get('/aula/encuestas', [AulaSurveysController::class, 'index'])->name('aula.surveys.index');
            Route::get('/aula/encuesta/{user_survey}/{num_question}', [AulaSurveysController::class, 'show'])->name('aula.surveys.show');
            Route::post('/aula/encuestas/iniciar/{userSurvey}', [AulaSurveysController::class, 'start'])->name('aula.surveys.start');
            Route::patch('/aula/encuestas/actualizar/{user_survey}/{group_id}', [AulaSurveysController::class, 'update'])->name('aula.surveys.update');
        });

        Route::group(['middleware' => 'check.role:instructor'], function(){
            Route::get('/aula/e-learning/Instructor/{course}', [AulaCourseInstController::class, 'show'])->name('aula.course.instructor.show');
        });
    

        Route::get('/aula/e-learning/{course}/carpetas', [AulaFolderController::class, 'index'])->name('aula.course.folder.index');
        Route::get('/aula/e-learning/{course}/carpeta/{folder}', [AulaFolderController::class, 'show'])->name('aula.course.folder.show');

        Route::get('/aula/e-learning/Carpeta/descargar/{file}', [DocumentController::class, 'download'])->name('aula.file.download');

        Route::get('/aula/e-learning/ajax-certification/{certification}', [AulaEvaluationController::class, 'getAjaxCertification'])->name('aula.course.ajax.certification');
        
        Route::post('/aula/e-learning/{certification}', [QuizController::class, 'start'])->name('aula.course.quiz.start');
        Route::patch('/aula/e-learning/{certification}/{exam}/pregunta/{num_question}/{key}/{evaluation}', [QuizController::class, 'update'])->name('aula.course.quiz.update');

    });

});
