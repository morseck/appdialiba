<?php

namespace App\Http\Controllers;

use App\Dieuw;
use App\Daara;
use Validator;
use Illuminate\Http\Request;

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

        return view($view,['dieuws' => Dieuw::orderBy('prenom')->paginate(20), 'nbr' => Dieuw::all()->count() ]) ;
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
            'gender.required'   => 'Le genre est requis',

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
                    $path = $request->avatar->store('public/dieuws');

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
        return view('dieuw.show',['dieuw' => Dieuw::findOrFail($id)]);
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
            'gender.required'   => 'Le genre est requis'
        ]);

        $dieuw = dieuw::findOrFail($id);

        $dieuw->fill([

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
            'commentaire'   => $request->commentaire,
            'arrivee'   =>  app_date_reverse($request->arrivee,'/','-')
        ]);

        if($request->hasFile('avatar'))
        {
            $validator->after(function() use($request, $dieuw){

                if(!$request->file('avatar')->isValid()){

                     $validator->arrors()->add('avatar','Erreur: Veuillez joindre l\'image à nouveau');

                }else{

                    $path = $request->avatar->store('public/dieuws');
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
}
