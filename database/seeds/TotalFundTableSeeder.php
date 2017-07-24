<?php

use Illuminate\Database\Seeder;
use Modules\Cms\Entities\TotalFund;

class TotalFundTableSeeder extends Seeder
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
                'total' =>'0',
            ],
        ];
        foreach ($data as $item)
            TotalFund::create($item);
    }
}
