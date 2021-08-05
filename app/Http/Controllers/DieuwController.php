<?php

namespace App\Http\Controllers;

use App\Dieuw;
use App\Daara;
use App\Talibe;
use App\Importation;
use Validator;
use Illuminate\Http\Request;
use DB;
use Session;
use Excel;

class DieuwController extends Controller
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
    public function index(Request $request)
    {
        $view = $request->query('view') === 'card' ? 'dieuw.index-card' : 'dieuw.index-table';

        return view($view,['dieuws' => Dieuw::paginate(10), 'nbr' => Dieuw::all()->count() ]) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dieuw.create', ['daaras' => Daara::all()]);
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

        $dieuw = new Dieuw($request->except(['datenaissance','arrivee'])) ;

        $dieuw->arrivee = app_date_reverse($request->arrivee,'/','-');

        $dieuw->datenaissance = app_date_reverse($request->datenaissance,'/','-');

        if($request->hasFile('avatar'))
        {
            $validator->after(function() use($request,$dieuw){

                if(!$request->file('avatar')->isValid())
                {
                    $validator->errors()->add('avatar', 'Erreur: Veuillez joindre limage à nouveau');
                }
                else
                {
                 $path = $request->avatar->store('dieuw', ['disk' => 'my_files']);

                    $dieuw->avatar = app_real_filename($path);
                }
            });
        }
        else
        {
            $dieuw->avatar = intval($dieuw->genre) === 1 ? 'user_male.ico' : 'user_female.ico';
        }

        if($validator->fails())

           return back()->withErrors($validator);

        $dieuw->save();

        session()->flash('dieuwEvent', 'Le dieuwrigne '.$dieuw->fullname().' a été bien ajouté');

        return redirect()->route('dieuw.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parts = DB::select('SELECT COUNT(talibes.id) as poids, talibes.niveau FROM daaras,talibes INNER JOIN dieuws ON talibes.dieuw_id=dieuws.id WHERE dieuws.id IS NOT NULL AND dieuws.id = '.$id.' AND talibes.dieuw_id='.$id.' AND talibes.daara_id IS NOT NULL AND talibes.dieuw_id IS NOT NULL AND daaras.id= talibes.daara_id GROUP BY talibes.niveau') ;
        $talibeList = Talibe::query()
            ->join('dieuws','talibes.dieuw_id','=','dieuws.id')
            ->join('daaras','daaras.id','=','talibes.daara_id')
            ->where('dieuws.id', '=', $id )
            ->where('talibes.daara_id', '!=', null)
            ->where('dieuws.id', '!=',null )
            ->get();
        //var_dump($parts); die();
       // var_dump(count($talibeList)); die();
        return view('dieuw.show',['dieuw' => Dieuw::findOrFail($id), 'parts'=>$parts, 'total'=>count($talibeList)]);
    }

    /**
     * Liste des talibes enseigne par un dieuwrine
     * @param $id = identifiant du dieuwrine
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function talibeByDieuw($id){
       $parts = DB::select('SELECT COUNT(talibes.id) as poids, talibes.niveau FROM daaras,talibes INNER JOIN dieuws ON talibes.dieuw_id=dieuws.id WHERE dieuws.id IS NOT NULL AND dieuws.id = '.$id.' AND talibes.dieuw_id='.$id.' AND talibes.daara_id IS NOT NULL AND talibes.dieuw_id IS NOT NULL AND daaras.id= talibes.daara_id GROUP BY talibes.niveau') ;
        $talibeList = Talibe::query()
           // ->join('talibes','talibes.id','=',null)
           ->join('daaras','daaras.id','=','talibes.daara_id')
            ->join('dieuws','talibes.dieuw_id','=','dieuws.id')
            ->where('dieuws.id', '=', $id )
            ->where('talibes.daara_id', '!=', null)
            ->where('dieuws.id', '!=',null)
            ->select('talibes.*')
            ->get();
        //var_dump($talibeList);die();
        $dieuw  = Dieuw::findOrFail($id);
        $dname  = $dieuw->fullname();
        return view('dieuw.talibe-by-dieuw',['dieuw' => $dieuw, 'talibes'=>$talibeList,'dname'=>$dname, 'parts'=>$parts]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('dieuw.edit', ['dieuw' => Dieuw::findOrFail($id),
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

        $dieuw = dieuw::findOrFail($id);

        $dieuw->fill([

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
            $validator->after(function() use($request, $dieuw){

                if(!$request->file('avatar')->isValid()){

                     $validator->arrors()->add('avatar','Erreur: Veuillez joindre l\'image à nouveau');

                }else{


                    $path = $request->avatar->store('dieuw', ['disk' => 'my_files']);
                    $dieuw->avatar = app_real_filename($path);
                }
            });
        }

        if($validator->fails())

            return back()->withErrors($validator);

        $dieuw->save();

        session()->flash('dieuwEvent','Le profil du dieuw '.$dieuw->fullname().' a été bien mis à jour');

        return redirect()->route('dieuw.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dieuw = Dieuw::findOrFail($id);

        $name = $dieuw->fullname();

        $dieuw->delete();

        session()->flash('dieuwEvent', 'Le Dieuw '.$name. ' a été supprimé avec succès');

        return redirect()->route('dieuw.index');
    }

    /**
     * Importation par fichier excel des dieuwrines
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function importation_dieuw(Request $request){
        if (!$request->file()){
            return redirect()->route('dieuw.index');
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
                $dieuwrines = null;

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
                    $date_naissance_dieuw = null;

                    $date_arrivee = null;
                    $age = null;
                    $dieuwrines = null;
                    $avatar = null;
                    $genre = 1; // Homme

                    $repetition = null; // donnees dupliquer
                    //var_dump($data); die();


                    //Recherche Daara correspondant
                    $daara_nom = $value['daara'];
                    if ((($daara_nom) && ($daara_nom != 'neant')) ){
                        $daara_id = Daara::select('id')->where(strtolower('nom'), strtolower($daara_nom))->first();
                        $daara_id = $daara_id['id'];
                    }


                    $age = $value['age'];
                    $date_arrivee = $value['date_arrivee'];
                    if ($age) {
                        //permet de connaitre la date de naissance grace à l'age
                        $date_naissance_dieuw = date("Y-01-01", strtotime("-" . $age . " year"));
                    }
                    if ($date_arrivee){
                        //permet de formater la date darrive
                        $date_arrivee = date($date_arrivee.'-01-01');
                    }
                    if ($value['genre']!=null && $value['genre'] != 1){
                        $genre = 0; //femme
                    }


                    $dieuwrines=null;
                    //var_dump($date_arrivee);die();
                    $dieuwrines = new Dieuw();

                    $repetition=null;
                    //Si toutes les colonne sont vides
                    $nom = null;
                    $nom = $value['nom'];

                    //Cas niveau vide
                    if (($value['avatar']) || ($value['avatar'] != 'neant')){
                        $avatar = $value['avatar'];
                    }

                    $repetition = DB::select('SELECT nom from dieuws where lower(nom) like lower (\''.$nom.'\')
                                    AND lower(prenom) like lower (\''.$value["prenom"].'\')
                                    AND lower(pere) like lower (\''.$value["pere"].'\')
                                    AND lower(mere) like lower (\''.$value["prenom_nom_de_la_mere"].'\')
                                    AND lower(tuteur) like lower (\''.$value["tuteur"].'\')
                                    AND daara_id like '.$daara_id.'
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
                        $dieuwrines->fill([
                            'nom' => $value["nom"],
                            'prenom' => $value["prenom"],
                            'daara_id' => $daara_id,
                            'genre' => $genre,
                            'avatar'   => $avatar,
                            'pere' => $value['pere'],
                            'mere' => $value['prenom_nom_de_la_mere'],
                            'datenaissance' => $date_naissance_dieuw,
                            'adresse' => $value['adresse'],
                            'region' => $value['region'],
                            'tuteur' => $value['tuteur'],
                            'phone1' => $value['telephone'],
                            'arrivee' => $date_arrivee,
                            'commentaire' => $value['details'],

                        ]);
                        try{
                            $dieuwrines->save();
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
        return redirect()->route('dieuw.index');

    }
}
