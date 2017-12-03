<?php

use Illuminate\Database\Seeder;

class BlogPostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Entities\BlogPost::class,25)->create();
    }
}
