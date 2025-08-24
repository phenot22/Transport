<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\ArchivedTrip;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SelectedTrip;
use App\Models\CompletedTrip;
use App\Models\AssignedTrip;
use App\Models\SettledTrip;
use App\Models\Message;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;


class TripController extends Controller
{

    public function index(Request $request)
    {
        if (!Session::has('admin')) {
            return redirect()->route('adminlogin')->withErrors('Please log in to access the Dashboard!');
        }
    
            $sortBy = $request->get('sort_by', 'id'); 
            $sortOrder = $request->get('sort_order', 'asc'); 
    
            $trips = Trip::orderBy($sortBy, $sortOrder)->paginate(10);
    
            $allTrips = Trip::all(); 
    
            $totalDistance = $allTrips->sum('distance');
            $totalCost = $allTrips->sum('cost');
            $dryCount = $allTrips->where('type', 'Dry')->count();
            $chilledCount = $allTrips->where('type', 'Chilled')->count();
            $dryTotalCost = $allTrips->where('type', 'Dry')->sum('cost');
            $chilledTotalCost = $allTrips->where('type', 'Chilled')->sum('cost');
    
            return view('trip.index', compact(
                'trips', 
                'totalDistance', 
                'totalCost', 
                'dryCount', 
                'chilledCount', 
                'dryTotalCost', 
                'chilledTotalCost'
            ));
        
            return redirect('adminlogin')->with('success', 'Please log in to access the Trips List!');
    }
    

    

    public function create()
    {
        if (!Session::has('admin')) {
            return redirect()->route('adminlogin')->withErrors('Please log in to access the Dashboard!');
        }
            return view('trip.create');
    
        return redirect('adminlogin')->withSuccess('Please log in to access the Trips List!');

    }

    public function store(Request $request){
        $data = $request->validate([
            'status' => 'required',
            'type' => 'required',
            'transaction_id' => 'required',            
            'distance' => 'required|decimal:0,2',
            'cost' => 'required|decimal:0,2',
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required|numeric',
            'schedule' => 'required'
        ]);


        $newTrip = Trip::create($data);

        return redirect(route('index'))->with('success', 'Trip Created successfully.');

        }

        public function edit(Trip $trip){
            return view('trip.edit', ['trip' => $trip]);

        }

        public function update(Trip $trip, Request $request){
            $data = $request->validate([
                'type' => 'required',
                'distance' => 'required|decimal:0,2',
                'cost' => 'required|decimal:0,2',
                'name' => 'required',
                'address' => 'required',
                'contact' => 'required|numeric',
                'schedule' => 'required'
            ]);

            $trip->update($data);

            return redirect(route('index'))->with('success', 'Trip Updated Successfully!');

        }

        public function destroy(Trip $trip) {
            ArchivedTrip::create($trip->toArray());
        
            $trip->delete();
        
            return redirect()->route('index')->with('success', 'Trip deleted successfully.');
        }

        public function archived() {
            if (!Session::has('admin')) {
                return redirect('adminlogin')->withErrors('Please log in to access the Archive List!');
            }

            $archivedTrips = ArchivedTrip::paginate(10);
            return view('archive', compact('archivedTrips'));
        }
        
        public function restore($id)
        {
            $archivedTrip = ArchivedTrip::findOrFail($id);
    
            Trip::create(array_merge($archivedTrip->toArray(), ['status' => 'pending']));
    
            $archivedTrip->delete();
    
            return redirect()->route('archive')->with('success', 'Trip restored successfully.');
        }

        public function selectTrip(Request $request, $id)
        {
            $trip = Trip::find($id);
        
            if (!$trip) {
                return redirect()->back()->with('error', 'Trip not found.');
            }
        
            $compname = session('company.compname');
            $ownerName = session('company.owner_name');
        
            SelectedTrip::create([
                'trip_id' => $trip->id,
                'transaction_id' => $trip->transaction_id,
                'type' => $trip->type,
                'distance' => $trip->distance,
                'cost' => $trip->cost,
                'name' => $trip->name,
                'address' => $trip->address,
                'contact' => $trip->contact,
                'schedule' => $trip->schedule,
                'compname' => $compname,
                'owner_name' => $ownerName,
            ]);
        
            Trip::where('id', $trip->id)->delete();
        
            return redirect()->back()->with('success', 'Trip selected successfully!');
        }

        
        public function completedtrips(Request $request)
        {

            if (!Session::has('admin')) {
                return redirect('adminlogin')->withErrors('Please log in to access the Completed Trips!');
            }
        
            $sortBy = $request->get('sort_by', 'id'); 
            $sortOrder = $request->get('sort_order', 'asc'); 

            
            $completedTrips = CompletedTrip::orderBy($sortBy, $sortOrder)->paginate(10);
        
            $companies = Company::all();
        
            // Build query for settled trips
            $settledQuery = SettledTrip::query();
        
            if ($request->filled('company')) {
                $settledQuery->where('compname', $request->company);
            }
        
            if ($request->filled('start_date')) {
                $settledQuery->whereDate('created_at', '>=', $request->start_date);
            }
        
            if ($request->filled('end_date')) {
                $settledQuery->whereDate('updated_at', '<=', $request->end_date);
            }
        
            $settledTrips = $settledQuery->get();
        
            $summaryByCompany = $settledTrips->groupBy('compname')->map(function ($group) {
                return $group->sum('cost');
            });
        
        
            return view('completedtrips', compact('completedTrips', 'settledTrips', 'companies', 'summaryByCompany'));
        }
        
        

