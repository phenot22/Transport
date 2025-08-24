<?php

namespace App\Http\Controllers;

use App\Models\User;  
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SelectedTrip;
use App\Models\AssignedTrip;
use App\Models\CompletedTrip;
use App\Models\Message;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class TruckerController extends Controller
{
    public function index(Request $request)
    {
        if (!Session::has('trucker')) {
            return redirect()->route('truckerslogin')->withErrors('Please log in to access!');
        }
    
        $sortBy = $request->get('sort_by', 'id'); 
        $sortOrder = $request->get('sort_order', 'asc');
    
        $allowedSortFields = ['type', 'distance', 'cost', 'schedule'];
        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'id';
        }
    
        $users = User::where('usertype', 'trucker')->get();
        $trips = Trip::all();  
        $allSelectedTrips = SelectedTrip::all();  
        $assignedTrips = AssignedTrip::all();     
        $completedTrips = CompletedTrip::all();   
    
        $selectedTrips = SelectedTrip::orderBy($sortBy, $sortOrder)->paginate(10);
    
        return view('trucker.index', compact('trips', 'selectedTrips', 'allSelectedTrips', 'assignedTrips', 'completedTrips'));
    }
    


    public function selected(Request $request)
    {
        if (!Session::has('trucker')) {
            return redirect()->route('truckerslogin')->withErrors('Please log in to access!');
        }
    
        $sortBy = $request->get('sort_by', 'id'); 
        $sortOrder = $request->get('sort_order', 'asc'); 
    
        $users = User::where('usertype', 'trucker')->get();
        $trips = Trip::all();  
        $selectedTrips = SelectedTrip::all();  
    
        $assignedTrips = AssignedTrip::orderBy($sortBy, $sortOrder)->paginate(10);         
        $allAssignedTrips = AssignedTrip::all();     
        $completedTrips = CompletedTrip::all();  
    
        return view('trucker.selectedtrips', compact('trips', 'selectedTrips','assignedTrips','allAssignedTrips','completedTrips')); 
    }
    

    public function completed(Request $request)
    {
        $sortBy = $request->get('sort_by', 'id'); 
        $sortOrder = $request->get('sort_order', 'asc'); 
    
        $users = User::where('usertype', 'trucker')->get();
        $trips = Trip::all();  
        $selectedTrips = SelectedTrip::all();  
        $assignedTrips = AssignedTrip::all();  
    
        // ✅ Apply sorting here
        $completedTrips = CompletedTrip::orderBy($sortBy, $sortOrder)->paginate(10);
    
        $allCompletedTrips = CompletedTrip::all();  
    
        return view('trucker.completedtrips', compact('trips', 'selectedTrips','assignedTrips','completedTrips','allCompletedTrips')); 
    }
    


    public function selectTrip($id)
    {
        $trip = Trip::find($id);
        if (!$trip) {
            return redirect()->back()->with('error', 'Trip not found.');
        }

        SelectedTrip::create([
            'trip_id' => $trip->id,
            'type' => $trip->type,
            'distance' => $trip->distance,
            'cost' => $trip->cost,
            'name' => $trip->name,
            'address' => $trip->address,
            'contact' => $trip->contact,
            'schedule' => $trip->schedule,
        ]);

        $trip->delete();

        return redirect()->back()->with('success', 'Trip selected and moved successfully!');
    }



    public function assignTrip($id)
    {
        $selectedTrip = SelectedTrip::findOrFail($id);
    
        $truckerName = session('trucker.trucker_name');
    
        $assignedTrip = new AssignedTrip();
        $assignedTrip->trip_id = $selectedTrip->trip_id;         
        $assignedTrip->transaction_id = $selectedTrip->transaction_id; 
        $assignedTrip->status = 'pending';  
        $assignedTrip->type = $selectedTrip->type;
        $assignedTrip->distance = $selectedTrip->distance;
        $assignedTrip->cost = $selectedTrip->cost;
        $assignedTrip->name = $selectedTrip->name;
        $assignedTrip->address = $selectedTrip->address;
        $assignedTrip->contact = $selectedTrip->contact;
        $assignedTrip->schedule = $selectedTrip->schedule;
        $assignedTrip->compname = $selectedTrip->compname;
        $assignedTrip->owner_name = $selectedTrip->owner_name;
        $assignedTrip->trucker_name = $truckerName;  
    
        $assignedTrip->save();
    
       
        $selectedTrip->delete();
    
        return redirect()->back()->with('success', 'Trip selected successfully.');
    }
    

public function complete($id)
{
    $trip = AssignedTrip::findOrFail($id);

    CompletedTrip::create([
        'transaction_id' => $trip->transaction_id,        
        'type' => $trip->type,
        'distance' => $trip->distance,
        'cost' => $trip->cost,
        'name' => $trip->name,
        'address' => $trip->address,
        'contact' => $trip->contact,
        'schedule' => $trip->schedule,
        'compname' => $trip->compname,
        'owner_name' => $trip->compname,
        'trucker_name' => $trip->trucker_name,
    ]);

        $trip->delete();

        return redirect()->back()->with('success', 'Trip completed successfully!');
    }

    public function notifications()
    {

        if (!Session::has('trucker')) {
            return redirect()->route('truckerslogin')->withErrors('Please log in to access the Dashboard!');
        }
    
        $compname = Session::get('compname'); 
        $userType = Session::get('usertype');  
        $userId = Session::get('trucker');   
    
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
            $completedTrips = CompletedTrip::where('compname', session('trucker.compname'))
                                           ->paginate(10);
            $allCompletedTrips = CompletedTrip::where('compname', session('trucker.compname'))->get();

    
        return view('trucker.notifications', compact('messages', 'readNotificationsCount','allAssignedTrips','trips', 'allCompletedTrips', 'selectedTrips', 'assignedTrips', 'completedTrips'));
    }
    
    public function markAsRead($id)
    {
        if (!Session::has('trucker')) {
            return redirect()->route('truckerslogin')->withErrors('Please log in to access the Dashboard!');
        }

        $message = Message::where('id', $id)
            ->where('usertype', Session::get('trucker'))
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
        if (!Session::has('trucker')) {
            return redirect()->route('truckerslogin')->withErrors('Please log in to access the Dashboard!');
        }

        $message = Message::where('id', $id)
            ->where('usertype', Session::get('trucker'))
            ->firstOrFail();

        $message->update(['read_at' => null]);

        return redirect()->back()->with('success', 'Notification marked as unread.');
    }


    public function edit($id)
    {
        $users = User::findOrFail($id);
        return view('trucker.edit', compact('users'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'compname' => 'required|string|max:255',
            'trucker_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'trucker_phone' => 'required|string|max:15',
            'dob' => 'required|date|before:today',
            'trucker_address' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id, 

        ]);

        $users = User::findOrFail($id);
        $users->update($validatedData); 
        return redirect()->route('trucker')->with('success', 'Trucker  updated successfully');
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete(); 

        return redirect()->route('truckers')->with('success', 'Trucker deleted successfully');
    }

 }
