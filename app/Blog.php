<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';

    /**
     * Relationship many to one.
     *
     * @return array App\Blog
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship one to many.
     *
     * @return App\Comments
     */
    public function comments()
    {
        return $this->hasMany(Comments::class);
    }
}
