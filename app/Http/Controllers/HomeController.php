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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $parts = DB::select('SELECT COUNT(*) as poids, daaras.nom FROM talibes JOIN daaras ON talibes.daara_id=daaras.id WHERE daaras.deleted_at IS NULL GROUP BY talibes.daara_id,daaras.nom') ;

        return view('home', compact('parts'));
    }
}
