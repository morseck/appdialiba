<?php

namespace App\Http\Controllers;

USE App\Daara;
use Validator;
use Illuminate\Http\Request;
use DB;

class DaaraController extends Controller
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
        return view('daara.index',['daaraList' => Daara::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('daara.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->hasFile('image'));

        $validator = Validator::make($request->all(),
            [
                'nom'       =>  'bail|required|unique:daaras',
                'dieuw'     =>  'bail|required',
                'phone'     =>  'bail|required|unique:daaras',
            ],[
                'nom.required'      => 'Le nom du Daara est requis',
                'nom.unique'        => 'Le nom daara '.$request->nom.' existe déjà',
                'dieuw.unique'      => 'Le nom du dieuwrigne est requis',
                'phone.unique'      => ' Le numéro '.$request->phone. ' existe déjà',
                'creation.unique'   => 'La date de création du Daara est requise'
            ]);

        $daara = new Daara();
        $creation = null;
        if ($request->creation!=null){
            $creation ->app_date_reverse($request->creation,'/','-');
        }
        $daara->fill([

            'nom'       => $request->nom,
            'dieuw'     => $request->dieuw,
            'creation'  => $creation,
            'phone'     => $request->phone,
            'lat'       => $request->lat,
            'lon'       => $request->lon
        ]);

        if($request->hasFile('image'))
        {

            $validator->after(function() use($request,$daara)
            {
                if(!$request->file('image')->isValid())
                {
                    $validator->errors()->add('image','L image uploadé nest pas valide');
                }
                else
                {
                   // $path = $request->avatar->store('public/dieuws');

                    $path =  $request->image->store('daara', ['disk' => 'my_files']);

                    $daara->image = app_real_filename($path);
                }
            });
        }
        else
        {
            $daara->image = 'image daara';
        }

        if($validator->fails())

            return back()->withErrors($validator);

        $daara->save();

        $request->session()->flash('daaraEvent','Le Daara '.$daara->nom.' a été ajouté avec succès');

        return redirect()->route('daara.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('daara.edit', ['daara' => Daara::findOrFail($id)]);
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

        $validator = Validator::make($request->all(),[

            'nom'       =>  'bail|required|unique:daaras,nom,'.$id,
            'dieuw'     =>  'bail|required',
            'phone'     =>  'bail|required|unique:daaras,phone,'.$id,
        ],[
            'nom.required'      => 'Le nom du Daara est requis',
            'nom.unique'        => 'Le nom d '.$request->nom.' est déjà pris',
            'dieuw.unique'      => 'Le nom du dieuwrigne est requis',
            'phone.unique'      => ' Le numéro '.$request->phone. 'existe déjà',
            'creation.unique'   => 'La date de création du Daara est requise'
        ]);

        $daara = Daara::findOrFail($id);

        $creation = null;
        if ($request->creation!=null){
            $creation=app_date_reverse($request->creation,'/','-');
        }

        $daara->nom   = $request->nom;
        $daara->dieuw = $request->dieuw;
        $daara->phone = $request->phone;
        $daara->creation = $creation;
        $daara->lat   = $request->lat;
        $daara->lon   = $request->lon;

        if($request->hasFile('image'))
        {
            $validator->after(function() use($request,$daara)
            {
                if(!$request->file('image')->isValid())
                {
                    $validator->errors()->add('image','L image uploadé nest pas valide');
                }
                else
                {

                    $path = $request->image->store('daara', ['disk' => 'my_files']);
                    $daara->image = app_real_filename($path);

                    //$daara->image = $path;
                }
            });
        }

        if($validator->fails())
        {
            return back()->withErrors($validator);
        }

        $daara->save();

        $request->session()->flash('daaraEvent','Le Daara '.$daara->nom.' a été modifié avec succès');

        return redirect()->route('daara.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     /**
     * Returns the list of talibes in a given Daara.
     *
     */
     public function talibes(Request $request,$id)
     {
        $view    = $request->query('view') === 'card' ? 'daara.talibes-card' : 'daara.talibes-table';

        $daara   = Daara::findOrFail($id);
        $daara_info = array(
            'dieuw'=>$daara->dieuw,
            'telephone' => $daara->phone
        );

        $dname   = $daara->nom;

        $talibes = $daara->talibes;
        $dieuwrines = $daara->dieuws;
        $tarbiyas = $daara->tarbiyas;
         $parts = DB::select('SELECT COUNT(talibes.id) as poids, talibes.niveau FROM talibes INNER JOIN daaras ON talibes.daara_id=daaras.id WHERE daaras.id = '.$id.' AND daaras.deleted_at IS NULL GROUP BY talibes.niveau') ;
         $partDieuws = DB::select('SELECT COUNT(dieuws.id) as poids,CONCAT(dieuws.prenom,\' \', dieuws.nom) as fullname FROM dieuws INNER JOIN talibes on dieuws.id=talibes.dieuw_id INNER JOIN daaras on daaras.id=dieuws.daara_id WHERE dieuws.daara_id = '.$id.' AND dieuws.daara_id=daaras.id AND daaras.deleted_at IS NULL   GROUP BY fullname') ;
         $partRegions = DB::select('SELECT COUNT(talibes.id) as poids, talibes.region FROM talibes INNER JOIN daaras ON talibes.daara_id=daaras.id WHERE daaras.id = '.$id.' AND daaras.deleted_at IS NULL GROUP BY talibes.region') ;
         $partMaladies = DB::select('SELECT COUNT(*) as poids, consultations.maladie FROM consultations JOIN talibes ON talibes.id=consultations.talibe_id WHERE talibes.daara_id = '.$id.' AND  talibes.deleted_at IS NULL GROUP BY consultations.maladie') ;
         //$partDieuws = DB::select('SELEC  T COUNT(talibes.id) as poids, dieuws.prenom FROM  talibes,dieuws INNER JOIN daaras ON dieuws.daara_id=daaras.id WHERE daaras.id = '.$id.' AND dieuws.daara_id = '.$id.' AND daaras.deleted_at IS NULL GROUP BY dieuws.prenom') ;
         //var_dump(($partRegions));die();


         return view($view,compact('talibes','dieuwrines','tarbiyas','dname','id', 'parts', 'partDieuws', 'partRegions','partMaladies','daara_info'));
     }


    /**
     * Importation de fichier excel
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function importation(Request $request){
        // var_dump("import");die();
         $this->validate($request, [
              'importation_excel'   =>  'required|mimes:xls, xlsx'
          ]);

        $path = $request->file('importation_excel')->getRealPath();
        $data = Excel::load($path)->get();

        $insert_data[]=array();
        if ($data->count() > 0){
            foreach ($data->toArray() as $key => $value){
                if ($value["nom"]!=null) {
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
        }
        // var_dump($data); die();
        return back();

    }
}
