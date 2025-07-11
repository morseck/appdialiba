<?php

// app/Console/Commands/CreateUserAccountsCommand.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Medecin;
use App\Dieuw;
use App\Role;

class CreateUserAccountsCommand extends Command
{
    protected $signature = 'users:create-accounts {--type=all : Type de comptes à créer (medecin, dieuw, all)}';
    protected $description = 'Créer des comptes utilisateurs pour les médecins et dieuws existants';

    public function handle()
    {
        $type = $this->option('type');

        $this->info('Création des comptes utilisateurs...');

        // Créer les rôles si ils n'existent pas
        $this->createRoles();

        if ($type === 'all' || $type === 'medecin') {
            $this->createMedecinAccounts();
        }

        if ($type === 'all' || $type === 'dieuw') {
            $this->createDieuwAccounts();
        }

        $this->info('Opération terminée !');
    }

    private function createRoles()
    {
        // Créer le rôle médecin
        if (!Role::where('name', 'medecin')->exists()) {
            Role::create([
                'name' => 'medecin',
                'display_name' => 'Médecin',
                'description' => 'Accès aux fonctionnalités médicales'
            ]);
            $this->info('Rôle "medecin" créé.');
        }

        // Créer le rôle dieuw
        if (!Role::where('name', 'dieuw')->exists()) {
            Role::create([
                'name' => 'dieuw',
                'display_name' => 'Dieuw',
                'description' => 'Accès aux fonctionnalités d\'enseignement'
            ]);
            $this->info('Rôle "dieuw" créé.');
        }
    }

    private function createMedecinAccounts()
    {
        $medecins = Medecin::withoutUserAccount()->get();
        $created = 0;
        $errors = 0;

        $this->info("Création des comptes pour {$medecins->count()} médecins...");

        foreach ($medecins as $medecin) {
            try {
                if (!$medecin->email) {
                    $this->warn("Médecin {$medecin->fullname()} n'a pas d'email. Ignoré.");
                    continue;
                }

                $user = $medecin->createUserAccount();
                $created++;
                $this->line("✓ Compte créé pour Dr. {$medecin->fullname()} ({$user->email})");
            } catch (\Exception $e) {
                $errors++;
                $this->error("✗ Erreur pour {$medecin->fullname()}: " . $e->getMessage());
            }
        }

        $this->info("Médecins: {$created} comptes créés, {$errors} erreurs.");
    }

    private function createDieuwAccounts()
    {
        $dieuws = Dieuw::withoutUserAccount()->get();
        $created = 0;
        $errors = 0;

        $this->info("Création des comptes pour {$dieuws->count()} dieuws...");

        foreach ($dieuws as $dieuw) {
            try {
                $user = $dieuw->createUserAccount();
                $created++;
                $this->line("✓ Compte créé pour {$dieuw->getTitleStart()} {$dieuw->fullname()} ({$user->email})");
            } catch (\Exception $e) {
                $errors++;
                $this->error("✗ Erreur pour {$dieuw->fullname()}: " . $e->getMessage());
            }
        }

        $this->info("Dieuws: {$created} comptes créés, {$errors} erreurs.");
    }
}
