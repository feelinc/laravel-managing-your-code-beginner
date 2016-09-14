<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Modules\User\Models\User as UserContract;

class User extends Authenticatable implements UserContract
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * {@inheritdoc}
     */
    public function groups()
    {
        return $this->hasManyThrough(
            '\Sule\User\Models\Eloquent\Group', 
            '\Sule\User\Models\Eloquent\UserGroup', 
            'user_id', 'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function groupIds()
    {
        return $this->hasMany('\Sule\User\Models\Eloquent\UserGroup', 'user_id');
    }

    /**
     * Check if user in a group.
     *
     * @param  string $name
     *
     * @return boolean
     */
    public function isInGroup($name)
    {
        $groups = $this->groups;

        if ( ! is_null($groups)) {
            if ( ! $groups->isEmpty()) {
                return (bool) $groups->search(function ($item) use ($name) {
                    return $item->name == $name;
                });
            }
        }

        unset($groups);

        return false;
    }
}
