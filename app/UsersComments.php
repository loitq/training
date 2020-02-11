<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersComments extends Model
{
    protected $table = 'users_comments';
    const IS_FALSE = 0;
    const IS_TRUE = 1;
}