<?php




//**********************************START NEW ROUTE**********************************


//use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    //Route::resource('/admin/users', 'AdminController');
});

/*
// Routes protégées par plusieurs rôles
Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    //Route::get('/management', 'ManagementController@index');
});

// Routes protégées par permission
Route::middleware(['auth', 'permission:edit-tablibes'])->group(function () {
   // Route::get('/posts/{post}/edit', 'PostController@edit');
    //Route::put('/posts/{post}', 'PostController@update');
});

// Routes protégées par permission
Route::middleware(['auth', 'permission:delete-tablibes'])->group(function () {
    //Route::delete('/posts/{post}', 'PostController@destroy');
});

// Exemple d'utilisation dans un contrôleur individuel
//Route::get('/profile', 'UserController@profile')->middleware(['auth', 'role:user']);

// Combinaison de middleware
Route::middleware(['auth', 'role:admin', 'permission:manage-users'])->group(function () {
  //  Route::resource('/admin/roles', 'RoleController');
   // Route::resource('/admin/permissions', 'PermissionController');
});
 * /

//**********************************END NEW ROUTE**********************************







//**********************************START OLD ROUTE**********************************

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
/*
Route::get('/', function () {
    return view('welcome');
});*/



Auth::routes();

//Route::get('/', 'HomeController@index')->name('home');

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
//Consulter une campagne de consultation à partir d'un medecin
Route::get('/consultation/show_consultation_by_medecin/{medecin_id}', 'ConsultationController@showConsultationByMedecin')->name('consultation.show_consultation_by_medecin');

Route::resource('medecin','MedecinController');

Route::resource('tarbiya','TarbiyaController');

Route::resource('ordonnance','OrdonnanceController');

//**********************************END OLD ROUTE**********************************



//**********************************Administration**********************************

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    // Routes pour les rôles
    Route::resource('roles', 'RoleController');
    Route::post('roles/{role}/permissions', 'RoleController@assignPermissions')->name('roles.assign-permissions');
    Route::delete('roles/{role}/permissions/{permission}', 'RoleController@removePermission')->name('roles.remove-permission');

    // Routes pour les permissions
    Route::resource('permissions', 'PermissionController');

    // Routes pour la gestion des utilisateurs
    Route::resource('users', 'UserController');
    Route::post('users/{user}/roles', 'UserController@assignRoles')->name('users.assign-roles');
    Route::delete('users/{user}/roles/{role}', 'UserController@removeRole')->name('users.remove-role');

    // Route pour le tableau de bord
    Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');
});



//********************************** Logs Transaction **********************************
// Solution 1: Routes manuelles (recommandée)
Route::group(['prefix' => 'transaction-logs', 'middleware' => 'auth'], function () {

    // Routes spécifiques AVANT la route avec paramètre
    Route::get('export', 'TransactionLogsController@export')->name('transaction-logs.export');
    Route::delete('clean', 'TransactionLogsController@clean')->name('transaction-logs.clean');
    Route::get('statistics', 'TransactionLogsController@statistics')->name('transaction-logs.statistics');

    // Routes principales
    Route::get('/', 'TransactionLogsController@index')->name('transaction-logs.index');
    Route::get('{id}', 'TransactionLogsController@show')->name('transaction-logs.show')->where('id', '[0-9]+');
});


//********************************** Logs Laravel **********************************
Route::group(['prefix' => 'logs', 'middleware' => ['auth']], function () {
    Route::get('/', 'LogController@index')->name('logs.index');
    Route::get('/show/{filename}', 'LogController@show')->name('logs.show');
    Route::get('/download/{filename}', 'LogController@download')->name('logs.download');
    Route::delete('/delete/{filename}', 'LogController@delete')->name('logs.delete');
    Route::post('/clear', 'LogController@clear')->name('logs.clear');
});
