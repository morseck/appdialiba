<?php

namespace App\Http\Controllers;

USE App\Daara;
use Validator;
use Illuminate\Http\Request;

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
                'creation'  =>  'bail|required',
            ],[
                'nom.required'      => 'Le nom du Daara est requis',
                'nom.unique'        => 'Le nom daara '.$request->nom.' existe déjà',
                'dieuw.unique'      => 'Le nom du dieuwrigne est requis',
                'phone.unique'      => ' Le numéro '.$request->phone. ' existe déjà',
                'creation.unique'   => 'La date de création du Daara est requise'
            ]);

        $daara = new Daara();

        $daara->fill([

            'nom'       => $request->nom,
            'dieuw'     => $request->dieuw,
            'creation'  => app_date_reverse($request->creation,'/','-'),
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
                    $path = $request->image->store('public/daaras');

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
            'creation'  =>  'bail|required',
        ],[
            'nom.required'      => 'Le nom du Daara est requis',
            'nom.unique'        => 'Le nom d '.$request->nom.' est déjà pris',
            'dieuw.unique'      => 'Le nom du dieuwrigne est requis',
            'phone.unique'      => ' Le numéro '.$request->phone. 'existe déjà',
            'creation.unique'   => 'La date de création du Daara est requise'
        ]);

        $daara = Daara::findOrFail($id);

        $daara->nom   = $request->nom;
        $daara->dieuw = $request->dieuw;
        $daara->phone = $request->phone;
        $daara->creation = app_date_reverse($request->creation,'/','-');
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
                    $path = $request->image->store('public/daaras');

                    $daara->image = $path;
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

        $dname   = $daara->nom;

        $talibes = $daara->talibes;

        return view($view,compact('talibes','dname','id'));
     }
}