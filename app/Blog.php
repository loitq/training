<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    const IS_FALSE = 0;
    const IS_TRUE = 1;
}
