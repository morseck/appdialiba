<?php

namespace App\Http\Controllers;

use App\Medecin;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\DB;
use Validator;
use Session;

class MedecinController extends Controller
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
        $view = 'medecin.index';

        $diagramemeMedecin = DB::table('medecins')
            ->join('consultations', 'medecins.id', '=', 'consultations.medecin_id')
            ->groupBy('medecins.id')
            ->selectRaw('
                count(medecins.id) as medecin_total,
                medecins.nom as medecin_nom,
                medecins.prenom as medecin_prenom,
                medecins.hopital as medecin_hopital
            ')
            ->where( 'medecins.deleted_at', '=', null)
            ->get();

        //dd($diagramemeMedecin);
        return view($view,[
            'medecins' => Medecin::all(),
            'nbr' => Medecin::all()->count(),
            'diagramemeMedecin' => $diagramemeMedecin
            ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('medecin.create');
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
                'nom'       =>  'bail|required',
                'prenom'       =>  'bail|required',
                'spec'     =>  'bail|required',
                'phone'     =>  'bail|required|unique:medecins',
                'email'     =>  'bail|unique:medecins',
            ],[
                'nom.required'      => 'Le nom du médecin est requis',
                'prenom.required'      => 'Le prenom du médecin est requis',
                'spec.required'      => 'Le specialité du médecin est requis',
                'phone.unique'      => ' Le numéro '.$request->phone. ' existe déjà',
                'email.unique'      => ' L\'e-mail '.$request->email. ' existe déjà'
            ]);

        $medecin = new Medecin();

        $medecin->fill([

            'nom'       => $request->nom,
            'prenom'       => $request->prenom,
            'spec'     => $request->spec,
            'phone'  => $request->phone,
            'email'     => $request->email,
            'hopital'       => $request->hopital
        ]);

        if($request->hasFile('image'))
        {

            $validator->after(function() use($request,$medecin)
            {
                if(!$request->file('image')->isValid())
                {
                    $validator->errors()->add('image','L image uploadé nest pas valide');
                }
                else
                {
                    // $path = $request->avatar->store('public/dieuws');

                    $path =  $request->image->store('medecin', ['disk' => 'my_files']);

                    $medecin->image = app_real_filename($path);
                }
            });
        }
        else
        {
            $medecin->image = 'image medecin';
        }

        if($validator->fails()){
            return back()->withErrors($validator);
        }


        $medecin->save();
        $request->session()->flash('medecinEvent','Le medecin '.$medecin->prenom.' '.$medecin->nom.' a été ajouté avec succès');

        $medecin = Medecin::latest()->first();
        $id = $medecin->id;
        return redirect()->route('medecin.show', ['id' => $id]);
        //return redirect()->route('medecin.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $totalConsultation = count(DB::table('medecins')
            ->join('consultations', 'medecins.id', '=', 'consultations.medecin_id')
            ->where('consultations.medecin_id', '=', $id)
            ->get());
        return view('medecin.show', [
            'medecin' => Medecin::findOrFail($id),
            'totalConsultation' => $totalConsultation
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('medecin.edit', ['medecin' => Medecin::findOrFail($id)]);
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

            'nom'       =>  'bail|required',
            'prenom'       =>  'bail|required',
            'spec'     =>  'bail|required',
            'phone'     =>  'bail|required|unique:medecins,phone,'.$id,
            'email'       =>  'bail|required|unique:medecins,nom,'.$id,
        ],[
            'nom.required'      => 'Le nom du médecin est requis',
            'prenom.required'      => 'Le prenom du médecin est requis',
            'spec.required'      => 'Le specialité du médecin est requis',
            'phone.unique'      => ' Le numéro '.$request->phone. ' existe déjà',
            'email.unique'      => ' L\'e-mail '.$request->email. ' existe déjà'
        ]);

        $medecin = Medecin::findOrFail($id);

        $medecin->nom   = $request->nom;
        $medecin->prenom = $request->prenom;
        $medecin->spec = $request->spec;
        $medecin->phone = $request->phone;
        $medecin->email   = $request->email;
        $medecin->hopital   =  $request->hopital;

        if($request->hasFile('image'))
        {
            $validator->after(function() use($request,$medecin)
            {
                if(!$request->file('image')->isValid())
                {
                    $validator->errors()->add('image','L image uploadé nest pas valide');
                }
                else
                {

                    $path = $request->image->store('medecin', ['disk' => 'my_files']);
                    $medecin->image = app_real_filename($path);

                    //$medecin->image = $path;
                }
            });
        }

        if($validator->fails())
        {
            return back()->withErrors($validator);
        }

        $medecin->save();
        $request->session()->flash('medecinEvent','Le Medecin '.$medecin->prenom.' '.$medecin->nom.' a été modifié avec succès');
        return redirect()->route('medecin.show', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medecin = Medecin::findOrFail($id);

        $name = $medecin->fullname();

        $medecin->delete();

        session()->flash('medecinEvent', 'Le Médecin ' . $name . ' a été supprimé avec succès');

        return redirect()->route('medecin.index');
    }

    /**
     * Inmporation a partir d'un fichier excel dans la table medecin
     * @param Request $request
     */
    public function importation_medecin(Request $request){
        if (!$request->file()){
            return redirect()->route('medecin.index');
        }
        //Donnes sur les rapports d'importation
        $rapport_dupliques = array();
        $rapport_enregistres= array();
        $rapport_erreurs= array();

        $ligne = 1;//numero ligne excel
        // var_dump("import");die();
        /*  $this->validate($request, [
              'importation_excel'   =>  'required|mimes:xls, xlsx'
          ]);*/

        $path = $request->file('importation_excel')->getRealPath();
        $data = Excel::load($path)->get();

        if ($data->count() > 0) {
            // var_dump($data->toArray());die();
            foreach ($data->toArray() as $key => $value) {
                $ligne++;
                $medecins = null;

                //Si toute la ligne est vide ou tous les champs sont vide
                if ($value["nom"] == null && $value["prenom"] == null && $value["specialite"] == null && $value["telephone"] == null
                    && $value["email"] == null && $value["hopital"] == null)
                {
                    //var_dump('ligne vide'); die();
                }
                else
                {
                    $medecins = null;
                    $repetition = null; // donnees dupliquer

                    $medecins = new Medecin();

                    $repetition=null;
                    //Si toutes les colonne sont vides
                    $nom = null;
                    $nom = $value['nom'];
                    $repetition = DB::select('SELECT nom from medecins where lower(nom) like lower (\''.$nom.'\')
                                    AND lower(prenom) like lower(\''.$value["prenom"].'\')
                                    AND lower(phone) like lower(\''.$value["telephone"].'\')
                    ') ;

                    if ($repetition){//si le talibe existe deja
                        //var_dump("dupliquer");die();
                        $rapport_dupliques[]= array(
                            'numero' =>$ligne,
                            'nom' => $value["nom"],
                            'prenom' => $value["prenom"],
                            'spec' => $value['specialite'],
                            'phone' => $value['telephone'],
                            'hopital' => $value['hopital'],
                            'email' => $value['email']
                        );
                    }
                    else{//Si le talibe n'est pas dupliqué
                        $medecins->fill([
                            'nom' => $value["nom"],
                            'prenom' => $value["prenom"],
                            'spec' => $value['specialite'],
                            'phone' => $value['telephone'],
                            'hopital' => $value['hopital'],
                            'email' => $value['email']

                        ]);
                        try{
                            $medecins->save();
                            // var_dump("enregistrer");die();
                            $rapport_enregistres[]= array(
                                'numero' =>$ligne,
                                'nom' => $value["nom"],
                                'prenom' => $value["prenom"],
                                'spec' => $value['specialite'],
                                'phone' => $value['telephone'],
                                'hopital' => $value['hopital'],
                                'email' => $value['email']
                            );
                        }catch (\Exception $exception){
                            $rapport_erreurs[]= array(
                                'numero' =>$ligne,
                                'nom' => $value["nom"],
                                'prenom' => $value["prenom"],
                                'spec' => $value['specialite'],
                                'phone' => $value['telephone'],
                                'hopital' => $value['hopital'],
                                'email' => $value['email']
                            );
                            //var_dump("catch"); die();
                        }

                    }
                }
            }
        }
        if (count($rapport_enregistres)!=0){
            session()->flash('message_enregistrer', 'Données enregistrées avec succées');
            Session::flash('rapport_enregistres', $rapport_enregistres);
        }
        if ( count($rapport_dupliques)!=0){
            session()->flash('message_dupliquer', 'Il exite des données dupliquées');
            Session::flash('rapport_dupliques', $rapport_dupliques);
        }
        if (count($rapport_erreurs)!=0){
            session()->flash('message_erreur', 'Il existe des erreurs dans les données');
            Session::flash('rapport_erreurs', $rapport_erreurs);
        }
        return redirect()->route('medecin.index');
    }

}
