<?php

namespace App\Http\Controllers;

use DB;
use App\Daara;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('role:admin')->only(['index']);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $parts = DB::select('SELECT COUNT(*) as poids, daaras.nom FROM talibes JOIN daaras ON talibes.daara_id=daaras.id WHERE daaras.deleted_at IS NULL GROUP BY talibes.daara_id,daaras.nom') ;
        $partRegions = DB::select('SELECT COUNT(talibes.id) as poids, talibes.region FROM talibes INNER JOIN daaras ON talibes.daara_id=daaras.id WHERE daaras.deleted_at IS NULL GROUP BY talibes.region') ;
        $partNiveaux = DB::select('SELECT COUNT(talibes.id) as poids, talibes.niveau FROM talibes INNER JOIN daaras ON talibes.daara_id=daaras.id WHERE  daaras.deleted_at IS NULL GROUP BY talibes.niveau') ;
        $partDieuwrines = DB::select('SELECT COUNT(dieuws.id) as poids,CONCAT(dieuws.prenom,\' \', dieuws.nom, \' - \', daaras.nom) as fullname FROM dieuws INNER JOIN talibes on dieuws.id=talibes.dieuw_id INNER JOIN daaras on daaras.id=dieuws.daara_id WHERE dieuws.daara_id=daaras.id AND daaras.deleted_at IS NULL   GROUP BY fullname') ;
        $partTarbiyas = DB::select('SELECT COUNT(*) as poids, daaras.nom FROM tarbiyas JOIN daaras ON tarbiyas.daara_id=daaras.id WHERE daaras.deleted_at IS NULL GROUP BY tarbiyas.daara_id,daaras.nom') ;
        $partMedecins = DB::select('SELECT COUNT(*) as poids, medecins.spec FROM medecins WHERE medecins.deleted_at IS NULL GROUP BY medecins.spec') ;
        $partMaladies = DB::select('SELECT COUNT(*) as poids, consultations.maladie FROM consultations JOIN talibes ON talibes.id=consultations.talibe_id WHERE talibes.deleted_at IS NULL  GROUP BY consultations.maladie') ;


        return view('home', compact('parts', 'partRegions', 'partNiveaux', 'partDieuwrines', 'partTarbiyas','partMedecins', 'partMaladies'));
    }
}
