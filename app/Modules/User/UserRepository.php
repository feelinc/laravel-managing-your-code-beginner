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

use RuntimeException;
use App\Modules\User\RecordNotFoundException;

class UserRepository implements Repository
{
    /**
     * The model.
     *
     * @var \App\Modules\User\Models\User
     */
    protected $model;

    /**
     * The Group model.
     *
     * @var \App\Modules\User\Models\Group
     */
    protected $modelGroup;

    /**
     * The User Group model.
     *
     * @var \App\Modules\User\Models\UserGroup
     */
    protected $modelUserGroup;

    /**
     * Current total query rows.
     *
     * @var integer
     */
    protected $total = 0;

    /**
     * Create a new instance.
     *
     * @param string $model
     * @param string $modelGroup
     * @param string $modelUserGroup
     * 
     * @return void
     */
    public function __construct($model, $modelGroup, $modelUserGroup)
    {
        $this->model = $model;
        $this->modelGroup = $modelGroup;
        $this->modelUserGroup = $modelUserGroup;
    }

    /**
     * {@inheritdoc}
     */
    public function search(Array $params = [], $page = 1, $limit = 10)
    {
        $params = array_merge([
            'activated'  => -1, 
            'start_date' => '', 
            'end_date'   => ''
        ], $params);

        $model = $this->createModel();
        
        if (empty($page)) {
            $page = 1;
        }

        $query = $model->select($model->getTable().'.id');

        if ($params['activated'] > -1) {
            $query->where($model->getTable().'.activated', '=', $params['activated']);
        }

        if ( ! empty($params['start_date'])) {
            $query->where($model->getTable().'.start_date', '>=', $params['start_date']);
        }

        if ( ! empty($params['end_date'])) {
            $query->where($model->getTable().'.end_date', '<=', $params['end_date']);
        }

        $this->total = $query->count();

        $query = $model->select($model->getTable().'.*');

        if ($params['activated'] > -1) {
            $query->where($model->getTable().'.activated', '=', $params['activated']);
        }

        if ( ! empty($params['start_date'])) {
            $query->where($model->getTable().'.start_date', '>=', $params['start_date']);
        }

        if ( ! empty($params['end_date'])) {
            $query->where($model->getTable().'.end_date', '<=', $params['end_date']);
        }

        if ($limit > 0) {
            $query->skip(($page - 1) * $limit)->take($limit);
        }

        $query->orderBy($model->getTable().'.created_at', 'DESC');

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findGroupBy(Array $params)
    {
        $params = array_merge([
            'id'   => 0, 
            'name' => ''
        ], $params);

        $model = $this->createModelGroup();

        $query = $model->newQuery()->select($model->getTable().'.*');

        if ( ! empty($params['id'])) {
            $query->where($model->getTable().'.id', '=', $params['id']);
        }

        if ( ! empty($params['name'])) {
            $query->where($model->getTable().'.name', '=', $params['name']);
        }

        unset($model);

        $item = $query->first();

        if (is_null($item)) {
            throw new RecordNotFoundException('Item not found!');
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function addToGroup($userId, $groupId)
    {
        $model = $this->createModelUserGroup();
        $model->fill([
            'user_id'  => $userId, 
            'group_id' => $groupId
        ]);

        if ( ! $model->save()) {
            throw new RuntimeException('Failed to create the user group');
        }

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function removeFromGroup($userId, $groupId)
    {
        return $this->createModelUserGroup()
                    ->where('user_id', '=', $userId)
                    ->where('group_id', '=', $groupId)
                    ->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Create a new instance of the user model.
     *
     * @return \App\Modules\User\Models\User
     */
    private function createModel()
    {
        return new $this->model;
    }

    /**
     * Create a new instance of the group model.
     *
     * @return \App\Modules\User\Models\Group
     */
    private function createModelGroup()
    {
        return new $this->modelGroup;
    }

    /**
     * Create a new instance of the user group model.
     *
     * @return \App\Modules\User\Models\UserGroup
     */
    private function createModelUserGroup()
    {
        return new $this->modelUserGroup;
    }
}
