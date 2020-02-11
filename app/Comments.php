<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments';
    const IS_FALSE = 0;
    const IS_TRUE = 1;
}