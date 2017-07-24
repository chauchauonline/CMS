<?php

use Illuminate\Database\Seeder;
use Modules\Cms\Entities\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' =>'Hoạt động',
                'slug' => 'events'
            ],
            [
                'id' => 2,
                'name' =>'Tin tức',
                'slug' =>'news'
            ],
        ];
        foreach ($data as $item)
            Category::create($item);
    }
}
