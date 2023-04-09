<?php

namespace App\Http\Controllers;


use App\Consultation;
use App\Daara;
use App\Dieuw;
use App\Medecin;
use App\Talibe;
use App\Importation;
use Validator;
use Illuminate\Http\Request;
use DB;
use Session;
//use Maatwebsite\Excel\Excel;
use Excel;

class TalibeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $view = $request->query('view') === 'card' ? 'talibe.index-card' : 'talibe.index-table';
        //$data_import = DB::table('import_taiba')->orderBy('id')->get();
        $data_import = null;
        $talibeList = Talibe::paginate(25);
        $numero = $talibeList->currentPage() * $talibeList->perPage() - $talibeList->perPage() + 1;
        return view($view, ['talibeList' => $talibeList, 'nbr' => Talibe::all()->count(), 'data_import' => $data_import, 'numero' => $numero]);
    }

    /**
     * Rechercher talibé à partir de son nom ou prenom
     * @param Request $request
     */
    public function recherche(Request $request)
    {
        $recherche = $request->get("recherche");
        $talibeList = array();
        $nombre = 0;

        if ($recherche) {
            // var_dump($recherche); die();
            //$talibeList = Talibe::query();
            $talibeList = Talibe::query()->where(DB::raw("lower(CONCAT(prenom,' ', nom))"), 'ilike', strtolower('%' . $recherche . '%'))
                ->get();
            //var_dump($talibes);die();
            /* $talibeList = DB::table('talibes')
                 ->where(DB::raw('CONCAT(prenom, " ", nom)'), 'ilike' , '%'.$recherche.'%')
                 ->get();*/
            $nombre = count($talibeList);
            // var_dump($resultats);die();
        }


        return view('talibe.recherche-table', ['talibeList' => $talibeList, 'recherche' => $recherche, 'nombre' => $nombre]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('talibe.create', [
            'dieuws' => Dieuw::all(),
            'daaras' => Daara::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $validator = Validator::make($request->all(), [

            'prenom' => 'required',
            'nom' => 'required',
            'genre' => 'required',
            // 'region' => 'required',
            // 'pere'   => 'required',
            // 'mere'   => 'required',
            'daara_id' => 'required',
            // 'datenaissance' => 'required'
        ], [
            'prenom.required' => 'Le prénom est requis',
            'nom.required' => 'Le nom est requis',
            'genre.required' => 'Le genre est requis',
            'region.required' => 'La région est requise',
            'pere.required' => 'Le nom du père est requis',
            'mere.required' => 'Le nom de la mère est requis'
        ]);

        $talibe = new Talibe($request->except(['datenaissance', 'arrivee']));

        $talibe->arrivee = null;
        if ($request->arrivee){
            $talibe->arrivee = app_date_reverse($request->arrivee, '/', '-');
        }

        $request->datenaissance = null;
        if ($request->datenaissance){
            $talibe->datenaissance = app_date_reverse($request->datenaissance, '/', '-');
        }

        if ($request->hasFile('avatar')) {
            $validator->after(function () use ($request, $talibe) {
                if (!$request->file('avatar')->isValid()) {
                    $validator->errors()->add('avatar', 'Erreur: Veuillez joindre limage à nouveau');
                } else {
                     $path = $request->avatar->store('talibe', ['disk' => 'my_files']);

                    $talibe->avatar = app_real_filename($path);
                }
            });
        } else {
            $talibe->avatar = intval($talibe->genre) === 1 ? 'user_male.ico' : 'user_female.ico';
        }

        if ($validator->fails())

            return back()->withErrors($validator);

        $talibe->save();
        $talibe = Talibe::latest()->first();
        $id = $talibe->id;

        //var_dump($talibe);die();
        session()->flash('talibeEvent', 'Le talibé ' . $talibe->fullname() . ' a été bien ajouté');

       // return redirect()->route('talibe.index');
        return redirect()->route('talibe.show', ['id' => $id]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Talibe::onlyTrashed()->where('id', $id)->get()->first()){
            return redirect()->route('talibe.show_talibe_delete', ['id'=>$id]);
        }

        $consultations =  Consultation::where('talibe_id', $id)->orderBy('date', 'desc')->get();
        $partMaladies = DB::select('SELECT COUNT(*) as poids, consultations.maladie FROM consultations JOIN talibes ON talibes.id=consultations.talibe_id WHERE talibes.id = '.$id.' AND  talibes.deleted_at IS NULL GROUP BY consultations.maladie') ;
        return view('talibe.show', [  'talibe' => Talibe::findOrFail($id),
                                            'medecins' => Medecin::all(),
                                            'daaras' => Daara::all(),
                                            'consultations'=>$consultations,
                                            'partMaladies'=>$partMaladies
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showTalibeDelete($id)
    {
        $consultations =  Consultation::where('talibe_id', $id)->orderBy('date', 'desc')->get();
        $partMaladies = DB::select('SELECT COUNT(*) as poids, consultations.maladie FROM consultations JOIN talibes ON talibes.id=consultations.talibe_id WHERE talibes.id = '.$id.' GROUP BY consultations.maladie') ;
        return view('talibe.show-talibe-deleted', ['talibe' => Talibe::onlyTrashed()->where('id', $id)->get()->first(),
            'medecins' => Medecin::all(),
            'daaras' => Daara::all(),
            'consultations'=>$consultations,
            'partMaladies'=>$partMaladies,
            'deleted' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('talibe.edit', ['talibe' => Talibe::findOrFail($id),
            'dieuws' => Dieuw::all(),
            'daaras' => Daara::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [

            'prenom' => 'required',
            'nom' => 'required',
            'genre' => 'required',
            // 'region' => 'required',
            // 'pere'   => 'required',
            // 'mere'   => 'required',
            'daara_id' => 'required',
            // 'datenaissance' => 'required'
        ], [
            'prenom.required' => 'Le prénom est requis',
            'nom.required' => 'Le nom est requis',
            'genre.required' => 'Le genre est requis',
            'region.required' => 'La région est requise',
            'pere.required' => 'Le nom du père est requis',
            'mere.required' => 'Le nom de la mère est requis'
        ]);

        //$test_date = new \DateTime($date_arrivee.'-01-01');

        //var_dump(($test_date));die();
        $talibe = Talibe::findOrFail($id);

        $talibe->fill([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'genre' => $request->genre,
            'datenaissance' => app_date_reverse($request->datenaissance, '/', '-'),
            'lieunaissance' => $request->lieunaissance,
            'region' => $request->region,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'pere' => $request->pere,
            'mere' => $request->mere,
            'tuteur' => $request->tuteur,
            'adresse' => $request->adresse,
            'daara_id' => $request->daara_id,
            'dieuw_id' => $request->dieuw_id,
            'niveau' => $request->niveau,
            'commentaire' => $request->commentaire,
            'arrivee' => app_date_reverse($request->arrivee, '/', '-')
        ]);

        if ($request->hasFile('avatar')) {
            $validator->after(function () use ($request, $talibe) {

                if (!$request->file('avatar')->isValid()) {

                    $validator->arrors()->add('avatar', 'Erreur: Veuillez joindre l\'image à nouveau');

                } else {

                     $path = $request->avatar->store('talibe', ['disk' => 'my_files']);
                    $talibe->avatar = app_real_filename($path);
                }
            });
        }

        if ($validator->fails())

            return back()->withErrors($validator);

        $talibe->save();

        session()->flash('talibeEvent', 'Le profil du talibé ' . $talibe->fullname() . ' a été bien mis à jour');

        return redirect()->route('talibe.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $talibe = Talibe::findOrFail($id);

        $name = $talibe->fullname();

        $talibe->delete();

        session()->flash('talibeEvent', 'Le Talibé ' . $name . ' a été supprimé avec succès');

        return redirect()->route('talibe.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function restore($id)
    {
        //dd($id);
        $talibe = Talibe::onlyTrashed()->where('id', $id)->get()->first();
        $name = $talibe->fullname();

       if ($talibe){
           Talibe::withTrashed()
               ->where('id', $id)
               ->restore();
           session()->flash('talibeEvent', 'Le Talibé ' . $name . ' a été restauré avec succès');
           return redirect()->route('talibe.show', ['id' => $id]);
       }
        return redirect()->route('talibe.deleted');
    }

    public function viewTrash()
    {

       // $trashedTalibes = Talibe::where('deleted_at','!=', null);
        $trashedTalibes = Talibe::onlyTrashed()->get();
       //var_dump($trashedTalibes);die();

        return view('talibe.trash', ['talibeList' => $trashedTalibes, 'nbr'=>count($trashedTalibes)]);
    }


    /**
     * importation fichier ndongo dans la table talibe
     * @param Request $request
     */
    function importation_talibe(Request $request){
        if (!$request->file()){
            return redirect()->route('talibe.index');
        }
        //Donnes sur les rapports d'importation
        $rapport_dupliques = array();
        $rapport_enregistres= array();
        $rapport_erreurs= array();

        $ligne = 1;//numero ligne excel
        // var_dump("import");die();
        /*  $this->validate($request, [
              'importation_excel'   =>  'required|mimes:xls, xlsx'
          ]);*/

        $path = $request->file('importation_excel')->getRealPath();
        $data = Excel::load($path)->get();

        if ($data->count() > 0) {
            // var_dump($data->toArray());die();
            foreach ($data->toArray() as $key => $value) {
                $ligne++;

                    //Si toute la ligne est vide ou tous les champs sont vide
                //Cas niveau vide
                if (($value['niveau'] == 'neant')){
                    $value['niveau']=null;
                }
                if ($value["nom"] == null && $value["prenom"] == null && $value["age"] == null && $value["adresse"] == null
                        && $value["region"] == null && $value["date_arrivee"] == null && $value["serigne"] == null
                        && $value["niveau"] == null && $value["pere"] == null && $value["prenom_nom_de_la_mere"] == null
                        && $value["tuteur"] == null && $value["telephone"] == null && $value["daara"] == null && $value["details"] == null)
                    {
                        //var_dump('ligne vide'); die();
                    }
                    else
                        {
                        $daara_id = null;
                        $daara_nom = null;
                        $dieuw = null;
                        $dieuw_id = null;
                        $age = null;
                        $niveau = null;
                        $date_naissance_talibe = null;
                        $avatar = null;

                        $date_naissance_talibe = null;
                        $date_arrivee = null;
                        $age = null;
                        $talibes = null;
                        $genre = 1; // Homme

                        $repetition = null; // donnees dupliquer
                            //var_dump($data); die();


                        //Recherche Daara correspondant
                        $daara_nom = $value['daara'];
                        if ((($daara_nom) && ($daara_nom != 'neant')) ){
                            $daara_id = DB::select('SELECT id From daaras where nom ilike (\''.$daara_nom.'\') limit 1');
                              //  ->where(('nom'), strtolower($daara_nom))->first();
                            $daara_id = $daara_id[0];
                            $daara_id = $daara_id->id;
                        }



                        //Recherche Dieuwrine correspondant
                        $dieuw = $value['serigne'];
                        //Recuperation distinct du nom et prenom du dieuwrine
                        $prenomArray = explode( " ",$dieuw, -1); //transformation d'une chaine de caractere en array
                        $prenomDieuwrine = implode(" ", $prenomArray); //transformation d'un array en chaine de caractrere
                        $nomDieuwrine = explode(" ", $dieuw)[count(explode(" ", $dieuw))-1];

                        if (($daara_nom) && ($daara_nom != 'neant')){//si daara est non existant
                            $dieuw_id = Dieuw::select('id')
                                ->where('prenom','ilike', $prenomDieuwrine)
                                ->where('nom','ilike', $nomDieuwrine)
                                ->where('daara_id', $daara_id)
                                ->first()
                            ;
                           $dieuw_id = $dieuw_id['id'];
                        }


                        $age = $value['age'];
                        $date_arrivee = $value['date_arrivee'];
                        if ($age) {
                            //permet de connaitre la date de naissance grace à l'age
                            $date_naissance_talibe = date("Y-01-01", strtotime("-" . $age . " year"));
                        }
                        if ($date_arrivee){
                            //permet de formater la date darrive
                            //$date_arrivee = \DateTime::createFromFormat('Y-m-d', $date_arrivee.'-01-01');
                            $date_arrivee = date($date_arrivee.'-01-01');
                        }
                        if ($value['genre']!=null && $value['genre'] != 1){
                            $genre = 0; //femme
                        }

                        //Cas niveau vide
                        if (($value['niveau']) || ($value['niveau'] != 'neant')){
                            $niveau = $value['niveau'];
                        }

                            //Cas avatar
                            if (($value['avatar']) || ($value['avatar'] != 'neant')){
                                $avatar = $value['avatar'];
                            }

                        $talibes = new Talibe();
                        //Si toutes les colonne sont vides
                            $repetition = DB::select('SELECT nom from talibes where lower(nom) ilike lower (\''.$value["nom"].'\')
                                    AND lower(prenom) ilike lower (\''.$value["prenom"].'\')
                                    AND lower(pere) ilike lower (\''.$value["pere"].'\')
                                    AND lower(mere) ilike lower (\''.$value["prenom_nom_de_la_mere"].'\')
                                    AND lower(tuteur) ilike lower (\''.$value["tuteur"].'\')
                                    AND daara_id = '.$daara_id.'
                                    AND dieuw_id = \''.$dieuw_id.'\'

                    ') ;
                            if ($repetition){//si le talibe existe deja
                                $rapport_dupliques[]= array(
                                    'numero' =>$ligne,
                                    'nom' => $value["nom"],
                                    'prenom' => $value["prenom"],
                                    'dieuw' => $value['serigne'],
                                    'daara' => $value['daara'],
                                    'pere' => $value['pere'],
                                    'mere' => $value['prenom_nom_de_la_mere'],
                                    'adresse' => $value['adresse'],
                                    'tuteur' => $value['tuteur'],
                                    'niveau' => $niveau
                                );
                            }
                            else{//Si le talibe n'est pas dupliqué
                                $talibes->fill([
                                    'nom' => $value["nom"],
                                    'prenom' => $value["prenom"],
                                    'daara_id' => $daara_id,
                                    'dieuw_id' => $dieuw_id,
                                    'genre' => $genre,
                                     'avatar'   => $avatar,
                                    'pere' => $value['pere'],
                                    'mere' => $value['prenom_nom_de_la_mere'],
                                    'datenaissance' => $date_naissance_talibe,
                                    'adresse' => $value['adresse'],
                                    'region' => $value['region'],
                                    'tuteur' => $value['tuteur'],
                                    'phone1' => $value['telephone'],
                                    'niveau' => $niveau,
                                    'arrivee' => $date_arrivee,
                                    'commentaire' => $value['details'],

                                ]);
                               try{
                                   $talibes->save();
                                   $rapport_enregistres[]= array(
                                       'numero' =>$ligne,
                                       'nom' => $value["nom"],
                                       'prenom' => $value["prenom"],
                                       'dieuw' => $value['serigne'],
                                       'daara' => $value['daara'],
                                       'pere' => $value['pere'],
                                       'mere' => $value['prenom_nom_de_la_mere'],
                                       'adresse' => $value['adresse'],
                                       'tuteur' => $value['tuteur'],
                                       'niveau' => $niveau
                                   );
                               }catch (\Exception $exception){
                                   $rapport_erreurs[]= array(
                                       'numero' =>$ligne,
                                       'nom' => $value["nom"],
                                       'prenom' => $value["prenom"],
                                       'dieuw' => $value['serigne'],
                                       'daara' => $value['daara'],
                                       'pere' => $value['pere'],
                                       'mere' => $value['prenom_nom_de_la_mere'],
                                       'adresse' => $value['adresse'],
                                       'tuteur' => $value['tuteur'],
                                       'niveau' => $niveau
                                   );
                               }
                            }
                    }
            }
        }
        if (count($rapport_enregistres)!=0){
            session()->flash('message_enregistrer', 'Données enregistrées avec succées');
            Session::flash('rapport_enregistres', $rapport_enregistres);
        }
        if ( count($rapport_dupliques)!=0){
            session()->flash('message_dupliquer', 'Il exite des données dupliquées');
            Session::flash('rapport_dupliques', $rapport_dupliques);
        }
        if (count($rapport_erreurs)!=0){
            session()->flash('message_erreur', 'Il existe des erreurs dans les données');
            Session::flash('rapport_erreurs', $rapport_erreurs);
        }
        return redirect()->route('talibe.index');

    }

    function importation_dieuwrine(Request $request)
    {

        $path = $request->file('importation_excel')->getRealPath();
        $data = Excel::load($path)->get();

        $daara = null;
        $daara_nom = null;
        $insert_data[] = array();
        if ($data->count() > 0) {
            // var_dump($data->toArray());die();
            foreach ($data->toArray() as $key => $value) {
                if ($value["nom"] != null) {
                    $daara_nom = $value['daara'];
                    $daara = Daara::select('id')->where('nom', $daara_nom)->first();
                    //var_dump($daara['id']);die();

                    $dieuws = new Dieuw();
                    $dieuws->fill([

                        'nom' => $value["nom"],
                        'prenom' => $value["prenom"],
                        'adresse' => $value['adresse'],
                        'daara_id' => $daara['id'],
                        'genre' => 1
                    ]);
                }

                $dieuws->save();

                $insert_data[] = array(
                    'nom' => $value["nom"],
                    'prenom' => $value["prenom"],
                    'adresse' => $value['adresse'],
                    //'daara_id'     => $daara,
                    'genre' => 1,
                    'lon' => null,
                    'image' => null
                );
                // }
            }
            if (!empty($insert_data)) {
                // DB::table('daaras')->insert($insert_data);
                //var_dump($insert_data); die();
            }
        }
        var_dump($insert_data);
        die();
        return back();

    }

    function importation(Request $request)
    {
        // var_dump("import");die();
        /*  $this->validate($request, [
              'importation_excel'   =>  'required|mimes:xls, xlsx'
          ]);*/

        $path = $request->file('importation_excel')->getRealPath();
        $data = Excel::load($path)->get();

        //var_dump($data); die();
        $insert_data[] = array();
        if ($data->count() > 0) {
            // var_dump($data->toArray());die();
            foreach ($data->toArray() as $key => $value) {
                //var_dump($value); die();
                // foreach ($value as $row){
                //  var_dump($row['nom']); die();
                if ($value["nom"] != null) {
                    /*  $insert_data[] = array(
                          'nom' => $value["nom"],
                          'lat' => null,
                          'lon' => null,
                          'creation' => null,
                          'dieuw' => $value['dieuw'],
                          'image' => null,
                          'phone' => $value['phone']
                      );*/
                    $daara = new Daara();
                    $daara->fill([

                        'nom' => $value["nom"],
                        'dieuw' => $value["dieuw"],
                        'creation' => null,
                        'phone' => $value["phone"],
                        'lat' => null,
                        'lon' => null,
                        'image' => null
                    ]);
                }

                $daara->save();
                // }
            }
            if (!empty($insert_data)) {
                // DB::table('daaras')->insert($insert_data);
                //var_dump($insert_data); die();
            }
        }
        // var_dump($data); die();
        return back();

    }
}
