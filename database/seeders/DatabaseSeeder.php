<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Products;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();
         $categories=[
            ['name'=>'kitchen','count'=>1],
            ['name'=>'computer','count'=>1],
            ['name'=>'car','count'=>1],
         ];

       foreach($categories as $category){
        $createdcategory=Categories::factory()->create(['name'=>$category['name']]);
        Products::factory()->count(3)->forcategory($createdcategory)->create();
       }


    }
}
