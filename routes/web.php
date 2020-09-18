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
    Route::get('/resultados_busqueda', 'SearchController@searchOnDB')->name('buscar_profesor.searchOnDB');
});

// Rutas para toda la funcionalidad en la parte del Curriculum, 
// desde capturarlo, actualizarlo, descargarlo, etc...
Route::group(['namespace' => 'Curriculum'], function () {
    // Ruta para capturar el cv (crearlo o editarlo).
    Route::get('/capturar_curriculum/{formNum}', 'CurriculumController@capture')->name('curricula.capture');

    // Ruta para el método show.
    Route::get('/mostrar_curriculum/{id}/{formNum}', 'CurriculumController@show')->name('curricula.show');

    // Ruta para descargar el curriculum.
    Route::post('/descargar_curriculum/{id}', 'CurriculumController@downloadCV')->name('curricula.downloadCV');

    // Ruta para una vista de ayuda para exportar el descargable a PDF.
    Route::get('/ayuda_pdf', 'CurriculumController@helpPDF')->name('curricula.helpPDF');

    // RUTA PARA ACTUALIZAR EL CV EN LA BASE
    Route::patch('/curriculum/{curriculum}', 'CurriculumController@save')->name('curricula.update');

    // Rutas para controlar los registros de "Cursos extracurriculares".
    Route::resource('extracurricular_course', 'ExtracurricularCourseController')->
        names('extracurricular_courses')->except(['index', 'show']);
    
    // Rutas para controlar los registros de "Certificaciones obtenidas".
    Route::resource('certification', 'CertificationController')->
        names('certifications')->except(['index', 'show']);

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
    Route::get('/actualizar_cat_pago/{id}/{backPage}', 'RegisterUserController@indexCatPago')->name('actualizar_cat_pago.indexCatPago');
    Route::patch('/actualizar_cat_pago/{id}/{backPage}', 'RegisterUserController@saveCatPago')->name('actualizar_cat_pago.saveCatPago');
});
