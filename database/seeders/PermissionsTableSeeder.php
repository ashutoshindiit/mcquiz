<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name'       => 'manage_user',
            'guard_name' => 'web',
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);
        
        DB::table('permissions')->insert([
            'name'       => 'manage_role',
            'guard_name' => 'web',
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]); 
        DB::table('permissions')->insert([
            'name'       => 'manage_quiz',
            'guard_name' => 'web',
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);

        
        $user = User::findOrFail(1);
        $my_role = Role::where('id', '=', 1)->firstOrFail();
        $user->assignRole($my_role); //Assigning role to user
    }
}
