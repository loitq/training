<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
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

    use SoftDeletes;

    const IS_FALSE = 0;
    const IS_TRUE = 1;

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'title', 'content', 'user_id', 'created_at', 'updated_at'
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = ['deleted_at'];
}
