<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Dingo\Api\Routing\Helpers;

use App\Services\Member as MemberService;
use App\Presenter\Api\User as UserPresenter;

class UserController extends Controller
{
    use Helpers;

    /**
     * Show the list of available users.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Manage the query parameters
        $limit    = 10;
        $page     = (int) $request->get('page', 1);
        $starDate = trim($request->get('start_date'));
        $endDate  = trim($request->get('end_date'));

        // Create the member service instance
        $service = new MemberService();

        // Do search
        $result = $service->search([
            'activated'  => 1, 
            'start_date' => $starDate, 
            'end_date'   => $endDate
        ], $page, $limit);

        return $this->response->paginator(
            $result, 
            new UserPresenter
        );
    }
}
