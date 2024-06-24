<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShelfResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Shelf;
use App\Models\ShelfHasBooks;
use App\Models\Books;
use Exception;

class ShelfController extends Controller
{
    
    public function create_shelf(Request $request)
    {
        $rules = [
            'user_id'=> 'required|integer|exists:users,id',
            'name'=>'required|string|max:255'
        ];

        $messages = [
            'user_id.required' => 'User ID is required',
            'user_id.integer' => 'User ID must be an integer',
            'user_id.exists' => 'User not found',
            'name.required' => 'Shelf name is required',
            'name.string' => 'Shelf name must be a string',
            'name.max' => 'Shelf name may not be greater than 255 characters'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return response()->json([
                'success'=> false,
                'message'=> $validator->errors()
            ],422);
        }

        try {
            $user = User::withTrashed()->find($request->input('user_id'));

            if ($user === null || $user->trashed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found or is deleted'
                ], 404);
            }

            $shelf = Shelf::create([
                'user_id'=> $request->input('user_id'),
                'name'=> $request->input('name'),
            ]);

            return response()->json([
                'success' => true,
                'data' => $shelf
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the shelf',
                'error' => $e->getMessage()
            ],500);
        }
    }


    public function assign_books(Request $request)
    {
        $rules=[
            'user_id'=> 'required|integer|exists:users,id',
            'shelf_id'=>'required|integer|exists:shelf,id',
            'book_id'=> 'required|integer|exists:books,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json([
                'success'=> false,
                'message'=> $validator->errors()
            ],422);
        }

        try{
            $bookassigned = ShelfHasBooks::where('book_id',$request->input('book_id'))->exists();

            if($bookassigned){
                return response()->json([
                    'success'=> false,
                    'message'=> 'The book already assigned to another shelf'
                ],409);
            }

            $shelf = Shelf::findOrFail($request->input('shelf_id'));

            if($shelf->user_id != $request->input('user_id')){
                return response()->json([
                    'success'=> false,
                    'message'=> 'The shelf does not belong to the user'
                ],403);
            }

            ShelfHasBooks::create([
                'shelf_id' => $request->input('shelf_id'),
                'book_id' => $request->input('book_id')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Book assigned to shelf successfully'
            ], 201);
        }
        catch(Exception $e){
            return response()->json([
                'success'=> false,
                'message'=> 'An error occured while assigning',
                'error'=> $e->getMessage()
            ],500);
        }
    }


    public function get_shelf($id)
    {
        try{
            $shelf = Shelf::with(['books','user'])->findOrFail($id);

            //$user = $shelf->users;

            $response=[
                'id'=> $shelf->id,
                'name'=> $shelf->name,
                'user_name'=>$shelf->user->name,
                'user_email'=> $shelf->user->email,
                'books'=> $shelf->books->map(function ($book) {
                    return [
                        'id'=> $book->id,
                        'name'=> $book->name,
                    ];
                })
            ];

            return response()->json([
                'success'=> true,
                'shelf'=> $response
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'success'=> false,
                'message'=>"Error occured while fetching details",
                "error"=> $e->getMessage()
                ],500);
            }
    }


    public function getshelves(Request $request)
    {
        try{
            $page_limit = $request->query('pagelimit',5);

            $shelves = Shelf::with('books')->paginate($page_limit);

            return ShelfResource::collection($shelves);
        }
        catch(Exception $e){
            return response()->json([
                'success'=> false,
                'error'=> $e->getMessage()
            ],500);
        }
    }
    
}
