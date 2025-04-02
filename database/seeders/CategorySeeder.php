<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            // Development
            ['name' => 'Inteligência Artificial', 'area' => 'Development'],
            ['name' => 'DevOps', 'area' => 'Development'],
            ['name' => 'Software Development', 'area' => 'Development'],
            ['name' => 'Websites & E-Commerce', 'area' => 'Development'],
            ['name' => 'Scripts', 'area' => 'Development'],
            ['name' => 'Data Visualization', 'area' => 'Development'],

            // IT Network
            ['name' => 'Administração Windows', 'area' => 'IT Network'],
            ['name' => 'Cloud Computing', 'area' => 'IT Network'],
            ['name' => 'Linux', 'area' => 'IT Network'],
            ['name' => 'Administração de Redes', 'area' => 'IT Network'],

            // Media Design
            ['name' => 'Marketing Digital', 'area' => 'Media Design'],
            ['name' => 'Design Gráfico', 'area' => 'Media Design'],
            ['name' => 'UX/UI', 'area' => 'Media Design'],
            ['name' => 'Multimédia', 'area' => 'Media Design'],
            ['name' => 'CAD', 'area' => 'Media Design'],
            ['name' => 'Redes Sociais', 'area' => 'Media Design'],

            // People
            ['name' => 'Formação', 'area' => 'People'],
            ['name' => 'Gestão', 'area' => 'People'],
            ['name' => 'Comunicação', 'area' => 'People'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'area' => $category['area'],
            ]);
        }
    }
}
