<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTripRequest;
use App\Models\TripRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Resources\TripRequestResource;
use Exception;

class TripRequestController extends Controller
{
    //
    public function create_trip(StoreTripRequest $request)
    {
        try{
            $trip = TripRequest::create([
                'customer_id'=>$request['customer_id'],
                'transporter_id'=>$request['transporter_id'],
                'source'=> $request['source'],
                'destination'=>$request['destination'],
                'amount'=>$request['amount'],
                'status'=>$request['status']
            ]);
            return response()->json([
                'message'=>'Trip Create Successfully',
                'trip_id'=> $trip->id 
            ]);
        }
        catch (Exception $e)
        {
            return response()->json([
                'message' => 'Failed to create user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete_trip($id){
        try{
            $trip = TripRequest::findOrFail($id);
            $trip->delete();
            return response()->json([
                'message'=>'trip deleted successfully',
                'trip_id'=>$trip->id,
            ]);
        }
        catch(Exception $e)
        {
            return response()->json([
                'success'=> false,
                'message'=> 'Error Deleting trip',
                'error'=> $e->getMessage(),
            ],500);
        }
    }

    public function update_trip(UpdateStatusRequest $request,$id){
        try{
            $tripRequest = TripRequest::findOrFail($id);
            $tripRequest->update($request->all());
            return response()->json([
                'message'=> 'Trip Request updated successfully',
            ],200);
        }
        catch(Exception $e)
        {
            return response()->json([
                'message'=>'Error updating TripRequest',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    public function get_trip($id)
    {
        try{
            $trip = TripRequest::with(['customer.user','transporter.user'])->findOrFail($id);
            return new TripRequestResource($trip);
        }
        catch(Exception $e)
        {
            return response()->json([
                'message'=>"Trip not found",
                'error'=> $e->getMessage(),
            ]);
        }
    }
}
\\wsl.localhost\Ubuntu\home\rahul\proj1
