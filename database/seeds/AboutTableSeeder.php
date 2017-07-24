<?php

use Illuminate\Database\Seeder;
use Modules\Cms\Entities\Page;

class AboutTableSeeder extends Seeder
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
                'name' =>'About',
                'slug' => 'gioi-thieu'
            ],
        ];
        foreach ($data as $item)
            Page::create($item);
    }
}
