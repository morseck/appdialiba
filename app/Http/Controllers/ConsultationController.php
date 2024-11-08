<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\Medecin;
use Illuminate\Http\Request;
use App\Talibe;
use Excel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
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
        $view = 'consultation.index';
        $consultations = Consultation::select('date')
            ->GroupBy('date')
            ->OrderBy('date', 'desc');

        //l'ordre est primordial
        $nombreCampagneConsultation = count($consultations->get());
        $consultations =  $consultations->paginate(10);
        $numero = $consultations->currentPage() * $consultations->perPage() - $consultations->perPage() + 1;

        return view($view, [
            'consultations' => $consultations,
            'numero' => $numero,
            'nombreCampagneConsultation' => $nombreCampagneConsultation
        ]);
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
     * * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * * @param string $date
     * @return \Illuminate\Http\Response
     */
    public function showConsultationByDate($date)
    {
        $view = 'consultation.detail';

        $detailsConsultations = DB::table('talibes')
            ->join('consultations', 'talibes.id', '=', 'consultations.talibe_id')
            ->join('medecins', 'medecins.id', '=', 'consultations.medecin_id')
            ->join('daaras', 'daaras.id', '=', 'talibes.daara_id')
            ->where('consultations.date', 'ilike', $date)
            ->select(
                'talibes.id as talibe_id',
                'talibes.nom as talibe_nom',
                'talibes.prenom as talibe_prenom',
                'daaras.id as daara_id',
                'daaras.nom as daara_nom',
                'medecins.id as medecin_id',
                'medecins.nom as medecin_nom',
                'medecins.prenom as medecin_prenom',
                'medecins.spec as medecin_specialiste',
                'medecins.hopital as medecin_hopital',
                'consultations.id as consultation_id',
                'consultations.lieu as consultation_lieu',
                'consultations.maladie as consultation_maladie',
                'consultations.avis as consultation_avis',
                'consultations.date as consultation_date'
            );

        $totalConsultations = count($detailsConsultations->get());

        $listeConsultations = $detailsConsultations->paginate(25);

        //dd($listeConsultations);
        $numero = $listeConsultations->currentPage() * $listeConsultations->perPage() - $listeConsultations->perPage() + 1;

        return view($view, [
            'listeConsultations' => $listeConsultations,
            'numero' => $numero,
            'totalConsultations' => $totalConsultations,
            'date' => $date
        ]);
    }

    /**
     * * @param int $medecin_id
     * @return \Illuminate\Http\Response
     */
    public function showConsultationByMedecin($medecin_id)
    {
        $medecin = Medecin::findOrFail($medecin_id);

        $view = 'medecin.detail';

        $detailsConsultations = DB::table('talibes')
            ->join('consultations', 'talibes.id', '=', 'consultations.talibe_id')
            ->join('medecins', 'medecins.id', '=', 'consultations.medecin_id')
            ->join('daaras', 'daaras.id', '=', 'talibes.daara_id')
            ->where('consultations.medecin_id', '=', $medecin_id)
            ->orderBy('consultations.date', 'desc')
            ->select(
                'talibes.id as talibe_id',
                'talibes.nom as talibe_nom',
                'talibes.prenom as talibe_prenom',
                'daaras.id as daara_id',
                'daaras.nom as daara_nom',
                'consultations.id as consultation_id',
                'consultations.lieu as consultation_lieu',
                'consultations.maladie as consultation_maladie',
                'consultations.avis as consultation_avis',
                'consultations.date as consultation_date'
            );

        $totalConsultations = count($detailsConsultations->get());

        $listeConsultations = $detailsConsultations->paginate(25);

        $numero = $listeConsultations->currentPage() * $listeConsultations->perPage() - $listeConsultations->perPage() + 1;

        return view($view, [
            'listeConsultations' => $listeConsultations,
            'numero' => $numero,
            'totalConsultations' => $totalConsultations,
            'medecin' => $medecin
        ]);
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
