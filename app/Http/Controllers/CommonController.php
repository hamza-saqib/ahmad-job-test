<?php

namespace App\Http\Controllers;

use App\Mail\NewCompanyMail;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Mail;
use PharIo\Manifest\AuthorElement;

class CommonController extends Controller
{
    public function register(Request $request)
    {
        $email = $request->get('email');
        $user = User::where('email',$email)->first();
        if($user !== null){
            return response()->json([
                'status' => 'incomplete',
                'message' => 'Incomplete Registration',
            ], 200);
        }
        
        /* Validate User Input */
        $this->validator($request->all())->validate();
        //Create User
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        Auth::loginUsingId($user->id);
        return response()->json([
            'status' => 'success',
            'message' => 'User Registed Successfully',
        ], 200);
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'confirm_password'  => 'required|same:password',
        ]);
    }
    public function login(Request $request)
	{
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            $user = Auth::user();    
            return response()->json([
                'status' => 'success',
                'message' => 'User Logged In Successfully',
                'UserDetails' => $user,
            ], 200);
            
        } else{ 
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials.'
            ], 200); 
        }
    }
    
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Logout Successfully.'
        ], 200); 
    }
}
