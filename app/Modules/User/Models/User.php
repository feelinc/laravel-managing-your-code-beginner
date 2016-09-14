<?php

namespace App\Modules\User\Models;

/*
 * This file is part of the Sulaeman Example.
 *
 * (c) Sulaeman <me@sulaeman.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

interface User
{
    /**
     * Returns the relationship between users and groups.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasManyThrough
    */
    public function groups();

    /**
     * Returns the relationship between users and user groups.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function groupIds();

    /**
     * Check if user in a group.
     *
     * @param  string $name
     *
     * @return boolean
     */
    public function isInGroup($name);
}
