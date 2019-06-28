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
        $users = array(
            [
                'name'=>'coordinador',
                'email'=>'coordinador@test.dev',
                'password'=>Hash::make('123456'),
                'rol_id'=>1
            ],
            [
                'name'=>'instructor',
                'email'=>'instructor@test.dev',
                'password'=>Hash::make('123456'),
                'rol_id'=>2
            ],
            [
                'name'=>'estudiante',
                'email'=>'estudiante@test.dev',
                'password'=>Hash::make('123456'),
                'rol_id'=>3
            ]
        );

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
