<?php

use Illuminate\Database\Seeder;
use App\Rol;

class RolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rols = array(
            ['name'=>'coordinador','description'=>'default'],
            ['name'=>'instructor','description'=>'default'],
            ['name'=>'estudiante','description'=>'default']
        );

        foreach ($rols as $rol) {
            Rol::create($rol);
        }
    }
}
