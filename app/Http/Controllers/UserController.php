<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Member as MemberService;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Test sending verification email.
     *
     * @return \Illuminate\Http\Response
     */
    public function testEmail()
    {
        // Create the member service instance
        $service = new MemberService();

        // Do send email verification
        $service->sendVerificationEmail(1);
    }

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

        // Show the view
        return view('users', [
            'list' => $result
        ]);
    }
}
