<?php namespace Modules\Cms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactForm extends Model {

    use SoftDeletes;
    protected $table = 'contact';
    protected $fillable=[
        'full_name',
        'email',
        'mobile',
        'message',
        'status',
        'message_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $dates = ['deleted_at'];

}