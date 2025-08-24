<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletedTrip;
use App\Models\SettledTrip;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }



    public function settle($id)
{
    $trip = CompletedTrip::findOrFail($id);

    SettledTrip::create([
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

        return redirect()->back()->with('success', 'Trip settled successfully!');
    }

        

}


