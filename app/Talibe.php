<?php

namespace App;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Talibe extends Model
{
    use SoftDeletes, Loggable;

    protected $fillable=['prenom','nom','genre','pere','mere','datenaissance','lieunaissance','adresse','region','dieuw_id',
        'tuteur','phone1','phone2','arrivee','depart','deces','commentaire','avatar','niveau','daara_id', 'matricule'
    ];

    /**
     * Boot method pour générer automatiquement le matricule
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($talibe) {
            $talibe->matricule = $talibe->generateMatricule();
        });

        static::updating(function ($talibe) {
            if (empty($talibe->matricule)) {
                $talibe->matricule = $talibe->generateMatricule();
            }
        });
    }
    function getFirstLetter($string) {
        // Supprime les espaces au début et à la fin
        $string = trim($string);

        // Vérifie si la chaîne n'est pas vide
        if ($string === '') {
            return '';
        }

        // Retourne la première lettre
        return mb_substr($string, 0, 1, 'UTF-8');
    }


    /**
     * Génère le matricule selon le format : SHM + prenom + nom + date_arrivee + timestamp
     * Version améliorée avec meilleure gestion d'erreur
     * @return string
     */
    public function generateMatricule()
    {
        try {
            // Nettoyer et formater prénom et nom (enlever espaces et caractères spéciaux)
            $prenom = $this->cleanString($this->getFirstLetter($this->prenom ?? ''));
            $nom = $this->cleanString($this->getFirstLetter($this->nom ?? ''));

            // Si prénom et nom sont vides après nettoyage, utiliser des valeurs par défaut
            if (empty($prenom)) {
                $prenom = 'inconnu';
            }
            if (empty($nom)) {
                $nom = 'inconnu';
            }

            // Gérer la date d'arrivée
            $dateArrivee = '197001'; // Valeur par défaut
            if (!empty($this->arrivee)) {
                try {
                    $dateArrivee = Carbon::parse($this->arrivee)->format('Ym');
                } catch (\Exception $e) {
                    \Log::warning("Erreur parsing date d'arrivée pour Talibe ID {$this->id}: " . $e->getMessage());
                    $dateArrivee = '19700101';
                }
            }

            // Générer timestamp actuel
            $timestamp = Carbon::now()->format('YmdHis'); // Enlever les millisecondes pour plus de simplicité

            // Construire le matricule
            $matricule = strtoupper('SHM_' . $prenom .'_'. $nom .'_'. $dateArrivee .'_'. $timestamp);

            // S'assurer de l'unicité
            $originalMatricule = $matricule;
            $counter = 1;
            while (static::where('matricule', $matricule)->exists()) {
                $matricule = $originalMatricule . '_' . $counter;
                $counter++;
            }

            return $matricule;

        } catch (\Exception $e) {
            \Log::error("Erreur lors de la génération du matricule pour Talibe ID {$this->id}: " . $e->getMessage());

            // Générer un matricule de secours basé sur l'ID et le timestamp
            $fallbackMatricule = 'SHM_TALIBE_' . $this->id . '_' . Carbon::now()->format('YmdHis');

            // Vérifier l'unicité du matricule de secours
            $counter = 1;
            $originalFallback = $fallbackMatricule;
            while (static::where('matricule', $fallbackMatricule)->exists()) {
                $fallbackMatricule = $originalFallback . '_' . $counter;
                $counter++;
            }

            return $fallbackMatricule;
        }
    }

    /**
     * Nettoie une chaîne de caractères (enlève accents, espaces, caractères spéciaux)
     * Version améliorée qui gère mieux les caractères UTF-8
     * @param string $string
     * @return string
     */
    private function cleanString($string)
    {
        if (empty($string)) {
            return '';
        }

        // S'assurer que la chaîne est en UTF-8
        if (!mb_check_encoding($string, 'UTF-8')) {
            $string = mb_convert_encoding($string, 'UTF-8', 'auto');
        }

        // Convertir en minuscules avec support UTF-8
        $string = mb_strtolower($string, 'UTF-8');

        // Tableau de correspondance pour les caractères accentués
        $accents = [
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'ý' => 'y', 'ÿ' => 'y',
            'ñ' => 'n',
            'ç' => 'c',
            // Ajout de caractères spéciaux africains/arabes si nécessaire
            'ñ' => 'n', 'ç' => 'c'
        ];

        // Remplacer les caractères accentués
        $string = strtr($string, $accents);

        // Méthode alternative plus robuste pour enlever les accents
        try {
            // Essayer d'abord avec iconv avec gestion d'erreur
            $cleaned = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
            if ($cleaned !== false) {
                $string = $cleaned;
            } else {
                // Si iconv échoue, utiliser la méthode de remplacement manuel
                $string = strtr($string, $accents);
            }
        } catch (\Exception $e) {
            // En cas d'erreur, utiliser seulement le remplacement manuel
            $string = strtr($string, $accents);
        }

        // Enlever tout sauf lettres et chiffres
        $string = preg_replace('/[^a-zA-Z0-9]/', '', $string);

        return $string;
    }

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
