<?php namespace Modules\Cms\Entities;

use Illuminate\Database\Eloquent\Model;

class company extends Model {

    protected $table = 'companies';
    protected $fillable=[
        'name',
        'orderby',
        'source',
        'description',
        'image',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $dates = ['deleted_at'];

}