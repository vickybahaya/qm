<?php

namespace Database\Seeders;

use App\Models\Navigation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinalCleanupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus menu yang tidak diperlukan
        Navigation::whereIn('name', [
            'Parameter Proses',
            'Parameter Sikap', 
            'Parameter Solusi'
        ])->delete();

        // Pastikan menu Penilaian Agent ada dan benar
        $penilaianAgent = Navigation::updateOrCreate(
            ['name' => 'Penilaian Agent', 'type_menu' => 'parent'],
            [
                'url' => 'penilaian-agent',
                'icon' => 'ti-user',
                'main_menu' => null,
                'sort' => 10,
            ]
        );

        // Hapus semua sub menu lama dari Penilaian Agent
        Navigation::where('main_menu', $penilaianAgent->id)->delete();

        // Buat sub menu yang benar
        Navigation::create([
            'name' => 'Parameter QM',
            'url' => 'parameter-qm',
            'icon' => '',
            'main_menu' => $penilaianAgent->id,
            'type_menu' => 'child',
            'sort' => 1,
        ]);

        Navigation::create([
            'name' => 'Penilaian Tapping',
            'url' => 'penilaian-tappings',
            'icon' => '',
            'main_menu' => $penilaianAgent->id,
            'type_menu' => 'child',
            'sort' => 2,
        ]);

        // Assign role admin
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        if ($adminRole) {
            $penilaianAgentNavigations = Navigation::where('name', 'LIKE', '%Penilaian%')
                ->orWhere('main_menu', $penilaianAgent->id)
                ->get();
            
            foreach ($penilaianAgentNavigations as $navigation) {
                $navigation->roles()->syncWithoutDetaching([$adminRole->id]);
            }
        }
    }
}
