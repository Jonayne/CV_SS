<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Search'], function () {
    Route::get('/buscar_profesor', 'SearchController@index')->name('buscar_profesor.index');
    Route::post('/buscar_profesor', 'SearchController@searchOnDB')->name('buscar_profesor.searchOnDB');
});

Route::group(['namespace' => 'Curriculum'], function () {
    // RUTAS PARA EL MÉTODO CREATE
    Route::get('/capturar_cv_datos_personales', 'CurriculumController@create1')->name('curricula.create');
    Route::post('/capturar_cv_datos_personales', 'CurriculumController@Postcreate1');
    Route::get('/capturar_cv_datos_academicos', 'CurriculumController@create2')->name('curricula.create2');
    Route::post('/capturar_cv_datos_academicos', 'CurriculumController@Postcreate2');
    Route::get('/capturar_cv_cursos_extracurriculares', 'CurriculumController@create3')->name('curricula.create3');
    Route::get('/capturar_cv_certificaciones_obtenidas', 'CurriculumController@create4')->name('curricula.create4');
    Route::post('/capturar_cv_certificaciones_obtenidas', 'CurriculumController@Postcreate4');
    Route::get('/capturar_cv_lista_de_temas', 'CurriculumController@create5')->name('curricula.create5');
    Route::get('/capturar_cv_experiencia_previa', 'CurriculumController@create6')->name('curricula.create6');
    Route::get('/capturar_cv_documentos_probatorios', 'CurriculumController@create7')->name('curricula.create7');

    // RUTAS PARA EL MÉTODO EDIT
    Route::get('/editar_cv_datos_personales', 'CurriculumController@edit1')->name('curricula.edit');
    Route::post('/editar_cv_datos_personales', 'CurriculumController@Postedit1');
    Route::get('/editar_cv_datos_academicos', 'CurriculumController@edit2')->name('curricula.edit2');
    Route::post('/editar_cv_datos_academicos', 'CurriculumController@Postedit2');
    Route::get('/editar_cv_cursos_extracurriculares', 'CurriculumController@edit3')->name('curricula.edit3');
    Route::get('/editar_cv_certificaciones_obtenidas', 'CurriculumController@edit4')->name('curricula.edit4');
    Route::post('/editar_cv_certificaciones_obtenidas', 'CurriculumController@Postedit4');
    Route::get('/editar_cv_lista_de_temas', 'CurriculumController@edit5')->name('curricula.edit5');
    Route::get('/editar_cv_experiencia_previa', 'CurriculumController@edit6')->name('curricula.edit6');
    Route::get('/editar_cv_documentos_probatorios', 'CurriculumController@edit7')->name('curricula.edit7');

    // RUTAS PARA EL MÉTODO SHOW.
    Route::get('/mostrar_cv_datos_personales/{id}', 'CurriculumController@show')->name('curricula.show');
    Route::get('/mostrar_cv_datos_academicos/{id}', 'CurriculumController@show2')->name('curricula.show2');
    Route::get('/mostrar_cv_cursos_extracurriculares/{id}', 'CurriculumController@show3')->name('curricula.show3');
    Route::get('/mostrar_cv_certificaciones_obtenidas/{id}', 'CurriculumController@show4')->name('curricula.show4');
    Route::get('/mostrar_cv_lista_de_temas/{id}', 'CurriculumController@show5')->name('curricula.show5');
    Route::get('/mostrar_cv_experiencia_previa/{id}', 'CurriculumController@show6')->name('curricula.show6');
    Route::get('/mostrar_cv_documentos_probatorios/{id}', 'CurriculumController@show7')->name('curricula.show7');

    // Se siguen generando las rutas para los métodos destroy, update y store.
    Route::resource('curriculum', 'CurriculumController')->
        names('curricula')->except(['create', 'index', 'show', 'edit']);

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

Route::group(['namespace' => 'Register'], function () {
    Route::get('/registrar_usuario', 'RegisterUserController@index')->name('registrar_usuario.index');
    Route::post('/registrar_usuario', 'RegisterUserController@registerUser')->name('registrar_usuario.registerUser');
});