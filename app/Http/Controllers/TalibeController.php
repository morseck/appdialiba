<?php

namespace App\Http\Controllers;


use App\Daara;
use App\Dieuw;
use App\Talibe;
use Validator;
use Illuminate\Http\Request;

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

        return view($view,['talibeList'=> Talibe::orderBy('prenom')->paginate(20), 'nbr' => Talibe::all()->count() ]);
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
}
