<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i=0; $i<50; $i++) {
          Article::create([
            'title' => Str::random(3),
            'body' => Str::random(6),
            'tags' => Str::random(4)
          ]);
        }
    }
}
