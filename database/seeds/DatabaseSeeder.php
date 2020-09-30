<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::table('users')->insert([
            [
                'role_id'       => 1,
                'name'          => 'Admin',
                'username'      => 'admin',
                'email'         => 'sakar@admin.com',
                'about'         => 'Bio of admin',
                'password'      => bcrypt('roomfinder'),
                'created_at'    => date("Y-m-d H:i:s")
            ],
            [
                'role_id'       => 2,
                'name'          => 'Agent',
                'username'      => 'agent',
                'email'         => 'epson@agent.com',
                'about'         => '',
                'password'      => bcrypt('roomfinder'),
                'created_at'    => date("Y-m-d H:i:s")
            ],
        ]);


        DB::table('roles')->insert([
            [
                'name'          => 'Admin',
                'slug'          => 'admin',
                'created_at'    => date("Y-m-d H:i:s")
            ],
            [
                'name'          => 'Agent',
                'slug'          => 'agent',
                'created_at'    => date("Y-m-d H:i:s")
            ],
        ]);
    }
}
