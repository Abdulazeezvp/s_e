<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = [];
        $code = 200;
        try{
            $users = User::all();
            $response = [
                'status'=>'success',
                "users"=>$users
            ];

        }catch(Exception $e){
              $response = [
                'status'=>'error',
                "data"=>$e->getMessage()
            ];
            $code = 500;
        }
        return response()->json($response,$code);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password'=>'required',
            'type'=>'string'
        ]);
        $response = [];
        $code = 200;
        if ($validator->fails()) {
            $response =[
                'status'=>'error',
                'data'=>$validator
            ];
            return response()->json($response,422);
        }
        $data = $request->all();
        DB::beginTransaction();
        try{
            $user = User::create(
               $data
            );
             $response =[
                'status'=>'error',
                'user'=>$user
            ];
             DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(
                [
                    'status'=>'error',
                    'data'=>$e->getMessage()
                ],500
            );
        }
        return response()->json($response,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
