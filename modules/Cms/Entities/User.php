<?php
namespace Modules\Cms\Entities;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends SentinelUser {
    use Sortable;
    use SoftDeletes;
    protected $fillable = [
        'email',
        'share',
        'password',
        'permissions',
        'first_name',
        'last_name',
        'mobile',
        'company_name',
        'position',
        'career',
        'other_email',
        'fb_url',
        'company_website',
        'blog',
        'security_question1',
        'security_question2',
        'wanted',
        'birthday',
        'gender',
        'bio',
        'address',
        'photo',
        'street',
        'city',
        'district',
        'state',
        'country',
        'created_at',
        'updated_at',
    ];

     protected $sortable = ['first_name', 'last_name'];
     protected $dates = ['deleted_at'];

     protected $loginNames = ['email', 'mobile'];
}