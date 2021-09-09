<?php

namespace App\Http\Controllers;

use App\Daara;
use App\Tarbiya;
use Illuminate\Http\Request;
use Validator;
use DB;
use Session;
use Excel;

class TarbiyaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tarbiya.index',['tarbiyas' => Tarbiya::all()]) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tarbiya.create', ['tarbiyas' => Tarbiya::all(), 'daaras'=>Daara::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'prenom' => 'required',
            'nom'    => 'required',
            'genre' => 'required',
            'daara_id'=>'required',
        ],[
            'prenom.required'   => 'Le prénom est requis',
            'nom.required'   => 'Le nom est requis',
            'genre.required'   => 'Le genre est requis',

        ]);

        $tarbiya = new Tarbiya($request->except(['datenaissance','arrivee'])) ;

        $tarbiya->arrivee = app_date_reverse($request->arrivee,'/','-');

        $tarbiya->datenaissance = app_date_reverse($request->datenaissance,'/','-');

        if($request->hasFile('avatar'))
        {
            $validator->after(function() use($request,$tarbiya){

                if(!$request->file('avatar')->isValid())
                {
                    $validator->errors()->add('avatar', 'Erreur: Veuillez joindre limage à nouveau');
                }
                else
                {
                    $path = $request->avatar->store('tarbiya', ['disk' => 'my_files']);

                    $tarbiya->avatar = app_real_filename($path);
                }
            });
        }
        else
        {
            $tarbiya->avatar = intval($tarbiya->genre) === 1 ? 'user_male.ico' : 'user_female.ico';
        }

        if($validator->fails())

            return back()->withErrors($validator);

        $tarbiya->save();

        session()->flash('tarbiyaEvent', 'Le Ngongo tarbiya '.$tarbiya->fullname().' a été bien ajouté');
        $tarbiya = Tarbiya::latest()->first();
        $id = $tarbiya->id;

        return redirect()->route('tarbiya.show', ['id' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('tarbiya.show',['tarbiya' => Tarbiya::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('tarbiya.edit', ['tarbiya' => Tarbiya::findOrFail($id),
            'daaras' => Daara::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            'prenom' => 'required',
            'nom'    => 'required',
            'genre' => 'required',
            'daara_id'=> 'required'
        ],[
            'prenom.required'   => 'Le prénom est requis',
            'nom.required'   => 'Le nom est requis',
            'genre.required'   => 'Le genre est requis'
        ]);

        $tarbiya = Tarbiya::findOrFail($id);

        $tarbiya->fill([

            'prenom'    => $request->prenom,
            'nom'       => $request->nom,
            'genre'     => $request->genre,
            'datenaissance' => app_date_reverse($request->datenaissance,'/','-'),
            'lieunaissance' => $request->lieunaissance,
            'region'        => $request->region,
            'phone1'    => $request->phone1,
            'phone2'    => $request->phone2,
            'pere'      => $request->pere,
            'mere'      => $request->mere,
            'tuteur'    => $request->tuteur,
            'adresse'   => $request->adresse,
            'daara_id'  => $request->daara_id,
            'commentaire'   => $request->commentaire,
            'arrivee'   =>  app_date_reverse($request->arrivee,'/','-')
        ]);

        if($request->hasFile('avatar'))
        {
            $validator->after(function() use($request, $tarbiya){

                if(!$request->file('avatar')->isValid()){

                    $validator->arrors()->add('avatar','Erreur: Veuillez joindre l\'image à nouveau');

                }else{

                    $path =  $request->avatar->store('tarbiya', ['disk' => 'my_files']);
                    $tarbiya->avatar = app_real_filename($path);
                }
            });
        }

        if($validator->fails())

            return back()->withErrors($validator);

        $tarbiya->save();

        session()->flash('tarbiyaEvent','Le profil du ndongo tarbiya '.$tarbiya->fullname().' a été bien mis à jour');

        return redirect()->route('tarbiya.show', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tarbiya = Tarbiya::findOrFail($id);

        $name = $tarbiya->fullname();

        $tarbiya->delete();

        session()->flash('tarbiyaEvent', 'Le ndongo tarbiya '.$name. ' a été supprimé avec succès');

        return redirect()->route('tarbiya.index');
    }

    /**
     * Importation par fichier excel des ndongos tarbiyas
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function importation_tarbiya(Request $request){
        if (!$request->file()){
            return redirect()->route('tarbiya.index');
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
                $tarbiyas = null;

                //Si toute la ligne est vide ou tous les champs sont vide
                if ($value["nom"] == null && $value["prenom"] == null && $value["age"] == null && $value["adresse"] == null
                    && $value["region"] == null && $value["date_arrivee"] == null && $value["pere"] == null
                    && $value["prenom_nom_de_la_mere"] == null && $value["tuteur"] == null && $value["telephone"] == null
                    && $value["daara"] == null &&  $value["genre"]==null  && $value["details"] == null)
                {
                    //var_dump('ligne vide'); die();
                }
                else
                {
                    $daara_id = null;
                    $daara_nom = null;
                    $age = null;
                    $niveau = null;
                    $date_naissance_tarbiya = null;

                    $date_arrivee = null;
                    $age = null;
                    $tarbiyas = null;
                    $genre = 1; // Homme

                    $repetition = null; // donnees dupliquer
                    //var_dump($data); die();


                    //Recherche Daara correspondant
                    $daara_nom = $value['daara'];
                    if ((($daara_nom) && ($daara_nom != 'neant')) ){
                        $daara_id = Daara::select('id')->where('nom','ilike', $daara_nom)->first();
                        $daara_id = $daara_id['id'];
                    }


                    $age = $value['age'];
                    $date_arrivee = $value['date_arrivee'];
                    if ($age) {
                        //permet de connaitre la date de naissance grace à l'age
                        $date_naissance_tarbiya = date("Y-01-01", strtotime("-" . $age . " year"));
                    }
                    if ($date_arrivee){
                        //permet de formater la date darrive
                        $date_arrivee = date($date_arrivee.'-01-01');
                    }
                    if ($value['genre']!=null && $value['genre'] != 1){
                        $genre = 0; //femme
                    }


                    $tarbiyas=null;
                    //var_dump($date_arrivee);die();
                    $tarbiyas = new Tarbiya();

                    $repetition=null;
                    //Si toutes les colonne sont vides
                    $nom = null;
                    $nom = $value['nom'];
                    $repetition = DB::select('SELECT nom from tarbiyas where lower(nom) ilike lower (\''.$nom.'\')
                                    AND lower(prenom) ilike lower (\''.$value["prenom"].'\')
                                    AND lower(pere) ilike lower (\''.$value["pere"].'\')
                                    AND lower(mere) ilike lower (\''.$value["prenom_nom_de_la_mere"].'\')
                                    AND lower(tuteur) ilike lower (\''.$value["tuteur"].'\')
                                    AND daara_id = '.$daara_id.'
                    ') ;

                    if ($repetition){//si le talibe existe deja
                        //var_dump("dupliquer");die();
                        $rapport_dupliques[]= array(
                            'numero' =>$ligne,
                            'nom' => $value["nom"],
                            'prenom' => $value["prenom"],
                            'daara' => $value['daara'],
                            'pere' => $value['pere'],
                            'mere' => $value['prenom_nom_de_la_mere'],
                            'adresse' => $value['adresse'],
                            'tuteur' => $value['tuteur']
                        );
                    }
                    else{//Si le talibe n'est pas dupliqué
                        $tarbiyas->fill([
                            'nom' => $value["nom"],
                            'prenom' => $value["prenom"],
                            'daara_id' => $daara_id,
                            'genre' => $genre,
                            // 'avatar'   => ,
                            'pere' => $value['pere'],
                            'mere' => $value['prenom_nom_de_la_mere'],
                            'datenaissance' => $date_naissance_tarbiya,
                            'adresse' => $value['adresse'],
                            'region' => $value['region'],
                            'tuteur' => $value['tuteur'],
                            'phone1' => $value['telephone'],
                            'arrivee' => $date_arrivee,
                            'commentaire' => $value['details'],

                        ]);
                        try{
                            $tarbiyas->save();
                            // var_dump("enregistrer");die();
                            $rapport_enregistres[]= array(
                                'numero' =>$ligne,
                                'nom' => $value["nom"],
                                'prenom' => $value["prenom"],
                                'daara' => $value['daara'],
                                'pere' => $value['pere'],
                                'mere' => $value['prenom_nom_de_la_mere'],
                                'adresse' => $value['adresse'],
                                'tuteur' => $value['tuteur']
                            );
                        }catch (\Exception $exception){
                            $rapport_erreurs[]= array(
                                'numero' =>$ligne,
                                'nom' => $value["nom"],
                                'prenom' => $value["prenom"],
                                'daara' => $value['daara'],
                                'pere' => $value['pere'],
                                'mere' => $value['prenom_nom_de_la_mere'],
                                'adresse' => $value['adresse'],
                                'tuteur' => $value['tuteur']
                            );
                            //var_dump("catch"); die();
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
        return redirect()->route('tarbiya.index');

    }

}
