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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Importer fichier excel dieuwrine
//Route::post('/importation', 'TalibeController@importation_dieuwrine')->name('importation');

//Importer fichier excel talibe
Route::post('/importation', 'TalibeController@importation_talibe')->name('importation_talibe');

//Rechercher un talibe a partir de son nom prenom
Route::get('/talibe/recherche', 'TalibeController@recherche')->name('reccherche_talibe');

Route::get('/galerie', 'GalerieController@index');

Route::get('galerie/{photoId}', 'GalerieController@show');

Route::resource('dieuw','DieuwController');

Route::resource('talibe','TalibeController');

Route::get('talibe-deleted', 'TalibeController@viewTrash')->name('talibe.deleted');

Route::resource('daara','DaaraController');

Route::get('/daara/{id}/talibes/','DaaraController@talibes')->name('by_daara');

Route::resource('consultation','ConsultationController');

Route::resource('medecin','MedecinController');
