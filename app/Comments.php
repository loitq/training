<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments';

    /**
     * Relationship one to many.
     *
     * @return App\Blog
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    /**
     * Relationship many to one.
     *
     * @return array App\Blog
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
