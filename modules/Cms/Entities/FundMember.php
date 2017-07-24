<?php namespace Modules\Cms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundMember extends Model {

    use SoftDeletes;
    protected $table = 'funds_members';
    protected $fillable=[
        'fund_id',
        'member_id',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $dates = ['deleted_at'];

}