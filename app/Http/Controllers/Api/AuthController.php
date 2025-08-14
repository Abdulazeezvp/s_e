<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password'=>'required',
            'deviceName' =>'required'

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
        try{
        $user = User::where('email', $request->email)->first();
         if (! $user || ! Hash::check($request->password, $user->password)) {
            $response = [
                'status'=>"success",
                'data'=>['user'=>$user,'token'=>$user->createToken($request->device_name)->plainTextToken]
            ];
         }else{
                $response = [
                'status'=>"error",
                'data'=>['message'=>'Invalid details']
            ];
         }




        }catch(Exception $e){
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
