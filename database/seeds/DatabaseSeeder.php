<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Permission::class, 25)->create();
        factory(App\Activity::class, 125)->create();
    }
}
