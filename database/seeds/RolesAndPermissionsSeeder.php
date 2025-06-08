<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;
use App\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Créer les permissions
        $permissions = [

            //Talibes
            [
                'name' => 'view-talibes',
                'display_name' => 'Voir les talibes',
                'description' => 'Peut voir tous les talibes'
            ],
            [
                'name' => 'create-talibes',
                'display_name' => 'Créer des talibes',
                'description' => 'Peut créer de nouveaux talibes'
            ],
            [
                'name' => 'edit-talibes',
                'display_name' => 'Éditer les talibes',
                'description' => 'Peut éditer tous les talibes'
            ],
            [
                'name' => 'edit-own-talibes',
                'display_name' => 'Éditer ses propres talibes',
                'description' => 'Peut éditer seulement ses propres talibes'
            ],
            [
                'name' => 'delete-talibes',
                'display_name' => 'Supprimer les talibes',
                'description' => 'Peut supprimer tous les talibes'
            ],
            [
                'name' => 'delete-own-talibes',
                'display_name' => 'Supprimer ses propres talibes',
                'description' => 'Peut supprimer seulement ses propres talibes'
            ],
            [
                'name' => 'view-talibes-archives',
                'display_name' => 'Voir les talibes archivés',
                'description' => 'Peut voir tous les talibes archivés'
            ],
            [
                'name' => 'restore-talibes-archives',
                'display_name' => 'Restaurer les talibes archivés',
                'description' => 'Peut restaurer tous les talibes archivés'
            ],

            //Daara
            [
                'name' => 'view-daara',
                'display_name' => 'Voir les daara',
                'description' => 'Peut voir tous les daara'
            ],
            [
                'name' => 'create-daara',
                'display_name' => 'Créer des daara',
                'description' => 'Peut créer de nouveaux daara'
            ],
            [
                'name' => 'edit-daara',
                'display_name' => 'Éditer les daara',
                'description' => 'Peut éditer tous les daara'
            ],
            [
                'name' => 'delete-daara',
                'display_name' => 'Supprimer les daara',
                'description' => 'Peut supprimer tous les daara'
            ],

            //Dieuwrine
            [
                'name' => 'view-dieuwrine',
                'display_name' => 'Voir les dieuwrine',
                'description' => 'Peut voir tous les dieuwrine'
            ],
            [
                'name' => 'create-dieuwrine',
                'display_name' => 'Créer des dieuwrine',
                'description' => 'Peut créer de nouveaux dieuwrine'
            ],
            [
                'name' => 'edit-dieuwrine',
                'display_name' => 'Éditer les dieuwrine',
                'description' => 'Peut éditer tous les dieuwrine'
            ],
            [
                'name' => 'delete-dieuwrine',
                'display_name' => 'Supprimer les dieuwrine',
                'description' => 'Peut supprimer tous les dieuwrine'
            ],

            //tarbiyatarbiya
            [
                'name' => 'view-tarbiya',
                'display_name' => 'Voir les tarbiya',
                'description' => 'Peut voir tous les tarbiya'
            ],
            [
                'name' => 'create-tarbiya',
                'display_name' => 'Créer des tarbiya',
                'description' => 'Peut créer de nouveaux tarbiya'
            ],
            [
                'name' => 'edit-tarbiya',
                'display_name' => 'Éditer les tarbiya',
                'description' => 'Peut éditer tous les tarbiya'
            ],
            [
                'name' => 'delete-tarbiya',
                'display_name' => 'Supprimer les tarbiya',
                'description' => 'Peut supprimer tous les tarbiya'
            ],

            //Medecin
            [
                'name' => 'view-medecin',
                'display_name' => 'Voir les medecin',
                'description' => 'Peut voir tous les medecin'
            ],
            [
                'name' => 'create-medecin',
                'display_name' => 'Créer des medecin',
                'description' => 'Peut créer de nouveaux medecin'
            ],
            [
                'name' => 'edit-medecin',
                'display_name' => 'Éditer les medecin',
                'description' => 'Peut éditer tous les medecin'
            ],
            [
                'name' => 'delete-medecin',
                'display_name' => 'Supprimer les medecin',
                'description' => 'Peut supprimer tous les medecin'
            ],


            //Dashbord
            [
                'name' => 'view-reports',
                'display_name' => 'Voir les rapports',
                'description' => 'Peut consulter les rapports'
            ],
            [
                'name' => 'view-diagramme',
                'display_name' => 'Voir les diagramme',
                'description' => 'Peut consulter les diagramme'
            ],

            //Utilisateur
            [
                'name' => 'view-user',
                'display_name' => 'Voir les user',
                'description' => 'Peut voir tous les user'
            ],
            [
                'name' => 'create-user',
                'display_name' => 'Créer des user',
                'description' => 'Peut créer de nouveaux user'
            ],
            [
                'name' => 'edit-user',
                'display_name' => 'Éditer les user',
                'description' => 'Peut éditer tous les user'
            ],
            [
                'name' => 'delete-user',
                'display_name' => 'Supprimer les user',
                'description' => 'Peut supprimer tous les user'
            ],

            //roleroles
            [
                'name' => 'view-roles',
                'display_name' => 'Voir les roles',
                'description' => 'Peut voir tous les roles'
            ],
            [
                'name' => 'create-roles',
                'display_name' => 'Créer des roles',
                'description' => 'Peut créer de nouveaux roles'
            ],
            [
                'name' => 'edit-roles',
                'display_name' => 'Éditer les roles',
                'description' => 'Peut éditer tous les roles'
            ],
            [
                'name' => 'delete-roles',
                'display_name' => 'Supprimer les roles',
                'description' => 'Peut supprimer tous les roles'
            ],

            //Autre
            [
                'name' => 'assign-roles',
                'display_name' => 'Assigner des rôles',
                'description' => 'Peut assigner des rôles aux utilisateurs'
            ],
            [
                'name' => 'add-consultation',
                'display_name' => 'faire des consultations',
                'description' => 'Peut faire des consultations'
            ],
            [
                'name' => 'view-consultation',
                'display_name' => 'Voir les consultations',
                'description' => 'Peut voir tous les consultations'
            ],
            [
                'name' => 'view-campagne-consultation',
                'display_name' => 'Voir les campagnes de consultations',
                'description' => 'Peut voir toutes les campagnes de consultations'
            ],
            [
                'name' => 'add-ordonnance',
                'display_name' => 'faire des consultations',
                'description' => 'Peut faire des consultations'
            ],
            [
                'name' => 'view-ordonnance',
                'display_name' => 'Voir les ordonnances',
                'description' => 'Peut voir toutes les ordonnances'
            ],
            [
                'name' => 'view-galerie',
                'display_name' => 'Voir les galeries',
                'description' => 'Peut voir toutes les galeries'
            ],
            [
                'name' => 'search-talibe',
                'display_name' => 'faire des recherche talibe',
                'description' => 'Peut faire des recherche talibe'
            ],

        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Créer les rôles
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrateur',
            'description' => 'Accès complet au système'
        ]);

        $editorRole = Role::create([
            'name' => 'editor',
            'display_name' => 'Éditeur',
            'description' => 'Peut gérer le contenu'
        ]);

        $managerRole = Role::create([
            'name' => 'manager',
            'display_name' => 'Manager',
            'description' => 'Peut gérer certaines fonctionnalités'
        ]);

        $userRole = Role::create([
            'name' => 'user',
            'display_name' => 'Utilisateur',
            'description' => 'Utilisateur standard'
        ]);

        // Assigner les permissions aux rôles

        // Admin : toutes les permissions
        $adminRole->permissions()->attach(Permission::all());

        // Editor : gestion du contenu
        $editorRole->permissions()->attach([
            Permission::where('name', 'view-talibes')->first()->id,
            Permission::where('name', 'create-talibes')->first()->id,
            Permission::where('name', 'edit-own-talibes')->first()->id,
            Permission::where('name', 'delete-own-talibes')->first()->id,
        ]);

        // Manager : vues et rapports
        $managerRole->permissions()->attach([
            Permission::where('name', 'view-talibes')->first()->id,
            Permission::where('name', 'view-reports')->first()->id,
        ]);

        // User : lecture seule
        $userRole->permissions()->attach([
            Permission::where('name', 'view-talibes')->first()->id,
        ]);

        // Créer un utilisateur admin par défaut
        $adminUser = User::where('email', 'admin@gmail.com')->first();


        $adminUser->assignRole('admin');
    }
}
