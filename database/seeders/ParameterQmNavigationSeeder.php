<?php

namespace Database\Seeders;

use App\Models\Navigation;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParameterQmNavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat menu parent Penilaian Agent
        $penilaianAgentParent = Navigation::create([
            'name' => 'Penilaian Agent',
            'url' => 'penilaian-agent',
            'icon' => 'ti-user',
            'main_menu' => null,
            'type_menu' => 'parent',
            'sort' => 10,
        ]);

        // Buat sub menu Parameter QM
        Navigation::create([
            'name' => 'Parameter QM',
            'url' => 'parameter-qm',
            'icon' => '',
            'main_menu' => $penilaianAgentParent->id,
            'type_menu' => 'child',
            'sort' => 1,
        ]);

        // Buat sub menu Penilaian Tapping
        Navigation::create([
            'name' => 'Penilaian Tapping',
            'url' => 'penilaian-tappings',
            'icon' => '',
            'main_menu' => $penilaianAgentParent->id,
            'type_menu' => 'child',
            'sort' => 2,
        ]);

        // Dapatkan role admin
        $adminRole = Role::where('name', 'admin')->first();
        
        if ($adminRole) {
            // Dapatkan semua navigasi Penilaian Agent yang baru dibuat
            $penilaianAgentNavigations = Navigation::where('name', 'LIKE', '%Penilaian%')
                ->orWhere('main_menu', $penilaianAgentParent->id)
                ->get();
            
            // Lampirkan role admin ke setiap navigasi Penilaian Agent
            foreach ($penilaianAgentNavigations as $navigation) {
                $navigation->roles()->syncWithoutDetaching([$adminRole->id]);
            }
        }
    }
}
