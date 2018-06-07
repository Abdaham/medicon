<?php

//Rutas para el Front
Route::get('/', 'Front\PaginasController@inicio')->name('inicio');
Route::get('/nosotros', 'Front\PaginasController@nosotros')->name('nosotros');
Route::get('/servicios', 'Front\PaginasController@servicios')->name('servicios');
Route::get('/contacto', 'Front\PaginasController@contacto')->name('contacto');
Route::resource('/calendario', 'Agenda\AgendasController');

//Rutas para la administracion
Route::get('/admin',function(){
	return view('admin.inicio');
});

Route::resource('admin/usuarios','Usuarios\UsuariosController');
Route::resource('admin/medicos','Usuarios\MedicosController');

//Ruta para exportar PDF Usuarios
Route::get('usuarios-pdf','Usuarios\UsuariosController@exportarPDF')->name('pdfusuarios');

//Ruta para exportar EXCEL Usuarios
Route::get('usuarios-excel','Usuarios\UsuariosController@exportarExcel')->name('excelusuarios');

//Ruta para importar EXCEL Usuarios
Route::get('usuarios-importar','Usuarios\UsuariosController@importarExcel')->name('importarusuarios');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');