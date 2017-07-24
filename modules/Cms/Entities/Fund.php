<?php namespace Modules\Cms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fund extends Model {

    use SoftDeletes;
    protected $table = 'fund';
    protected $fillable=[
        'type',
        'content',
        'date',
        'amount',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $dates = ['deleted_at'];

}