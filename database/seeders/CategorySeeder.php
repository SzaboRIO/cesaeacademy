<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['area' => 'Development']);
        Category::create(['area' => 'IT Network']);
        Category::create(['area' => 'Media Design']);
        Category::create(['area' => 'People']);
    }
}
