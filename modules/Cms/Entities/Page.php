<?php
namespace Modules\Cms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model {
    use SoftDeletes;
    protected $table = 'pages';
    protected $fillable = [
            'name',
            'slug',
            'order',
            'banner',
            'view',
            'compiler',
            'status',
            'upload_folder',
            'heading',
            'title',
            'content',
            'keyword',
            'description',
            'image_id',
            'abstract',
            'created_at',
            'updated_at',
    ];
    protected $dates = ['deleted_at'];
}