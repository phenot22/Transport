<?php

namespace App\Http\Controllers\Auth;

use App\Models\Trip;
use App\Models\Message;
use App\Models\CompletedTrip;
use App\Models\AssignedTrip;
use App\Models\SelectedTrip;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{

    public function index()
    {
        if (!Session::has('admin')) {
            return redirect()->route('adminlogin')->withErrors('Please log in to access the Dashboard!');
        }
    
        $adminId = Session::get('user_id');
        
        $totalTrips = Trip::count();
        $completedTrips = CompletedTrip::count();
        $totalCancel = Message::count();
        $totalCompanies = User::where('usertype', 'user')->count();
        $totalTruckers = User::where('usertype', 'trucker')->count();
        $pendingTrips = AssignedTrip::count() + SelectedTrip::count();
    
        // NEW: Count how many notifications were read
        $readNotificationsCount = Message::where('usertype', $adminId)
            ->whereNotNull('read_at')
            ->count();
    
        return view('dashboard', compact('totalTrips', 'completedTrips', 'totalCompanies', 'totalTruckers', 'pendingTrips', 'totalCancel', 'readNotificationsCount'));
    }
    


    public function notifications()
    {

        if (!Session::has('admin')) {
            return redirect()->route('adminlogin')->withErrors('Please log in to access the Notifications!');
        }

        $adminId = Session::get('admin');

        $messages = Message::with('user')  
        ->where('usertype', $adminId)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $readNotificationsCount = Message::where('usertype', $adminId)
        ->whereNull('read_at')
        ->count();

        return view('notifications', compact('messages', 'readNotificationsCount'));
    }

    public function markAsRead($id)
    {
        if (!Session::has('admin')) {
            return redirect()->route('adminlogin')->withErrors('Please log in to access the Dashboard!');
        }
    
        $message = Message::where('id', $id)
            ->where('usertype', Session::get('admin'))
            ->first();
    
        if ($message) {
            if (!$message->read_at) {
                $message->update(['read_at' => now()]);
                return back()->with('success', 'Notification marked as read.');
            } else {
                return back()->with('info', 'Notification was already marked as read.');
            }
        }
    
        return back()->with('error', 'Notification not found.');
    }

    public function markAsUnread($id)
    {
        if (!Session::has('admin')) {
            return redirect()->route('adminlogin')->withErrors('Please log in to access the Dashboard!');
        }

        $message = Message::where('id', $id)
            ->where('usertype', Session::get('admin'))
            ->firstOrFail();

        $message->update(['read_at' => null]);

        return redirect()->back()->with('success', 'Notification marked as unread.');
    }


    public function adminLogin()
    {
        return view('auth.adminlogin');
    }

    public function companyLogin()
    {
        return view('auth.companylogin');
    }

    public function truckersLogin()
    {
        return view('auth.truckerslogin');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function registration1()
    {
        if (!Session::has('company.compname')) {
            return redirect()->route('companylogin')->withErrors('Please log in to access!');
        }
        return view('auth.truckersregistration');
    }

    public function truckersList()
    {
        $users = User::where('usertype', 'trucker')->paginate(10);
        return view('truckers', compact('users'));
    }
    

    public function postRegistration(Request $request)
    {
        $request->validate([
            'compname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'company_phone' => 'required|regex:/^[0-9]{10,15}$/',
            'company_address' => 'required|string',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email',
            'owner_phone' => 'required|regex:/^[0-9]{10,15}$/',
            'password' => 'required|min:6|confirmed',
        ]);

        $data = $request->all();
        $data['usertype'] = 'user';

        $this->create($data);

        return redirect('company')->withSuccess('Account added successfully');
    }

    public function create(array $data)
    {
        return User::create([
            'compname' => $data['compname'],
            'email' => $data['email'],
            'company_phone' => $data['company_phone'],
            'company_address' => $data['company_address'],
            'owner_name' => $data['owner_name'],
            'owner_email' => $data['owner_email'],
            'owner_phone' => $data['owner_phone'],
            'password' => bcrypt($data['password']),
            'usertype' => 'user',
        ]);
    }

    public function postTruckerRegistration(Request $request)
    {

        if (!Session::has('company')) {
            return redirect()->route('companylogin')->withErrors('Please log in to access!');
        }
        $request->validate([
            'compname' => 'required|string|max:255',
            'trucker_name' => 'required|string|max:500',
            'gender' => 'required|in:male,female,other',
            'dob' => 'required|date',
            'trucker_address' => 'required|string|max:500',
            'email' => 'required|email|unique:users,email',
            'trucker_phone' => 'required|regex:/^[0-9]{10,15}$/',
            'password' => 'required|min:6|confirmed',

        ]);

        $data = $request->all();
        $this->createTrucker($data);

        return redirect('truckersregistration')->withSuccess('Trucker registered successfully');
    }

    public function createTrucker(array $data)
    {
        return User::create([
            'compname' => $data['compname'],
            'trucker_name' => $data['trucker_name'],
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'trucker_address' => $data['trucker_address'],
            'email' => $data['email'],
            'trucker_phone' => $data['trucker_phone'],
            'password' => bcrypt($data['password']),
            'usertype' => 'trucker',
        ]);
    }

public function postAdminLogin(Request $request)
{
    $originalEmail = $request->input('email');

    if ($originalEmail !== trim($originalEmail)) {
        return redirect()->route('adminlogin')
                         ->withErrors(['email' => 'The email must not contain leading or trailing spaces.']);
    }

    $request->merge([
        'email' => trim($originalEmail),
    ]);

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
        $user = Auth::guard('admin')->user();

        Session::put('admin', [
            'user_id' => $user->id,
            'usertype' => 'admin',
            'compname' => $user->compname ?? null,
            'owner_name' => $user->owner_name ?? null
        ]);

        return redirect()->route('dashboard')->withSuccess('You are successfully logged in!');
    }

    return redirect()->route('adminlogin')->withErrors('Your login credentials are incorrect!');
}



public function postCompanyLogin(Request $request)
{
    $originalEmail = $request->input('email');

    if ($originalEmail !== trim($originalEmail)) {
        return redirect()->route('companylogin')
                         ->withErrors(['email' => 'The email must not contain leading or trailing spaces.']);
    }

    $request->merge([
        'email' => trim($originalEmail),
    ]);

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::guard('company')->attempt($credentials)) {
        $user = Auth::guard('company')->user();

        Session::put('company', [
            'user_id' => $user->id,
            'usertype' => 'user',
            'compname' => $user->compname ?? null,
            'owner_name' => $user->owner_name ?? null
        ]);

        return redirect()->route('company.index')->withSuccess('You are successfully logged in!');
    }

    return redirect()->route('companylogin')->withErrors('Your login credentials are incorrect!');
}



    public function postTruckerLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('trucker')->attempt($credentials)) {
            $user = Auth::guard('trucker')->user();

                Session::put('trucker', [
                    'user_id' => $user->id,
                    'usertype' => 'trucker',
                    'compname' => $user->compname ?? null,
                    'trucker_name' => $user->trucker_name ?? null
                ]);
    
                return redirect()->route('trucker.index')->withSuccess('You are successfully logged in!');
            }
        
            return redirect()->route('truckerslogin')->withErrors('Your login credentials are incorrect!');
        }



    public function logout()
    {
        $usertype = session('usertype');
    
        switch ($usertype) {
            case 'admin':
                Auth::guard('admin')->logout();
                session()->forget('admin');
                break;
    
            case 'company':
                Auth::guard('company')->logout();
                session()->forget('company');
                break;
    
            case 'trucker':
                Auth::guard('trucker')->logout();
                session()->forget('trucker');
                break;
        }
    
        return redirect('adminlogin')->withSuccess('You have been logged out successfully.');
    }
    
    

    public function company()
    {
        if (!Session::has('admin')) {
            return redirect('adminlogin')->withErrors('Please log in to access the Company List!');
        }

        $users = User::where('usertype', 'user')->paginate(10);
        return view('company', compact('users'));
    }

    public function truckers()
    {
        
        if (!Session::has('company')) {
            return redirect('adminlogin')->withErrors('Please log in to access the Truckers List!');
        }

        $users = User::where('usertype', 'trucker')->paginate(10);
        return view('truckers', compact('users'));
    }

    public function showCompanyDetails()
    {
        $userId = session('user_id');
        
        if ($userId) {
            $user = User::find($userId);
            
            if ($user) {
                return response()->json([
                    'owner_name' => $user->owner_name,
                    'compname' => $user->compname
                ]);
            } else {
                return redirect()->route('companylogin')->withErrors('User not found.');
            }
        } else {
            return redirect()->route('companylogin')->withErrors('User not logged in.');
        }
    }
}
