<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/dashboard', function(){
    return view('admin.dashboard');
})->name('dashboard')->middleware('auth');

Route::post('/dashboard/auth', function() {
    return Auth::user();
});
//Rutas de auth personalizadas
Route::get('/logout','logout@logout')->name('logout');
route::get('/contraseña/insertar/{token}/{email}','Auth\ResetPasswordController@showInsertForm')->name('insertPassword');
route::post('/contraseña/insertar/','Auth\ResetPasswordController@insertPassword')->name('setPassword');

Route::middleware('auth')->group(function(){
    //ruta que retorna las vistas

    Route::prefix('dashboard')->group(function (){
        //PACIENTES
        Route::prefix('paciente')->group(function () {
            //RETORNO DE VISTAS
            Route::middleware('paciente')->group(function() {
                Route::post('citas','citasController@citasPaciente')->name('citasPaciente');
                Route::get('citas', function() {
                    return view('admin.dashboard');
                });
            });
            Route::middleware('secretaria_admin')->group(function(){
                Route::get('crear', function() {
                    return view('admin.dashboard');
                });
                Route::get('edit/{dui}', function($dui) {
                    return view('admin.dashboard');
                })->where('dui', '^[0-9]{8}-[0-9]{1}$');
                Route::get('{dui}/expediente', function(){
                    return view('admin.dashboard');
                });
                Route::get('/', function () {return view('admin.dashboard');});
                
                //Retorno de datos
                Route::post('/','pacienteController@listarPacientes')->name('listarPacientes');
                Route::post('crear','pacienteController@crearPost')->name('crearPacientes');
                Route::put('actualizar','pacienteController@actualizarPost')->name('actualizarPacientes');
                Route::delete('{id}','pacienteController@delete')->name('deletePatiente');
                Route::post('infoPaciente','pacienteController@infoPaciente')->name('infoPaciente');
            });
            Route::post('listar','pacienteController@listarPost')->name('listarPacientes');
        });
        Route::prefix('doctor')->group(function () {
            Route::get('citas', function() {
                return view('admin.dashboard');
            });
            Route::middleware('admin')->group(function(){
                //Retorno de vistas
                Route::get('crear', function() {
                    return view('admin.dashboard');
                });
                Route::get('edit/{dui}', function($dui) {
                    return view('admin.dashboard');
                })->where('dui', '^[0-9]{8}-[0-9]{1}$');
                Route::get('{dui}/expediente', function(){
                    return view('admin.dashboard');
                });
                Route::get('/', function (){return view('admin.dashboard');});
                //Retorno de datos
                Route::post('/','doctorController@listarDoctores')->name('listarDoctores');
                Route::post('crear','doctorController@crearPost')->name('crearDoctor');
                Route::put('actualizar','doctorController@actualizarPost')->name('actualizarDoctor');
                Route::post('infoDoctor','doctorController@infoDoctor')->name('infoDoctor');
                Route::post('listar','doctorController@listarPost')->name('listarDoctores'); 
                Route::DELETE('{id}','doctorController@delete')->name('deleteDoctor');
            });
        });
        Route::prefix('secretaria')->group(function () {
            Route::middleware('admin')->group(function(){

                //Retorno de vistas
                Route::get('crear', function() {
                    return view('admin.dashboard');
                });
                Route::get('edit/{dui}', function($dui) {
                    return view('admin.dashboard');
                })->where('dui', '^[0-9]{8}-[0-9]{1}$');
                Route::get('{dui}/expediente', function(){
                    return view('admin.dashboard');
                });
                Route::get('/', function (){return view('admin.dashboard');});
            //Retorno de datos
            Route::post('/','secretariaController@listarSecretarias')->name('listarSecretarias');
            Route::post('crear','secretariaController@crearPost')->name('crearSecretaria');
            Route::put('actualizar','secretariaController@actualizarPost')->name('actualizarSecretaria');
            Route::post('infoSecretaria','secretariaController@infoSecretaria')->name('infoSecretaria');
            Route::DELETE('{id}','secretariaController@delete')->name('deleteSecretaria');
            });
        });

        Route::prefix('promotor')->group(function () {
            Route::middleware('admin')->group(function(){

                //Retorno de vistas
                Route::get('crear', function() {
                    return view('admin.dashboard');
                });
                Route::get('edit/{dui}', function($dui) {
                    return view('admin.dashboard');
                })->where('dui', '^[0-9]{8}-[0-9]{1}$');
                Route::get('{dui}/expediente', function(){
                    return view('admin.dashboard');
                });
                Route::get('/', function (){return view('admin.dashboard');});
            //Retorno de datos
            Route::post('/','promotorController@listarPromotores')->name('listarSecretarias');
            Route::post('crear','promotorController@crearPost')->name('crearPromotor');
            Route::put('actualizar','promotorController@actualizarPost')->name('actualizarPromotor');
            Route::post('infoPromotor','promotorController@infoPromotor')->name('infoPromotor');
            Route::delete('{id}','promotorController@delete')->name('deleteSecretaria');

        });
    });
        Route::prefix('citas')->group(function () {
            //Retorno de datos
            Route::get('/', function(){return view('admin.dashboard');});
            Route::post('crear','citasController@crearPost')->name('crearCita');
        });

        Route::prefix('expediente')->group(function () {
            //Retorno de datos
            Route::post('/', 'expedienteController@fileByPatient')->name('obtenerExpediente');
            Route::post('crear', 'expedienteController@crearPost')->name('crearExpediente');
        });
        Route::prefix('consultas')->group(function () {
            //Retorno de datos
            Route::get('/', function() {
                return view('admin.dashboard');
            });
        });

        Route::prefix('notificaciones')->group(function () {
            //Retorno de datos
            Route::post('listar', 'notificationController@listaNotificaciones')->name('listarNotificaciones');
            Route::post('visto', 'notificationController@vistoNotificaciones')->name('vistoNotificaciones');
        });

    });
});
Auth::routes();

