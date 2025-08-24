<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\ArchivedTrip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SelectedTrip;
use App\Models\AssignedTrip;
use App\Models\Message;
use App\Models\CompletedTrip;

class CompanyController extends Controller
{

    public function trips(Request $request)
    {
        if (!Session::has('company.compname')) {
            return redirect('companylogin')->withErrors('Please log in to access!');
        }
    
        $sortBy = $request->get('sort_by', 'id');
        $allowedSorts = ['type', 'distance', 'cost', 'schedule'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }
    
        $trips = Trip::orderBy($sortBy)->paginate(10); 
    
        $allTripsCount = Trip::count();
        $selectedTrips = SelectedTrip::all();
        $assignedTrips = AssignedTrip::all();
        $completedTrips = CompletedTrip::all();
    
        return view('company.trips', compact('trips', 'allTripsCount', 'selectedTrips', 'assignedTrips', 'completedTrips'));
    }
    

        public function truckersList1()
    {
        if (!Session::has('company.compname')) {
            return redirect('companylogin')->withErrors('Please log in to access the Truckers List!');
        }
        $users = User::where('usertype', 'trucker')
                     ->where('compname', session('company.compname'))
                     ->paginate(10); 
    
        $trips = Trip::all(); 
        $selectedTrips = SelectedTrip::all(); 
        $assignedTrips = AssignedTrip::all(); 
        $completedTrips = CompletedTrip::all(); 
    
        return view('company.index', compact('users', 'trips', 'selectedTrips', 'assignedTrips', 'completedTrips'));
    }
    

    public function selectedTrips()
    {

        if (!Session::has('company.compname')) {
            return redirect('companylogin')->withErrors('Please log in to access!');
        }
         $trips = Trip::all(); 
         $selectedTrips = SelectedTrip::paginate(10); 
         $allSelectedTrips = SelectedTrip::all(); 
         $assignedTrips = AssignedTrip::all(); 
         $completedTrips = CompletedTrip::all(); 
    
        return view('company.selectedtrips', compact('trips','allSelectedTrips', 'selectedTrips', 'assignedTrips', 'completedTrips'));
    
    }


    public function pending(Request $request)
    {
        if (!Session::has('company.compname')) {
            return redirect('companylogin')->withErrors('Please log in to access!');
        }
    
        $validSortColumns = ['type', 'distance', 'cost', 'schedule'];
        $sortBy = in_array($request->get('sort_by'), $validSortColumns) ? $request->get('sort_by') : 'id';
        $sortOrder = $request->get('sort_order') === 'desc' ? 'desc' : 'asc';
    
        $trips = Trip::all(); 
        $selectedTrips = SelectedTrip::all(); 
        $assignedTrips = AssignedTrip::orderBy($sortBy, $sortOrder)->paginate(10); 
        $allAssignedTrips = AssignedTrip::all(); 
        $completedTrips = CompletedTrip::all(); 
    
        return view('company/pendingtrips', compact('trips', 'allAssignedTrips', 'selectedTrips', 'assignedTrips', 'completedTrips'));
    }
    

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete(); 

        return redirect()->route('company')->with('success', 'Company deleted successfully');
    }

    public function destroy1($id)
    {
        $users = User::findOrFail($id);
        $users->delete(); 

        return redirect()->route('company.index')->with('success', 'Trucker deleted successfully');
    }


    public function edit($id)
    {
        $users = User::findOrFail($id);
        return view('company.edit', compact('users'));
    }



    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'compname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id, 
            'company_phone' => 'required|string|max:15',
            'company_address' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255',
            'owner_phone' => 'required|string|max:15',
        ]);

        $users = User::findOrFail($id);
        $users->update($validatedData); 
        return redirect()->route('company')->with('success', 'Company updated successfully');
    }

    public function completed(Request $request)
    {
        if (!Session::has('company.compname')) {
            return redirect('companylogin')->withErrors('Please log in to access!');
        }    
    
        $sortBy = $request->get('sort_by', 'id'); 
        $sortOrder = $request->get('sort_order', 'asc'); 
    
        $trips = Trip::all(); 
        $selectedTrips = SelectedTrip::all(); 
        $assignedTrips = AssignedTrip::all(); 
    
        $completedTrips = CompletedTrip::where('compname', session('company.compname'))
                                       ->orderBy($sortBy, $sortOrder)
                                       ->paginate(10);
    
        $allCompletedTrips = CompletedTrip::where('compname', session('company.compname'))->get();
    
        return view('company.completedtrips', compact('trips', 'allCompletedTrips', 'selectedTrips', 'assignedTrips', 'completedTrips'));
    }
    
    

    public function notifications()
    {

        if (!Session::has('company')) {
            return redirect()->route('companylogin')->withErrors('Please log in to access the Dashboard!');
        }
    
        $compname = Session::get('compname'); 
        $userType = Session::get('usertype');  
        $userId = Session::get('company');   
    
        $messages = Message::where('usertype', $userId) 
            ->where('usertype', $userId)  
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        $readNotificationsCount = Message::where('usertype', $userId)  
            ->where('usertype', $userId) 
            ->whereNull('read_at') 
            ->count();

            $trips = Trip::all(); 
            $selectedTrips = SelectedTrip::all(); 
            $assignedTrips = AssignedTrip::all(); 
            $allAssignedTrips = AssignedTrip::all(); 
            $completedTrips = CompletedTrip::where('compname', session('company.compname'))
                                           ->paginate(10);
            $allCompletedTrips = CompletedTrip::where('compname', session('company.compname'))->get();

    
        return view('company.notifications', compact('messages', 'readNotificationsCount','allAssignedTrips','trips', 'allCompletedTrips', 'selectedTrips', 'assignedTrips', 'completedTrips'));
    }
    
    public function markAsRead($id)
    {
        if (!Session::has('company')) {
            return redirect()->route('companylogin')->withErrors('Please log in to access the Dashboard!');
        }
    
        $message = Message::where('id', $id)
            ->where('usertype', Session::get('company'))
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
        if (!Session::has('company')) {
            return redirect()->route('companylogin')->withErrors('Please log in to access the Dashboard!');
        }

        $message = Message::where('id', $id)
            ->where('usertype', Session::get('company'))
            ->firstOrFail();

        $message->update(['read_at' => null]);

        return redirect()->back()->with('success', 'Notification marked as unread.');
    }

}
