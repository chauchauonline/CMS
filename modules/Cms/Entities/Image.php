<?php
namespace Modules\Cms\Entities;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {
    protected $fillable = [
        'name',
        'file_type',
        'file_size',
        'thumbs',
        'created_at',
        'updated_at',
    ];
}