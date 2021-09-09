<?php

namespace App\Http\Controllers;

use App\Talibe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GalerieController extends Controller
{
    public function index()
    {
        $talibes = DB::table('talibes')
            ->join('daaras', 'talibes.daara_id', '=', 'daaras.id')
            ->join('dieuws', 'talibes.dieuw_id', '=', 'dieuws.id')
            ->where('talibes.deleted_at', '=', null)
            ->select(
                'talibes.prenom as prenom',
                'talibes.nom as nom',
                'talibes.id as id',
                'talibes.avatar as avatar',
                'daaras.id as daara_id',
                'daaras.nom as daara_nom',
                'dieuws.nom as dieuw_nom',
                'dieuws.prenom as dieuw_prenom',
                'dieuws.id as dieuw_id'

            )
            ->orderBy('talibes.prenom')
            ->paginate(12);
    	return view('galerie.index', ['talibes' => $talibes]);
    }
}
