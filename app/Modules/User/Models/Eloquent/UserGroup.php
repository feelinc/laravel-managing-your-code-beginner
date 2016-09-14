<?php

namespace App\Modules\User\Models\Eloquent;

/*
 * This file is part of the Sulaeman Example.
 *
 * (c) Sulaeman <me@sulaeman.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use App\Modules\User\Models\UserGroup as UserGroupInterface;

class UserGroup extends Model implements UserGroupInterface
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'users_groups';

    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'group_id';

    /**
     * {@inheritdoc}
     */
    public $incrementing = false;

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'user_id', 
        'group_id'
    ];

}
