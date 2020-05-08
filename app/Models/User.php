<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordResetNotification;
use App\Notifications\VerificationEmailNotification;

//use App\Models\Roles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'profile_picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Define Comments relationship
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
        return $this->hasMany(Comments::class, 'user_id');
    }

    /**
     * Define Roles relationship
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Roles::class)->withTimestamps();
    }

    /**
     * get comment count by user
     * @return int
     */
    public function getCommentsCount()
    {
        return $this->comments()->count();
    }

    /**
     * Define Article relationship
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    /**
     * get article count by user
     * @return int
     */
    public function getArticlesCount()
    {
        return $this->articles()->count();
    }

    /**
     * Check if role is authorised
     *
     * @param  array $roles
     * @return boolean
     */
    public function authorizeRoles($roles)
    {
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, 'This action is unauthorized.');
    }

    /**
     * Check if there is any roles attached
     *
     * @param  array $roles
     * @return boolean
     */
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if a specific role is attached
     *
     * @param  string $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    /**
     * Assign a role to the user
     *
     * @param  string $role
     * @return boolean
     */
    public function assignRole($role)
    {
        $role = Roles::where('name', $role)->get()->first();
        if ($role) {
            return $this->roles()->save($role);
        }
        return false;
    }

    /**
     * Check if a user has admin role.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->hasRole('ROLE_ADMIN');
    }

    /**
     * Override send password reset notification
     *
     * @param  string $token
     * @return boolean
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    /**
     * Override send email verification notification
     *
     * @return boolean
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerificationEmailNotification());
    }
}
