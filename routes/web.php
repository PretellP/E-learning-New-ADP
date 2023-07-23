<?php

use App\Http\Controllers\{
    HomeController
};
use App\Http\Controllers\Admin\{
    AdminController,
    AdminCourseController,
    FolderController,
    DocumentController
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
    AulaFreeCourseController
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
    
    Route::group(['middleware' => 'admin'], function(){
        // ---- ADMIN DASHBOARD PRINCIPAL VIEW --------
        Route::get('/admin/inicio', [AdminController::class, 'index'])->name('admin.index');
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

        Route::group(['middleware' => 'participant'], function(){
            Route::get('/aula/e-learning/Alumno/{course}', [AulaCoursePartController::class, 'show'])->name('aula.course.participant.show');
            Route::get('/aula/e-learning/Alumno/{course}/evaluaciones', [AulaEvaluationController::class, 'index'])->name('aula.course.evaluation.index');
            Route::get('/aula/e-learning/Alumno/{certification}/pregunta/{num_question}', [QuizController::class, 'show'])->name('aula.course.quiz.show');
            Route::get('/aula/e-learning/Alumno/{course}/curso-online', [AulaOnlineLessonController::class, 'index'])->name('aula.course.onlinelesson.index');
            Route::get('/aula/e-learning/Alumno/clase-online/{event}', [AulaOnlineLessonController::class, 'show'])->name('aula.course.onlinelesson.show');


            Route::get('/aula/cursos-libres', [AulaFreeCourseController::class, 'index'])->name('aula.freecourse.index');
            Route::get('/aula/cursos-libres/categoria/{category}', [AulaFreeCourseController::class, 'showCategory'])->name('aula.freecourse.showCategory');
            Route::get('/aula/cursos-libres/curso/{course}/{current_chapter}', [AulaFreeCourseController::class, 'showCourse'])->name('aula.freecourse.showChapter');
            Route::post('/aula/cursos-libres/iniciar/{course}', [AulaFreeCourseController::class, 'start'])->name('aula.freecourse.start');
            Route::patch('/aula/cursos-libres/actualizar/{current_chapter}/{new_chapter}', [AulaFreeCourseController::class, 'updateChapter'])->name('aula.freecourse.update');
           
        });

        Route::group(['middleware' => 'instructor'], function(){
            Route::get('/aula/e-learning/Instructor/{course}', [AulaCourseInstController::class, 'show'])->name('aula.course.instructor.show');
        });
    

        Route::get('/aula/e-learning/{course}/carpetas', [AulaFolderController::class, 'index'])->name('aula.course.folder.index');
        Route::get('/aula/e-learning/{course}/carpeta/{folder}', [AulaFolderController::class, 'show'])->name('aula.course.folder.show');

        Route::get('/aula/e-learning/Carpeta/descargar/{file}', [DocumentController::class, 'download'])->name('aula.file.download');

        Route::get('/aula/e-learning/ajax-certification/{certification}', [AulaEvaluationController::class, 'getAjaxCertification'])->name('aula.course.ajax.certification');
        
        Route::post('/aula/e-learning/{certification}', [QuizController::class, 'start'])->name('aula.course.quiz.start');
        Route::patch('/aula/e-learning/{certification}/{exam}/{num_question}/{key}/{evaluation}', [QuizController::class, 'update'])->name('aula.course.quiz.update');

    });

});
