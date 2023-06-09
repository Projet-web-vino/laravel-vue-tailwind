<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $role = new Role();
        $role->nom = 'admin';
        $role->save();

        $role = new Role();
        $role->nom = 'utilisateur';
        $role->save();
    }
}
