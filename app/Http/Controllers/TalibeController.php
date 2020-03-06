<?php

namespace App\Http\Controllers;


use App\Daara;
use App\Dieuw;
use App\Talibe;
use App\Importation;
use Validator;
use Illuminate\Http\Request;
use DB;
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
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        $view = $request->query('view') === 'card' ? 'talibe.index-card' : 'talibe.index-table';
        $data_import = DB::table('import_taiba')->orderBy('id')->get();

        return view($view,['talibeList'=> Talibe::all(), 'nbr' => Talibe::all()->count(), 'data_import'=> $data_import]);
    }

    /**
     * Rechercher talibé à partir de son nom ou prenom
     * @param Request $request
     */
    public function recherche(Request $request){
        $recherche = $request->get("recherche");
        $talibeList = array();
        $nombre = 0;

        if($recherche){
           // var_dump($recherche); die();
            //$talibeList = Talibe::query();
            $talibeList = Talibe::query()->where(DB::raw("lower(CONCAT(prenom,' ', nom))"), 'LIKE' , strtolower('%'.$recherche.'%'))
                ->get();
            //var_dump($talibes);die();
           /* $talibeList = DB::table('talibes')
                ->where(DB::raw('CONCAT(prenom, " ", nom)'), 'LIKE' , '%'.$recherche.'%')
                ->get();*/
            $nombre = count($talibeList);
           // var_dump($resultats);die();
        }


        return view('talibe.recherche-table',['talibeList'=>$talibeList, 'recherche'=>$recherche, 'nombre'=>$nombre]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('talibe.create',[
                                        'dieuws' => Dieuw::all(),
                                        'daaras' => Daara::all(),
                                    ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $validator = Validator::make($request->all(), [

            'prenom' => 'required',
            'nom'    => 'required',
            'genre' => 'required',
            // 'region' => 'required',
            // 'pere'   => 'required',
            // 'mere'   => 'required',
            'daara_id'=>'required',
            // 'datenaissance' => 'required'
        ],[
            'prenom.required'   => 'Le prénom est requis',
            'nom.required'   => 'Le nom est requis',
            'gender.required'   => 'Le genre est requis',
            'region.required'   => 'La région est requise',
            'pere.required'   => 'Le nom du père est requis',
            'mere.required'   => 'Le nom de la mère est requis'
        ]);

        $talibe = new Talibe($request->except(['datenaissance','arrivee'])) ;

        $talibe->arrivee = app_date_reverse($request->arrivee,'/','-');

        $talibe->datenaissance = app_date_reverse($request->datenaissance,'/','-');

        if($request->hasFile('avatar'))
        {
            $validator->after(function() use($request,$talibe){

                if(!$request->file('avatar')->isValid())
                {
                    $validator->errors()->add('avatar', 'Erreur: Veuillez joindre limage à nouveau');
                }
                else
                {
                    $path = $request->avatar->store('public/talibes');

                    $talibe->avatar = app_real_filename($path);
                }
            });
        }
        else
        {
            $talibe->avatar = intval($talibe->genre) === 1 ? 'user_male.ico' : 'user_female.ico';
        }

        if($validator->fails())

           return back()->withErrors($validator);

        $talibe->save();

        session()->flash('talibeEvent', 'Le talibé '.$talibe->fullname().' a été bien ajouté');

        return redirect()->route('talibe.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('talibe.show',['talibe' => Talibe::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
          $validator = Validator::make($request->all(), [

            'prenom' => 'required',
            'nom'    => 'required',
            'genre' => 'required',
            // 'region' => 'required',
            // 'pere'   => 'required',
            // 'mere'   => 'required',
            'daara_id'=> 'required',
            // 'datenaissance' => 'required'
        ],[
            'prenom.required'   => 'Le prénom est requis',
            'nom.required'   => 'Le nom est requis',
            'gender.required'   => 'Le genre est requis',
            'region.required'   => 'La région est requise',
            'pere.required'   => 'Le nom du père est requis',
            'mere.required'   => 'Le nom de la mère est requis'
        ]);

        $talibe = Talibe::findOrFail($id);

        $talibe->fill([

            'prenom'    => $request->prenom,
            'nom'       => $request->nom,
            'gerne'     => $request->genre,
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
            'dieuw_id'  => $request->dieuw_id,
            'niveau'    => $request->niveau,
            'commentaire'   => $request->commentaire,
            'arrivee'   =>  app_date_reverse($request->arrivee,'/','-')
        ]);

        if($request->hasFile('avatar'))
        {
            $validator->after(function() use($request, $talibe){

                if(!$request->file('avatar')->isValid()){

                    $validator->arrors()->add('avatar','Erreur: Veuillez joindre l\'image à nouveau');

                }else{

                    $path = $request->avatar->store('public/talibes');
                    $talibe->avatar = app_real_filename($path);
                }
            });
        }

        if($validator->fails())
            
            return back()->withErrors($validator);

        $talibe->save();

        session()->flash('talibeEvent','Le profil du talibé '.$talibe->fullname().' a été bien mis à jour');

        return redirect()->route('talibe.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $talibe = Talibe::findOrFail($id);

        $name = $talibe->fullname();

        $talibe->delete();

        session()->flash('talibeEvent', 'Le Talibé '.$name. ' a été supprimé avec succès');

        return redirect()->route('talibe.index');
    }

    public function viewTrash() {

        $trashedTalibes = Talibe::onlyTrashed()->orderBy('prenom')->paginate(20);

        return view('talibe.trash', ['trashed' => $trashedTalibes]);
    }


    /**
     * importation fichier ndongo dans la table talibe
     * @param Request $request
     */
    function importation_talibe(Request $request){
        // var_dump("import");die();
        /*  $this->validate($request, [
              'importation_excel'   =>  'required|mimes:xls, xlsx'
          ]);*/

        $path = $request->file('importation_excel')->getRealPath();
        $data = Excel::load($path)->get();

        $daara_id = null;
        $daara_nom = null;
        $dieuw = null;
        $dieuw_id = null;
        $age = null;
        $date_naissance_talibe = null;
        //var_dump($data); die();
        $insert_data[]=array();
        if ($data->count() > 0){
            // var_dump($data->toArray());die();
            foreach ($data->toArray() as $key => $value){

                if ($value["nom"]!=null) {

                    $daara_nom = $value['daara'];
                    $daara_id = Daara::select('id')->where('nom', $daara_nom)->first();
                    $daara_id = $daara_id['id'];

                    $dieuw = $value['serigne'];
                    //$dieuw_id = Dieuw::select('id')->where('concat(prenom,nom)', $dieuw)->where('daara_id', $daara)->first();
                    $dieuw_id = Dieuw::select('id')
                        ->where(DB::raw('CONCAT(prenom, " ", nom)'), $dieuw)
                        ->where('daara_id', $daara_id)
                        ->first();
                    $dieuw_id = $dieuw_id['id'];
                    //var_dump($dieuw_id);die();
                    $age = $value['age'];
                    $date_naissance_talibe =null;
                    if ($age){
                        //permet de connaitre la date de naissance grace à l'age
                        $date_naissance_talibe = date("Y-01-01",strtotime("-".$age." year"));
                    }
                    var_dump($date_naissance_talibe);die();
                    $talibes = new Talibe();
                    $talibes->fill([
                        'nom'       => $value["nom"],
                        'prenom'    => $value["prenom"],
                        'daara_id'  => $daara_id,
                        'dieuw_id'  => $dieuw_id,
                        'genre'     => 1,
                       // 'avatar'   => ,
                        'pere'   => $value['pere'],
                        'mere'   => $value['prenom - nom de la mere'],
                        'datenaissance'   => $date_naissance_talibe,
                        'adresse'   => $value['adresse'],
                        'tuteur'   => $value['tuteur'],
                        'phone1'   => $value['telephone'],
                        'niveau'   => $value['niveau'],
                        //'arrivee'   => ,
                       // 'commentaire'   => ,

                    ]);
                }

                $talibes->save();

                $insert_data[] = array(
                    'nom'       => $value["nom"],
                    'prenom'     => $value["prenom"],
                    'adresse'  => $value['adresse'],
                    //'daara_id'     => $daara,
                    'genre'       => 1,
                    'lon'       => null,
                    'image'     => null
                );
                // }
            }
            if (!empty($insert_data)){
                // DB::table('daaras')->insert($insert_data);
                //var_dump($insert_data); die();
            }
        }
        var_dump($insert_data); die();
        return back();

    }





    function importation_dieuwrine(Request $request){
        // var_dump("import");die();
        /*  $this->validate($request, [
              'importation_excel'   =>  'required|mimes:xls, xlsx'
          ]);*/

        $path = $request->file('importation_excel')->getRealPath();
        $data = Excel::load($path)->get();

        $daara = null;
        $daara_nom = null;
        //var_dump($data); die();
        $insert_data[]=array();
        if ($data->count() > 0){
            // var_dump($data->toArray());die();
            foreach ($data->toArray() as $key => $value){
                if ($value["nom"]!=null) {
                    $daara_nom = $value['daara'];
                    $daara = Daara::select('id')->where('nom', $daara_nom)->first();
                    //var_dump($daara['id']);die();

                    $dieuws = new Dieuw();
                    $dieuws->fill([

                        'nom'       => $value["nom"],
                        'prenom'     => $value["prenom"],
                        'adresse'  => $value['adresse'],
                        'daara_id'     => $daara['id'],
                        'genre'       => 1
                    ]);
                }

                $dieuws->save();

                $insert_data[] = array(
                    'nom'       => $value["nom"],
                    'prenom'     => $value["prenom"],
                    'adresse'  => $value['adresse'],
                    //'daara_id'     => $daara,
                    'genre'       => 1,
                    'lon'       => null,
                    'image'     => null
                );
                // }
            }
            if (!empty($insert_data)){
                // DB::table('daaras')->insert($insert_data);
                //var_dump($insert_data); die();
            }
        }
        var_dump($insert_data); die();
        return back();

    }



    function importation(Request $request){
      // var_dump("import");die();
      /*  $this->validate($request, [
            'importation_excel'   =>  'required|mimes:xls, xlsx'
        ]);*/

        $path = $request->file('importation_excel')->getRealPath();
        $data = Excel::load($path)->get();

        //var_dump($data); die();
        $insert_data[]=array();
        if ($data->count() > 0){
           // var_dump($data->toArray());die();
            foreach ($data->toArray() as $key => $value){
                //var_dump($value); die();
               // foreach ($value as $row){
                  //  var_dump($row['nom']); die();
                    if ($value["nom"]!=null) {
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

                            'nom'       => $value["nom"],
                            'dieuw'     => $value["dieuw"],
                            'creation'  => null,
                            'phone'     => $value["phone"],
                            'lat'       => null,
                            'lon'       => null,
                            'image'     => null
                        ]);
                    }

                $daara->save();
               // }
            }
            if (!empty($insert_data)){
               // DB::table('daaras')->insert($insert_data);
                //var_dump($insert_data); die();
            }
        }
       // var_dump($data); die();
        return back();

    }
}
