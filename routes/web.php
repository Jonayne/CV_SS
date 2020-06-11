<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Deshabilitamos la ruta de register que viene por defecto, pues no se podrá usar el sistema
// a menos que uno se encuentre loggeado.
Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

// Rutas para la funcionalidad de "Buscar CV"
Route::group(['namespace' => 'Search'], function () {
    Route::get('/buscar_profesor', 'SearchController@index')->name('buscar_profesor.index');
    Route::post('/buscar_profesor', 'SearchController@searchOnDB')->name('buscar_profesor.searchOnDB');
});

// Rutas para toda la funcionalidad en la parte del Curriculum, 
// desde capturarlo, actualizarlo, descargarlo, etc...
Route::group(['namespace' => 'Curriculum'], function () {
    // RUTAS PARA CAPTURAR EL CV (crearlo o editarlo)
    Route::get('/capturar_cv_datos_personales', 'CurriculumController@capture1')->name('curricula.capture1');
    Route::get('/capturar_cv_datos_academicos', 'CurriculumController@capture2')->name('curricula.capture2');
    Route::get('/capturar_cv_cursos_extracurriculares', 'CurriculumController@capture3')->name('curricula.capture3');
    Route::get('/capturar_cv_certificaciones_obtenidas', 'CurriculumController@capture4')->name('curricula.capture4');
    Route::get('/capturar_cv_lista_de_temas', 'CurriculumController@capture5')->name('curricula.capture5');
    Route::get('/capturar_cv_experiencia_previa', 'CurriculumController@capture6')->name('curricula.capture6');
    Route::get('/capturar_cv_documentos_probatorios', 'CurriculumController@capture7')->name('curricula.capture7');

    // RUTAS PARA EL MÉTODO SHOW.
    Route::get('/mostrar_cv_datos_personales/{id}', 'CurriculumController@show')->name('curricula.show');
    Route::get('/mostrar_cv_datos_academicos/{id}', 'CurriculumController@show2')->name('curricula.show2');
    Route::get('/mostrar_cv_cursos_extracurriculares/{id}', 'CurriculumController@show3')->name('curricula.show3');
    Route::get('/mostrar_cv_certificaciones_obtenidas/{id}', 'CurriculumController@show4')->name('curricula.show4');
    Route::get('/mostrar_cv_lista_de_temas/{id}', 'CurriculumController@show5')->name('curricula.show5');
    Route::get('/mostrar_cv_experiencia_previa/{id}', 'CurriculumController@show6')->name('curricula.show6');
    Route::get('/mostrar_cv_documentos_probatorios/{id}', 'CurriculumController@show7')->name('curricula.show7');

    // RUTA PARA ACTUALIZAR EL CV EN LA BASE
    Route::patch('/curriculum/{curriculum}', 'CurriculumController@save')->name('curricula.update');

    // Rutas para controlar los registros de "Cursos extracurriculares".
    Route::resource('extracurricular_course', 'ExtracurricularCourseController')->
        names('extracurricular_courses')->except(['index', 'show']);

    // Rutas para controlar los registros de "Lista de temas a impartir".
    Route::resource('subject', 'SubjectController')->
        names('subjects')->except(['index', 'show']);

    // Rutas para controlar los registros de "Experiencia profesional previa".
    Route::resource('previous_experience', 'PreviousExperienceController')->
        names('previous_experiences')->except(['index', 'show']);

    // Rutas para controlar los registros de "Documentos probatorios".
    Route::resource('supporting_document', 'SupportingDocumentController')->
        names('supporting_documents')->except(['index', 'show']);
});

// Rutas para la funcionalidad de "Registrar a un usuario"
Route::group(['namespace' => 'Register'], function () {
    Route::get('/registrar_usuario', 'RegisterUserController@index')->name('registrar_usuario.index');
    Route::post('/registrar_usuario', 'RegisterUserController@registerUser')->name('registrar_usuario.registerUser');
});
