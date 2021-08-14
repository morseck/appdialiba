<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DaarasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jalibatou = [
            'nom' => 'Jalibatou',
            'dieuw' => 'Massaere Ndiaye',
            'phone' => '77 853 56 29'
        ];

        $keurMameDiarra = [
            'nom' => 'Keur Mame Diarra',
            'dieuw' => 'Serigne Moustapha Gueye',
            'phone' => '77 346 50 29'
        ];

        $taiba = [
            'nom' => 'Taiba',
            'dieuw' => 'Serigne Amsatou Diané',
            'phone' => '77 434 34 35'
        ];

        $keurMakhoudia = [
            'nom' => 'Keur Makhoudia',
            'dieuw' => 'Souleymane Wane',
            'phone' => '77 787 57 02'
        ];

        $minanou = [
            'nom' => 'Minanou',
            'dieuw' => 'neant',
            'phone' => 'neant'
        ];

        $toubaMouride = [
            'nom' => 'Touba Mouride',
            'dieuw' => 'neant',
            'phone' => 'neant'
        ];

        $mounawirou = [
            'nom' => 'Mounawirou',
            'dieuw' => 'neant',
            'phone' => 'neant'
        ];

        $daaras = array($jalibatou, $keurMameDiarra,$taiba, $keurMakhoudia, $minanou, $toubaMouride, $mounawirou);

        for ($i=0; $i<count($daaras); $i++){
            DB::table('daaras')->insert([
                'nom' => $daaras[$i]['nom'],
                'dieuw' => $daaras[$i]['dieuw'],
                'phone' => $daaras[$i]['phone']
            ]);
        }

       // factory(App\Daara::class,10)->create();
    }
}
