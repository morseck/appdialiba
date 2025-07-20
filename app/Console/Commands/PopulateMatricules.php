<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Talibe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PopulateMatricules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'talibes:populate-matricules {--force : Forcer la régénération même si matricule existe} {--batch=100 : Nombre d\'éléments à traiter par lot}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère les matricules pour tous les Talibes existants';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $force = $this->option('force');
        $batchSize = (int) $this->option('batch');

        $this->info('Début de la génération des matricules...');

        // Récupérer le nombre total de Talibes à traiter
        $query = Talibe::query();

        if ($force) {
            $totalCount = $query->count();
        } else {
            $totalCount = $query->where(function($q) {
                $q->whereNull('matricule')->orWhere('matricule', '');
            })->count();
        }

        $this->info("Nombre total de Talibes à traiter : {$totalCount}");

        if ($totalCount === 0) {
            $this->info('Aucun Talibe à traiter.');
            return 0;
        }

        $success = 0;
        $errors = 0;
        $processed = 0;
        $errorDetails = [];

        // Traitement par lots pour éviter les problèmes de mémoire
        $query->chunk($batchSize, function($talibes) use ($force, &$success, &$errors, &$processed, &$errorDetails, $totalCount) {
            foreach ($talibes as $talibe) {
                // Vérifier si on doit traiter ce Talibe
                if (!$force && !empty($talibe->matricule)) {
                    continue;
                }

                $processed++;

                // Affichage du progrès
                if ($processed % 50 === 0 || $processed === $totalCount) {
                    $this->info("Progression: {$processed}/{$totalCount}");
                }

                try {
                    // Vérifier les données essentielles
                    if (empty($talibe->prenom) && empty($talibe->nom)) {
                        $this->warn("Talibe ID {$talibe->id}: Prénom et nom vides");
                    }

                    $matricule = $talibe->generateMatricule();

                    // Mise à jour directe en base avec transaction
                    DB::transaction(function () use ($talibe, $matricule) {
                        DB::table('talibes')
                            ->where('id', $talibe->id)
                            ->update([
                                'matricule' => $matricule,
                                'updated_at' => now()
                            ]);
                    });

                    $success++;

                } catch (\Exception $e) {
                    $errors++;
                    $errorMessage = "Erreur pour Talibe ID {$talibe->id}: " . $e->getMessage();
                    $errorDetails[] = [
                        'id' => $talibe->id,
                        'prenom' => $talibe->prenom ?? 'NULL',
                        'nom' => $talibe->nom ?? 'NULL',
                        'error' => $e->getMessage()
                    ];

                    $this->error($errorMessage);
                    Log::error($errorMessage, [
                        'talibe_id' => $talibe->id,
                        'prenom' => $talibe->prenom,
                        'nom' => $talibe->nom,
                        'exception' => $e
                    ]);
                }
            }
        });

        $this->line('');
        $this->line('==========================================');
        $this->info("Génération terminée !");
        $this->info("Traités : {$processed}");
        $this->info("Succès : {$success}");

        if ($errors > 0) {
            $this->error("Erreurs : {$errors}");
            $this->line('');
            $this->error('Détails des erreurs:');
            foreach ($errorDetails as $detail) {
                $this->line("- ID {$detail['id']}: {$detail['prenom']} {$detail['nom']} -> {$detail['error']}");
            }
        }

        return $errors > 0 ? 1 : 0;
    }
}
