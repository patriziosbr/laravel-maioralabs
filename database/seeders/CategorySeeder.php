<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = config('categories');
      
        foreach ($categories as $category) {
            $newcategory = new Category();
            $newcategory->name = $category['name'];
            $newcategory->save();
        }
    }
}
