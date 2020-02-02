<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Branch;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
          'name' => 'Administrator',
          'username' => 'admin',
          'password' => bcrypt(12345678),
          'api_token' => bcrypt('admin')
        ]);

        Category::create(['name' => 'Minuman']);

        Category::create(['name' => 'Makanan']);

        Branch::create(['name' => 'Cabang 1']);

        Branch::create(['name' => 'Cabang 2']);
    }
}
