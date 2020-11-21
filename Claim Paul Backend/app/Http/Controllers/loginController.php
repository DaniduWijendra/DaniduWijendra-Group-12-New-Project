<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\userSignUp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\resetPasswordMailable;
use App\Models\passwordReset;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class loginController extends Controller
{
    public function login(Request $request)
    {
       
        // $request->validate([
        //     'email' => ['required'],
        //     'password' => ['required']
        // ]);

        // if (Auth::attempt($request->only('email', 'password'))) {
        //     return response()->json(Auth::user(), 200);
        // }

        // throw ValidationException::withMessages([
        //     'email' => ['The provided credentials are incorrect.']
        // ]);

        $user = Auth::user();

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function getLogin($email)
    {
        $item=DB::table('users')->where('email', $email)->exists();

        if(!$item)
        {
            return response()->json(['msg'=>'this record is not found'],404);
        }

        else{

            $users =DB::table('users')->where('email', $email)->get();

            return response()->json(['users'=>$users],200);

        }
    }

    public function logout()
    {
        Auth::logout();
    }

    
    

    public function sendToken(Request $request){

        $user = User::where('email', $request->email)->first();
        if(!isset($user->id))
        {
            return response()->json(['msg'=>'this user is not found'],401); 
        }

        $token=Str::random();

        Mail::to($user)->send(new resetPasswordMailable($token));

        passwordReset::create([

            'email'=>$user->email,
            'token'=>$token,
            

        ]);
    }

    public function validateToken(Request $request)
    {
        $passwordReset = passwordReset::where('token', $request->token)->first();
        if(!isset($passwordReset->email))
        {
            return response()->json(['error'=>'this is invalid token '],401); 
        }

        $user = User::where('email', $passwordReset->email)->first();
        return response()->json($user,200); 
    }

    public function resetPassword(Request $request)
    {
        $user=User::find($request->id);

        $passwordReset = passwordReset::where('email', $user->email)->first();
        $passwordReset->delete();

        $user->password=Hash::make($request->password);
        $user->save();


    }

     /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();

        // $user->token;
    }
}
