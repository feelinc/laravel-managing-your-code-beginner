<?php

namespace App\Services;

/*
 * This file is part of the Sulaeman Example.
 *
 * (c) Sulaeman <me@sulaeman.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;

use App\Modules\User\Repository as UserRepository;

use App\User;
use App\Mail\UserVerification;
use App\Support\Uuid;

class Member extends Service
{
    /**
     * Send verification email to member.
     *
     * @param  integer $userId
     * 
     * @return void
     */
    public function sendVerificationEmail($userId)
    {
        // Find who's the recipient
        $user = User::find($userId);

        // Create UUID for verification link
        $uuid = Uuid::generate(5, $userId, env('UUID'));

        // Create the mailable instance
        $email = new UserVerification($user, $uuid);

        // Send the mail
        Mail::to($user)->send($email);
    }

    /**
     * Search members.
     *
     * @param  array   $params
     * @param  integer $page
     * @param  integer $limit
     * 
     * @return void
     */
    public function search(Array $params = [], $page = 1, $limit = 10)
    {
        // Get the user repository
        $userRepository = $this->userRepository();

        // Do search
        $collection = $userRepository->search($params, $page, $limit);

        // Create and return pagination
        return new LengthAwarePaginator(
            $collection->all(), 
            $userRepository->getTotal(), 
            $limit, 
            $page, 
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    /**
     * Return the user repository instance.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    private function userRepository()
    {
        return app(UserRepository::class);
    }
}
