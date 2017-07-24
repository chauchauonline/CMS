<?php namespace Modules\Cms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model {

    use SoftDeletes;
    protected $table = 'articles';
    protected $fillable=[
        'title',
        'slug',
        'brief',
        'category_id',
        'content',
        'source',
        'orderby',
        'user_id',
        'image_id',
        'image_fb_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $dates = ['deleted_at'];

}