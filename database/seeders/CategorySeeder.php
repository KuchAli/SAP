<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Novel',
            'Cerita_rakyat',
            'Pengetahuan',
            'Sejarah'
        ];

        foreach ($data as $item) {
            Kategori::create([
                'name' => $item,
                'slug' => Str::slug($item) // otomatis bikin slug
            ]);
        }
    }
}
