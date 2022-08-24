<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new User();
        $model->id = 1;
        $model->name = "Matheus Romao";
        $model->email = "matheusromao@hotmail.com";
        $model->type = "ADMIN";
        $model->password = "12345678";
        $model->phone = "12345678";
        $model->save();
    }
}