        public function pendingtrips(Request $request)
        {
            if (!Session::has('admin')) {
                return redirect('adminlogin')->withErrors('Please log in to access!');
            }
        
            $sortBy = $request->get('sort_by', 'id'); 
            $sortOrder = $request->get('sort_order', 'asc'); 
        
            $selectedTrips = SelectedTrip::all();
            $assignedTrips = AssignedTrip::all();
        
            $pendingTripsCollection = $assignedTrips->concat($selectedTrips);
        
            if ($sortBy && $pendingTripsCollection->first() && isset($pendingTripsCollection->first()->$sortBy)) {
                $pendingTripsCollection = $sortOrder === 'desc'
                    ? $pendingTripsCollection->sortByDesc($sortBy)
                    : $pendingTripsCollection->sortBy($sortBy);
            }
        
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 10;
            $currentItems = $pendingTripsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $pendingTrips = new LengthAwarePaginator(
                $currentItems,
                $pendingTripsCollection->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        
            return view('pendingtrips', compact('selectedTrips', 'assignedTrips', 'pendingTrips'));
        }
        
        


        public function reject($id)
        {
        $assignedTrip = AssignedTrip::findOrFail($id);
    
        SelectedTrip::create(array_merge($assignedTrip->toArray(), ['status' => 'pending']));
    
        $assignedTrip->delete();
    
        return redirect()->route('company.pendingtrips')->with('success', 'Trip rejected successfully.');
        }



    public function cancel(Request $request, $id)
    {
    $request->validate([
        'cancel_reason' => 'required|string|max:255',
        'transaction_id' => 'required|string|max:100',         
    ]);

    $selectedTrip = SelectedTrip::findOrFail($id);

    Trip::create(array_merge($selectedTrip->toArray(), ['status' => 'pending']));

    $selectedTrip->delete();

    $sessionName = session('company.owner_name', 'Unknown User');
    $sessionComp = session('company.compname', 'Unknown Company');

    $admins = User::where('usertype', 'admin')->get();
    foreach ($admins as $admin) {
        DB::table('messages')->insert([
            'usertype' => $admin->id,
            'message' => 'Cancelled by: ' . $sessionName .' of ' . $sessionComp. ' Company'. '<br>'
                        . 'Transaction ID: ' . $request->transaction_id . '<br>'
                        . 'Reason: ' . $request->cancel_reason,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()->route('company.selectedtrips')->with('success', 'Trip cancelled successfully and admin notified.');
    }


        
    public function cancel1(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            'transaction_id' => 'required|string|max:100', 

        ]);
    
        $assignedTrip = AssignedTrip::findOrFail($id);
    
        SelectedTrip::create(array_merge($assignedTrip->toArray(), ['status' => 'pending']));
    
        $assignedTrip->delete();
    
        $companyName = $assignedTrip->compname; 
    
        $companyUser = User::where('compname', $companyName)->first(); 

        $sessionName = session('trucker.trucker_name', 'Unknown User');
    
    
        if ($companyUser) {
            DB::table('messages')->insert([
                'usertype' => $companyUser->id,
                'message' => 'Cancelled by: ' . $sessionName . '<br>'
                            . 'Transaction ID: ' . $request->transaction_id . '<br>'
                            . 'Reason: ' . $request->cancel_reason,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        return redirect()->route('trucker.selectedtrips')->with('success', 'Trip cancelled successfully and company notified.');
    }
    
    
    public function reject1(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            'transaction_id' => 'required|string|max:100',             
        ]);
    
        $assignedTrip = AssignedTrip::findOrFail($id);
    
        SelectedTrip::create(array_merge($assignedTrip->toArray(), ['status' => 'pending']));
    
        $assignedTrip->delete();
    
        $trucker = $assignedTrip->compname;
        $trucker = User::where('trucker_name', $assignedTrip->trucker_name)->first(); 

        $sessionName = session('company.owner_name', 'Unknown User');
    
        if ($trucker) {
            DB::table('messages')->insert([
                'usertype' => $trucker->id,
                'message' => 'Rejected by: ' . $sessionName . '<br>'
                            .'Transaction ID: ' . $request->transaction_id . '<br>'
                            .'Reason: ' . $request->cancel_reason,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        return redirect()->route('company.pendingtrips')->with('success', 'Trip cancelled successfully and trucker notified.');
    }
    
        
    }