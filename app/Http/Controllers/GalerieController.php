<?php

namespace App\Http\Controllers;

use App\Talibe;
use Illuminate\Http\Request;

class GalerieController extends Controller
{
    public function index()
    {
    	return view('galerie.index', ['talibes' => Talibe::orderBy('prenom')->paginate(12)]);
    }
}
