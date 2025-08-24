<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\LoginHistory;

class LoginHistoryController extends Controller
{
    /**
     * Display the login history.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!Session::has('admin')) {
            return redirect('adminlogin')->withErrors('Please log in to access the Log History!');
        }
        $loginHistory = LoginHistory::latest()->paginate(10); 

        return view('loginhistory', compact('loginHistory'));
    }
}
