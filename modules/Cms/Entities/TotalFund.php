<?php namespace Modules\Cms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TotalFund extends Model {

    use SoftDeletes;
    protected $table = 'total_fund';
    protected $fillable=[
        'total',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $dates = ['deleted_at'];

    static public function update_total_fund($amount, $type) {
        $total_fund = TotalFund::first();
        if($type == '0') { // Thu
            $total_fund->total += $amount;
        } else { // Chi
            $total_fund->total -= $amount;
        }
        $total_fund->save();
        return $total_fund;
    }

    static public function compare_with_remain_fund($amount){
        $remain_fund = TotalFund::first();
        $total = $remain_fund->total;
        if($amount < $total) {
            return true;
        } else {
            return false;
        }
    }
}