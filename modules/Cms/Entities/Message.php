<?php
namespace Modules\Cms\Entities;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {
    protected $table = "messages";
    protected $fillable = [
        'status',
        'star',
        'from',
        'to',
        'subject',
        'email',
        'message',
        'read',
        'type',
        'slug',
        'user_id',
        'upload_folder',
        'created_at',
        'updated_at',
    ];
}