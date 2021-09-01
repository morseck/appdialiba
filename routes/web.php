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
Route::post('/importation_talibe', 'TalibeController@importation_talibe')->name('importation_talibe');
Route::get('/importation_talibe', 'TalibeController@importation_talibe')->name('importation_talibe');

//Importer fichier excel dieuwrine
Route::post('/importation_dieuw', 'DieuwController@importation_dieuw')->name('importation_dieuw');
Route::get('/importation_dieuw', 'DieuwController@importation_dieuw')->name('importation_dieuw');

//Importer fichier excel ndongo tarbiya
Route::post('/importation_tarbiya', 'TarbiyaController@importation_tarbiya')->name('importation_tarbiya');
Route::get('/importation_tarbiya', 'TarbiyaController@importation_tarbiya')->name('importation_tarbiya');



//Importer fichier excel medecin
Route::post('/importation_medecin', 'MedecinController@importation_medecin')->name('importation_medecin');
Route::get('/importation_medecin', 'MedecinController@importation_medecin')->name('importation_medecin');

//Rechercher un talibe a partir de son nom prenom
Route::get('/talibe/recherche', 'TalibeController@recherche')->name('reccherche_talibe');
//Consulter un talibe supprimé à parit de son id
Route::get('/talibe/show_talibe_delete/{id}', 'TalibeController@showTalibeDelete')->name('talibe.show_talibe_delete');
//Restaurer un talibé supprimé à partir de son id
Route::post('/talibe/restore/{id}', 'TalibeController@restore')->name('talibe.restore');

Route::get('/galerie', 'GalerieController@index');

Route::get('galerie/{photoId}', 'GalerieController@show');

Route::resource('dieuw','DieuwController');

Route::resource('talibe','TalibeController');

Route::get('talibe-deleted', 'TalibeController@viewTrash')->name('talibe.deleted');

Route::resource('daara','DaaraController');

Route::get('/daara/{id}/talibes/','DaaraController@talibes')->name('by_daara');

//Liste des talibes enseignes par un dieuwrine
Route::get('/dieuw/{id}/talibes/','DieuwController@talibeByDieuw')->name('by_dieuw');

Route::resource('consultation','ConsultationController');
//Consulter une campagne de consultation à parit de sa date
Route::get('/consultation/show_consultation_by_date/{date}', 'ConsultationController@showConsultationByDate')->name('consultation.show_consultation_by_date');

Route::resource('medecin','MedecinController');

Route::resource('tarbiya','TarbiyaController');
