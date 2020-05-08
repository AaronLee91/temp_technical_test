<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * App\Models\Article
     *
     * @property-read \App\Models\Comments[] $comments
    */

    // Set mass-assignable fields
    protected $fillable = ['title', 'description', 'user_id', 'slug'];

    /**
     * Define Comments relationship
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define Comments relationship
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
        return $this->hasMany(Comments::class,'article_id')->latest();
    }

    /**
     * Define Comments relationship
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function getCommentsCount()
    {
        return $this->comments()->count();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
