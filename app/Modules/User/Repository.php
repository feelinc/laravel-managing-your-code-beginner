<?php

namespace App\Modules\User;

/*
 * This file is part of the Sulaeman Example.
 *
 * (c) Sulaeman <me@sulaeman.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

interface Repository
{
    /**
     * Return users.
     *
     * @param  array   $params
     * @param  integer $page
     * @param  integer $limit
     * 
     * @return \Collection
     */
    public function search(Array $params = [], $page = 1, $limit = 10);

    /**
     * Find a group by params.
     *
     * @param  array $params
     * 
     * @return \App\Modules\User\Models\Group
     * 
     * @throws \App\Modules\User\RecordNotFoundException
     */
    public function findGroupBy(Array $params);

    /**
     * Add a user to a group.
     *
     * @param  integer $userId
     * @param  integer $groupId
     * 
     * @return \App\Modules\User\Models\UserGroup
     * 
     * @throws \RuntimeException
     */
    public function addToGroup($userId, $groupId);

    /**
     * Remove a user from a group.
     *
     * @param  integer $userId
     * @param  integer $groupId
     * 
     * @return boolean
     */
    public function removeFromGroup($userId, $groupId);

    /**
     * Return latest query total items.
     *
     * @return integer
     */
    public function getTotal();
}
