<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    // Set mass-assignable fields
    protected $fillable = ['body', 'article_id', 'user_id', 'slug'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Define Comments relationship
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Define Comments relationship
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
