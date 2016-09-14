<?php

namespace App\Presenter\Api;

/*
 * This file is part of the Sulaeman Example.
 *
 * (c) Sulaeman <me@sulaeman.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use League\Fractal\TransformerAbstract;

use App\Modules\User\Models\User as UserContract;

class User extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @param  UserContract $item
     *
     * @return array
     */
    public function transform(UserContract $user)
    {
        return [
            'id'           => (int) $user->id, 
            'email'        => $user->email, 
            'name'         => $user->name, 
            'activated'    => (bool) $user->activated, 
            'last_login'   => $user->last_login,
            'activated_at' => $user->activated_at, 
            'created_at'   => $user->created_at
        ];
    }

}
