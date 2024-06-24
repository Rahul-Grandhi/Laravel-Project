<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserPhoneRequest;
use App\Models\Customer;
use App\Models\Transporter;
use Illuminate\Support\Facades\Log;
use Exception;

class UsersController extends Controller
{
    public function create_user(UserRequest $request)
    {
        try{


            if($request['resource_type']==='customer')
            {
                $resource = Customer::create(['phone'=>$request['phone']]);
            }
            else
            {
                $resource = Transporter::create(['phone'=>$request['phone']]);
            }

            $user = User::create([
                'name'=> $request['name'],
                'resource_type'=> $request['resource_type'],
                'resource_id'=> $resource->id,
            ]);

            return response()->json([
                'message'=> 'User created successfully',
                'user_id'=> $user->user_id,
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'Failed to create user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function get_user($user_id)
    {
        try{
            $user = User::with('resource')->findOrFail($user_id);

            Log::info('User found: ' . $user->toJson());

            return new UserResource($user);
        }

        catch(Exception $e)
        {
            return response()->json([
                'message'=>"user not found",
                'error'=> $e->getMessage(),
            ]);
        }

    }

    public function softdeleteuser($user_id){
        try {
            $user = User::findOrFail($user_id);

            $user->delete();
            return response()->json([
                'success'=> true,
                'message'=>'User deleted succesfully',
                'user'=> $user->user_id,
                ],200);
        }
        catch (Exception $e) {
            return response()->json([
                'success'=> false,
                'message'=> 'User not found',
                'error'=> $e->getMessage(),
                ],404);
        }
    }

    public function update_user_phone(UpdateUserPhoneRequest $request,$user_id){
        try{
            $user = User::findOrFail($user_id);

            if ($user->resource_type === 'customer' || $user->resource_type === 'transporter') {
                $relatedModel = $user->resource;
            } else {
                throw new Exception('Invalid resource type');
            }

            $relatedModel->phone = $request->input('phone');
            $relatedModel->save();

            return new UserResource($user);
        }
        catch (Exception $e){
            return response()->json([
                'message'=> "Error updating the user phone",
                'error'=> $e->getMessage()
            ]);
        }
    }
   
    public function getusers(Request $request){

        try{
            $page_limit = $request->query('pagelimit',3);

            $users = User::paginate($page_limit);

            return UserResource::collection($users);
        }
        catch(Exception $e){
            return response()->json([
                'success'=> false,
                'error'=> $e->getMessage()
            ],500);
        }
    }
}
