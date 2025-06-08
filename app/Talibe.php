<?php

namespace App;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Talibe extends Model
{
    use SoftDeletes, Loggable;

    protected $fillable=['prenom','nom','genre','pere','mere','datenaissance','lieunaissance','adresse','region','dieuw_id',
        'tuteur','phone1','phone2','arrivee','depart','deces','commentaire','avatar','niveau','daara_id'
    ];


    public function daara()
    {
        return $this->belongsTo('App\Daara');
    }

    public function dieuw()
    {
        return $this->belongsTo('App\Dieuw');
    }

    public function consultations()
    {
        return $this->hasMany('App\Consultation');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordonnances()
    {
        return $this->hasMany('App\Ordonnance');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historyTablibes()
    {
        return $this->hasMany('App\HistoryTalibe', 'talibe_id', 'id');
    }

    private function getGenreLettre()
    {
        return $this->genre ? '' : 'e';
    }


    /**
     * Récupère l'historique complet et formaté d'un Talibe
     * @return array
     */
    public function historyTalibe()
    {
        $histories = [];

        // Récupérer tous les enregistrements d'historique pour ce Talibe
        $historyRecords = $this->historyTablibes()->orderBy('created_at', 'desc')->get();

        foreach ($historyRecords as $record) {
            // Changement de Hizib
            if ($record->is_change_hizib) {
                $histories[] = [
                    'type' => 'hizib',
                    'message' => $this->fullname() . '  est passé de l\'hizib '.$this->getGenreLettre().' de '.$record->hizib_id. '  à l\'hizib '.$record->new_hizib_id,
                    'date' => $record->date_change_hizib,
                    'user' => $record->user_name_change_hizib,
                    'change' => $record->hizib_id,
                    'new' => $record->new_hizib_id,
                    'user_email' => $record->user_email_change_hizib,
                    'commentaire' => $record->commentaire,
                    'created_at' => $record->created_at
                ];
            }

            // Changement de Daara
            if ($record->is_change_daara) {
                $histories[] = [
                    'type' => 'daara',
                    'message' =>  $this->fullname() . ' a quitté  '.Daara::find($record->daara_id)->nom. ' pour rejoindre '.Daara::find($record->new_daara_id)->nom,
                    'date' => $record->date_change_daara,
                    'user' => $record->user_name_change_daara,
                    'change' => $record->daara_id,
                    'new' => $record->new_daara_id,
                    'user_email' => $record->user_email_change_daara,
                    'commentaire' => $record->commentaire,
                    'created_at' => $record->created_at
                ];
            }

            // Changement de Dieuw
            if ($record->is_change_dieuw) {
                $dieuw = Dieuw::find($record->dieuw_id);
                $new_dieuw = Dieuw::find($record->new_dieuw_id);

                $histories[] = [
                    'type' => 'dieuw',
                    'message' =>  $this->fullname() . ' a été transféré'.$this->getGenreLettre().'  de l\'enseignan(e) '.$dieuw->fullname(). '  à l\'enseignant(e) '.$new_dieuw->fullname(),
                    'date' => $record->date_change_dieuw,
                    'user' => $record->user_name_change_dieuw,
                    'change' => $record->dieuw_id,
                    'new' => $record->new_dieuw_id,
                    'user_email' => $record->user_email_change_dieuw,
                    'commentaire' => $record->commentaire,
                    'created_at' => $record->created_at
                ];
            }

            // Changement de Talibe (informations personnelles)
            if ($record->is_change_talibe) {
                $histories[] = [
                    'type' => 'talibe',
                    'message' => $record->user_name_change_talibe . ' a modifié les informations du talibe à la date du ' . $record->date_change_talibe,
                    'date' => $record->date_change_talibe,
                    'user' => $record->user_name_change_talibe,
                    'change' => $record->talibe_id,
                    'new' => $record->new_talibe_id,
                    'user_email' => $record->user_email_change_talibe,
                    'commentaire' => $record->commentaire,
                    'created_at' => $record->created_at
                ];
            }
        }

        // Trier par date décroissante (plus récent en premier)
        usort($histories, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return $histories;
    }

    public function fullname()
    {
        return ucfirst($this->prenom).' '.ucfirst($this->nom) ;
    }

    public function age()
    {
        $age = null;
        if ($this->datenaissance !=null){
            $date_naissance = app_date_reverse($this->datenaissance,'-','-');
            $age = new \DateTime(''.$date_naissance.'');
            $age = intval($age->diff(new \DateTime())->format('%Y'));

        }
        return $age;
    }



}


