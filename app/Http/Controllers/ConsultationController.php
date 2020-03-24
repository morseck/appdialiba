<?php

namespace App\Http\Controllers;

use App\Consultation;
use Illuminate\Http\Request;
use App\Talibe;
use Excel;
use DB;
use Illuminate\Support\Facades\App;
use Validator;
use Session;


class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('consultation.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('consultation.create');
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

            'medecin_id' => 'required',
            'talibe_id' => 'required',
             'lieu' => 'required',
            'date'   => 'required',
            'avis'   => 'required',
            //'maladie' => 'required',
            // 'datenaissance' => 'required'
        ], [
            'medecin_id.required' => 'Le médecin est requis',
            'talibe_id.required' => 'Le nom est requis',
            'lieu.required' => 'Le lieu est requis',
            'date.required' => 'La date est requise',
            'avis.required' => 'L\'avis est requis',
            //'maladie.required' => 'Le nom de la mère est requis'
        ]);

        $consultation = new Consultation($request->except(['date']));
        $talibe = Talibe::findOrFail($request->talibe_id);

        $consultation->date = app_date_reverse($request->date, '/', '-');

        if ($validator->fails()){
            return back()->withErrors($validator);
        }
        $consultation->save();

        session()->flash('consultationEvent', 'La consultation a été bien faite pour le talibé ' . $talibe->fullname());

        return redirect()->route('talibe.show', ['id' => $request->talibe_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function show(Consultation $consultation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function edit(Consultation $consultation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consultation $consultation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultation $consultation)
    {
        //
    }
}
