<?php

use Illuminate\Database\Seeder;
use App\Model\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert(
            [
            'name' => 'Admin',
            'slug' => 'admin'
           ]);

         Role::insert(
            [
            'name' => 'Author',
            'slug' => 'author'
           ]);
    }
}
