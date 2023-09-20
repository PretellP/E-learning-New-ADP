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
    AdminUsersController,
    AdminOwnerCompaniesController,
    AdminMiningUnitsController
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

        Route::controller(AdminUsersController::class)->group(function(){

            Route::get('/admin/usuarios', 'index')->name('admin.users.index');
            Route::get('/admin/usuarios/registrar/obtener-empresas', 'registerGetCompanies')->name('admin.users.registerGetCompanies');
            Route::get('/admin/usuarios/editar/{user}', 'edit')->name('admin.user.edit');
            Route::post('/admin/usuarios/registrar/validar-dni', 'registerValidateDni')->name('admin.users.validateDni');
            Route::post('/admin/usuarios/editar/validar-dni', 'editValidateDni')->name('admin.user.editValidateDni');
            Route::post('/admin/usuarios/registrar', 'store')->name('admin.user.store');
            Route::post('/admin/usuarios/actualizar/{user}', 'update')->name('admin.user.update');
            Route::delete('/admin/usuarios/eliminar/{user}', 'destroy')->name('admin.user.delete');

        });

      


        // ---------------  COMPANIES --------------------

        Route::controller(AdminCompaniesController::class)->group(function(){

            Route::get('/admin/empresas', 'index')->name('admin.companies.index');
            Route::get('/admin/empresas/editar/{company}', 'edit')->name('admin.companies.edit');
            Route::post('/admin/empresas/registrar', 'store')->name('admin.companies.store');
            Route::post('/admin/empresas/editar/validar-ruc', 'EditvalidateRuc')->name('admin.companies.validateRuc');
            Route::post('/admin/empresas/actualizar/{company}', 'update')->name('admin.companies.update');
            Route::delete('/admin/empresas/eliminar/{company}', 'destroy')->name('admin.companies.delete');

        });

       


        // ---------------- OWNER COMPANIES ---------------

        Route::controller(AdminOwnerCompaniesController::class)->group(function(){

            Route::get('/admin/empresas-titulares', 'index')->name('admin.ownerCompanies.index');
            Route::get('/admin/empresas-titulares/editar/{company}', 'edit')->name('admin.ownerCompany.edit');
            Route::post('/admin/empresas-titulares/validar-registro', 'registerValidate')->name('admin.ownerCompany.registerValidate');
            Route::post('/admin/empresas-titulares/validar-edición', 'editValidate')->name('admin.ownerCompanies.editValidate');
            Route::post('/admin/empresas-titulares/registrar', 'store')->name('admin.ownerCompanies.store');
            Route::post('/admin/empresas-titulares/actualizar/{company}', 'update')->name('admin.ownerCompany.update');
            Route::delete('/admin/empresas-titulares/eliminar/{company}', 'destroy')->name('admin.ownerCompany.delete');

        });



        /* ------------------ MINING UNITS ----------------------*/

        Route::controller(AdminMiningUnitsController::class)->group(function(){

            Route::get('/admin/unidades-mineras', 'index')->name('admin.miningUnits.index');
            Route::get('/admin/unidades-mineras/editar/{miningUnit}', 'getDataEdit')->name('admin.miningUnits.getDataEdit');
            Route::post('/admin/unidades-mineras/registrar', 'store')->name('admin.miningUnits.store');
            Route::post('/admin/unidades-mineras/actualizar/{miningUnit}', 'update')->name('admin.mininUnits.update');
            Route::delete('/admin/unidades-mineras/eliminar/{miningUnit}', 'destroy')->name('admin.miningUnits.delete');
        });
     

        


        // --------------- ROOMS -------------------------

        Route::controller(AdminRoomsController::class)->group(function(){

            Route::get('/admin/salas', 'index')->name('admin.rooms.index');
            Route::get('/admin/salas/editar/{room}', 'edit')->name('admin.room.edit');
            Route::post('/admin/salas/registrar', 'store')->name('admin.rooms.store');
            Route::post('/admin/salas/registrar/validar-nombre', 'registerValidateName')->name('admin.rooms.registerValidateName');
            Route::post('/admin/salas/editar/validar-nombre', 'editValidateName')->name('admin.rooms.editValidateName');
            Route::post('/admin/salas/actualizar/{room}', 'update')->name('admin.room.update');
            Route::delete('/admin/salas/eliminar/{room}', 'destroy')->name('admin.rooms.delete');

        });

       


        // --------------- COURSES ----------------------

        Route::controller(AdminCourseController::class)->group(function(){

            Route::get('/admin/cursos', 'index')->name('admin.courses.index');
            Route::get('/admin/cursos/editar/{course}', 'edit')->name('admin.courses.edit');
            Route::get('/admin/cursos/ver/{course}', 'show')->name('admin.courses.show');
            Route::post('/admin/cursos/registrar', 'store')->name('admin.courses.store');
            Route::post('/admin/cursos/actualizar/{course}', 'update')->name('admin.courses.update');
            Route::delete('/admin/cursos/eliminar/{course}', 'destroy')->name('admin.courses.delete');

        });

      


        // --------------- FREE COURSES -----------------

        Route::controller(AdminFreeCoursesController::class)->group(function(){

            Route::get('/admin/cursos-libres', 'index')->name('admin.freeCourses.index');
            Route::get('/admin/cursos-libres/registrar/obtener-categorias', 'getCategoriesRegisterCourse')->name('admin.freecourses.getCategoriesRegister');
            Route::get('/admin/cursos-libres/categorias/editar/{category}', 'getDataCategory')->name('admin.freecourses.getDataCategory');
            // CATEGORIES - INDEX
            Route::get('/admin/cursos-libres/categoría/{category}', 'showCategory')->name('admin.freeCourses.categories.index');
            Route::post('/admin/cursos-libres/categorías/registrar', 'storeCategory')->name('admin.freeCourses.storeCategory');
            Route::post('/admin/cursos-libres/categorías/actualizar/{category}', 'updateCategory')->name('admin.freecourses.categoryUpdate');
            Route::post('/admin/cursos-libres/categorías/eliminar/{category}', 'destroyCategory')->name('admin.freecourses.deleteCategory');
            // FREE COURSES - INDEX
            Route::post('/admin/cursos-libres/registrar', 'storeFreecourse')->name('admin.freecourses.storeFreecourse');
            // FREE COURSE - SHOW
            Route::get('/admin/cursos-libres/curso/{course}', 'showCourse')->name('admin.freeCourses.courses.index');
            Route::get('/admin/cursos-libres/editar/{course}', 'getDataCourse')->name('admin.freecourse.getDatacourse');
            Route::get('/admin/cursos-libres/sección/editar/{section}', 'getDataSection')->name('admin.freeCourses.section.edit');
            Route::get('/admin/cursos-libres/obtener-capítulos/section/{section}', 'getChapterTable')->name('admin.freeCourses.getChaptersTable');
            Route::get('/admin/cursos-libres/capítulo/editar/{chapter}', 'getDataChapter')->name('admin.freeCourses.chapters.getData');
            Route::get('/admin/cursos-libres/capítulo/obtener-video/{chapter}', 'getChapterVideoData')->name('admin.freeCourses.chapters.getVideoData');
            Route::post('/admin/cursos-libres/actualizar/{course}', 'updateFreecourse')->name('admin.freeCourses.updateFreecourse');
            Route::post('/admin/cursos-libres/curso/eliminar/{course}', 'destroyCouse')->name('admin.freecourses.deleteCourse');
            Route::post('/admin/cursos-libres/sección/actualizar-orden/{section}', 'updateSectionOrder')->name('admin.freecourses.section.updateOrder');
            Route::post('/admin/cursos-libres/curso/{course}/secciones/registrar', 'storeSection')->name('admin.freeCourses.sections.store');
            Route::post('/admin/cursos-libres/secciones/actualizar/{section}', 'updateSection')->name('admin.freeCourses.sections.update');
            Route::post('/admin/cursos-libres/secciones/eliminar/{section}', 'destroySection')->name('admin.freeCourses.sections.delete');
            Route::post('/admin/cursos-libres/sección/{section}/registrar-capítlo', 'storeChapter')->name('admin.freeCourses.chapters.store');
            Route::post('/admin/cursos-libres/capítulos/actualizar/{chapter}', 'updateChapter')->name('admin.freeCourses.chapters.update');
            Route::post('/admin/cursos-libres/capítulos/eliminar/{chapter}', 'destroyChapter')->name('admin.freeCourses.chapters.delete');

        });

       

        // --------------- EVALUATIONS -------------------

        Route::get('/admin/evaluaciones', [AdminEvaluationsController::class, 'index'])->name('admin.evaluations.index');

        // --------------- EVENTS ------------------------

        Route::get('/admin/eventos', [AdminEventsController::class, 'index'])->name('admin.events.index');

         // --------------- ANNOUNCEMENTS ----------------

         Route::get('/admin/anuncios', [AdminAnnouncementsController::class, 'index'])->name('admin.announcements.index');


        // ----- ALL COURSES VIEW LIST  ---------------------

        // Route::get('/admin/Cursos/', [AdminCourseController::class, 'index'])->name('admin.course.index');

        // ----- COURSE FOLDERS VIEWS-----------------------
        // Route::get('/admin/Cursos/{course}', [AdminCourseController::class, 'show'])->name('admin.course.show');
        // ------ folder view  ------------------------------
        Route::get('/admin/cursos/carpeta/{folder}/archivos', [DocumentController::class, 'index'])->name('admin.files.index');
        Route::get('/admin/cursos/{course}/ver-carpeta/{folder}', [FolderController::class, 'show'])->name('admin.courses.folder.view');
        Route::get('/admin/Cursos/Carpeta/descargar/{file}', [DocumentController::class, 'download'])->name('file.download');
        Route::post('/admin/cursos/carpeta/crear-carpeta/{course}', [FolderController::class, 'create'])->name('folder.create');
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
