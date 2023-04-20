<?php

namespace App\Http\Controllers;

use App\Ordonnance;
use App\Talibe;
use Illuminate\Http\Request;
use Validator;

class OrdonnanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $validator = Validator::make($request->all(), [

            'file_ordonnance' => 'required',
        ],[
            'file_ordonnance.required'   => 'La photo de l\'ordonnace est obligatoire',
        ]);

        $ordonnance = new Ordonnance();

        $ordonnance->medecin_id = $request->medecin_id;
        $ordonnance->talibe_id = $request->talibe_id;
        $ordonnance->commentaire = $request->commentaire;
        $ordonnance->nom_hopital = $request->nom_hopital;
        $ordonnance->date_ordonnance = $request->date_ordonnance;
        //$talibe = Talibe::find($request->talibe_id);


        //dd($talibe);

        if($request->date){
            $ordonnance->date_ordonnance = app_date_reverse($request->date_ordonnance,'/','-');
        }

       // dd($request->hasFile('file_ordonnance'));
        if($request->hasFile('file_ordonnance'))
        {
            //$validator->after(function() use($request,$ordonnance){
                //dd("file");

                if(!$request->file('file_ordonnance')->isValid())
                {
                    $validator->errors()->add('file_ordonnance', 'Erreur: Veuillez joindre l\'image à nouveau');
                }
                else
                {
                   // dd("file");
                    $path = $request->file_ordonnance->store('ordonnances', ['disk' => 'my_files']);

                    $ordonnance->file_ordonnance = app_real_filename($path);
                }
           // });
        }

        if ($validator->fails()){
            return back()->withErrors($validator);
        }

        $ordonnance->save();

        session()->flash('ordonnanceEvent', 'L\'Ordonnance a été bien ajoutée pour le talibé ');

        return redirect()->route('talibe.show', ['id' => $request->talibe_id]);
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
        //
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
        //
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
}
