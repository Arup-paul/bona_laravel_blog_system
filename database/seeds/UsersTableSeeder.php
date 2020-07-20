<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'role_id' => '1',
            'name' => 'Arup Paul',
            'username' => 'admin',
            'email'=> 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);

        User::insert( [
            'role_id' => '2',
            'name' => 'Mishu Paul',
            'username' => 'author',
            'email'=> 'author@gmail.com',
            'password' => bcrypt('password')
        ]);
    }
}
