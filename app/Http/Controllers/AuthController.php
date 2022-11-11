<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check() && $request->path() != '/') {
            return redirect('/');
        }

        if (!Auth::check()) {
            return view('welcome');
        }

        if (Auth::check() && ($request->path() == 'login' || $request->path() == 'register' || $request->path() == '/')) {
            return redirect('/home');
        }
        return view('welcome');

        //first check if you are loggedin and admin user ...
        // if (Auth::check()) {
        //     return view('home');
        // } else {
        //     if ($request->path() == '/register') {
        //         return redirect('/index');
        //         return view('welcome');
        //     }
        //     if ($request->path() == '/register') {
        //         return redirect('/register');
        //     }
        //     if ($request->path() != 'login') {
        //         return redirect('/login');
        //     }
        //     if ($request->path() == 'login') {
        //         return view('welcome');
        //     }
        // }


        // // you are already logged in... so check for if you are an admin user..
        // $user = Auth::user();
        // if ($user->userType == 'User') {
        //     return redirect('/login');
        // }
        // if ($request->path() == 'login') {
        //     return redirect('/');
        // }
    }
    //create new teacher in db
    function register_t(Request $request)
    {
        //return $request->input();
        //validate Request
        $request->validate(
            [
                'name' => 'bail|required|regex:/^[a-zA-z. ]+$/',
                'email' => [
                    'required',
                    'max:50',
                    'email',
                    'unique:users,email',
                    'exists:teachers,email',
                    'regex:/[a-z]+(_cse)?@lus\.ac\.bd/'
                ],
                // 'password' => 'bail|required|confirmed|min:2|max:20',
                'password' => ['required',
                   'min:8',
                   'max:20',
                   'regex:/^.*((?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%&*<+_-])).*$/',
                   'confirmed'],
                'password_confirmation' => 'required',
                'designation' => 'required',
                'department' => 'required',
            ],
            [
                'name.regex' => 'Only Characters are allowed!!',
                'email.regex' => 'Please provide your Institutional email!!',
                'email.exists' => 'This is not a teacher email!!',
                'password.regex' => '1 upper, 1 lower, 1 digit'
            ]
        );

        $isVerifiedCode = rand(100000, 999999);
        $expires_at = now();
        // $name = $request->name;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'department' => $request->department,
            'designation' => $request->designation,
            'userType' => 'teacher',
            'isVerifiedCode' => $isVerifiedCode,
            'expires_at' => $expires_at,
        ]);
        // return $name;
        $body = 'You have created an <b>LURC<b> account associated with ' . $request->email . '. Your OTP for Email verification is: ' . $isVerifiedCode;

        \Mail::send('email-template', ['body' => $body], function ($message) use ($request) {
            $message->to($request->email)
                ->from('noreply@lurc.com', 'LURC')
                ->subject('Email Verification');
        });

        return response()->json(['msg' => 'Registered successfully. We have sent an OTP to your email. Submit your OTP to verify your account. To login, wait for the approval of admin.', 'status' => $user], 201);
    }

    //create new student in db
    function register_s(Request $request)
    {
        //return $request->input();
        //validate Request
        $request->validate(
            [
                'name' => 'bail|required|regex:/^[a-zA-z. ]+$/',
                'email' => [
                    'required',
                    'max:50',
                    'email',
                    'unique:users,email',
                    'regex:/(cse|eee|ce|arch|law|bba|eng|bng)_\d{10}@lus\.ac\.bd/'
                ],
                // 'password' => 'bail|required|confirmed|min:2|max:20',
                'password' => ['required',
                   'min:8',
                   'max:20',
                   'regex:/^.*((?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%&*<+_-])).*$/',
                   'confirmed'],
                'password_confirmation' => 'required',
                'batch' => 'required',
                'department' => 'required',  
            ],
            [
                'name.regex' => 'Only Characters are allowed!!',
                'email.regex' => 'Please provide your Institutional email!!',
                'password.regex' => '1 upper, 1 lower, 1 digit'
            ]
        );
        
        $isVerifiedCode = rand(100000, 999999);
        $expires_at = now();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'department' => $request->department,
            'designation' => 'Student',
            'userType' => 'student',
            'isVerifiedCode' => $isVerifiedCode,
            'expires_at' => $expires_at,
        ]);

        $body = 'You have created an <b>LURC<b> account associated with ' . $request->email . '. Your OTP for Email verification is: ' . $isVerifiedCode;

        \Mail::send('email-template', ['body' => $body], function ($message) use ($request) {
            $message->to($request->email)
                ->from('noreply@lurc.com', 'LURC')
                ->subject('Email Verification');
        });

        return response()->json(['msg' => 'Registered successfully. We have sent an OTP to your email. Submit your OTP to verify your account.', 'status' => $user], 201);
        return $user;
    }

    //email verification 
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);
        $time_now = now();
        \Log::info('Time Now');
        \Log::info($time_now);  
        
        $previous_time = now()->subMinutes(5);
        \Log::info($previous_time);

        if(User::where('email', $request->email)->where('isVerifiedCode', $request->otp)->count()==0){
            User::where('email', $request->email)->update([
                'isVerifiedCode' => null,
                'expires_at' => null,
            ]);
            return response()->json([
                'success' => false,
                'msg' => 'Invalid Token!!'
            ], 401);
        }
        if(User::where('email', $request->email)->whereBetween('expires_at', [$previous_time, $time_now])->count()==0){
            User::where('email', $request->email)->update([
                'isVerifiedCode' => null,
                'expires_at' => null,
            ]);
            return response()->json([
                'success' => false,
                'msg' => 'Token Expired!!'
            ], 402);
        }             
        
        else {
            User::where('email', $request->email)->update([
                'isEmailVerified' => 1,
                'isVerifiedCode' => null,
            ]);
            return response()->json(['msg' => 'Email verified successfully!!', 'status' => 'success'], 200);
        }
    }

    
        public function login(Request $request)
        {
            $request->validate([
                'email' => 'bail|required|email|exists:users,email',
                'password' => 'bail|required|min:2|max:20',
            ], ['email.exists' => 'No account found for this email']);
    
            // if (User::where('email', $request->email)->where('userType', '!=', 0)->count() == 0) {
            // 
            //             return response()->json([
            //                 'success' => false,
            //                 'admin' => 'not-found'
            //             ], 401);
            //         }
    
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json([
                    'success' => true,
                    'msg' => 'You are logged in',
                ], 200);
            } else {
                return response()->json([
                    'msg' => 'Incorrect Password!!',
                    'success' => false
                ], 401);
            }
        }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'bail|required|email|exists:users,email',
    //         'password' => 'bail|required|min:2|max:20',
    //     ], ['email.exists' => 'No account found for this email']);

    //     // if (User::where('email', $request->email)->where('userType', '!=', 0)->count() == 0) {
    //     // 
    //     //             return response()->json([
    //     //                 'success' => false,
    //     //                 'admin' => 'not-found'
    //     //             ], 401);
    //     //         }

    //     // $checkUser = User::where('email', $request->email)->where(Hash::check('password', $request->password))->count();
    //     $input = $request->all();
    //     $data = User::select('id', 'email', 'password')->where('email', $input['email'])->first();
    //     // \Log::info($data);

    //     //The makeVisible method returns the model instance
    //     $data->makeVisible('password')->toArray();

    //     // return $data;
    //     $checkUser = Hash::check($input['password'], $data->password);
    //     if ($checkUser) {
    //         $check = User::where('email', $request->email)->where('isEmailVerified', 1)->count();
    //         if ($check == 1) {
    //             $twoFactorCode = rand(100000, 999999);
    //             $expires_at = now();
    //             \Log::info($expires_at);
    //             User::where('email', $request->email)->update([
    //                 'twoFactorCode' => $twoFactorCode,
    //                 'expires_at' => $expires_at,
    //             ]);
    //             $body = 'You have created an <b>LURC<b> account associated with ' . $request->email . '. Your OTP for Two factor authentication is: ' . $twoFactorCode;

    //             \Mail::send('email-template', ['body' => $body], function ($message) use ($request) {
    //                 $message->to($request->email)
    //                     ->from('noreply@lurc.com', 'LURC')
    //                     ->subject('Two Factor Authentication');
    //             });

    //             return response()->json([
    //                 'success' => true,
    //                 'msg' => 'We have sent a two factor authentication code to your email.'
    //             ], 200);
    //         } else {
    //             $isVerifiedCode = rand(100000, 999999);
    //             User::where('email', $request->email)->update([
    //                 'isVerifiedCode' => $isVerifiedCode,
    //             ]);
    //             $body = 'You have created an <b>LURC<b> account associated with ' . $request->email . '. Your OTP for Email verification is: ' . $isVerifiedCode;

    //             \Mail::send('email-template', ['body' => $body], function ($message) use ($request) {
    //                 $message->to($request->email)
    //                     ->from('noreply@lurc.com', 'LURC')
    //                     ->subject('Email Verification');
    //             });

    //             return response()->json([
    //                 'success' => false,
    //                 'msg' => 'Your email is not verified!!  We have sent an OTP to your email. Submit your OTP to verify your account.'
    //             ], 402);
    //         }
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'msg' => 'Incorrect Password',
    //         ], 401);
    //     }
    // }

    public function submitTwoFactorCode(Request $request)
    {
        $request->validate([
            'twoFactorCode' => 'required',
        ]);

        $time_now = now();
        \Log::info('Time Now');
        \Log::info($time_now);  
        
        $previous_time = now()->subMinutes(5);
        \Log::info($previous_time);

        if(User::where('email', $request->email)->where('twoFactorCode', $request->twoFactorCode)->count()==0){
            
            return response()->json([
                'success' => false,
                'msg' => 'Invalid Token!!'
            ], 401);
        }
        if(User::where('email', $request->email)->whereBetween('expires_at', [$previous_time, $time_now])->count()==0){
            User::where('email', $request->email)->update([
                'twoFactorCode' => null,
                'expires_at' => null,
            ]);
            return response()->json([
                'success' => false,
                'msg' => 'Token Expired!!'
            ], 402);
        }             
        
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            User::where('email', $request->email)->update([
                'twoFactorCode' => null,
                'expires_at' => null,
            ]);
            return response()->json([
                'success' => true,
                'msg' => 'You are logged in',
            ], 200); 
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Failed!!'
            ], 401);
        
        } 
    }

    //For Reset password
    public function sendResetPassOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(100000, 999999);
        $expires_at = now();
        User::where('email', $request->email)->update([
            'reset_pass_otp' => $otp,
            'expires_at' => $expires_at,
        ]);

        //$action_link = redirect('/reset')->route( ['token' => $token, 'email' => $request->email]);

        $body = 'We have received a request to reset the password for <b>LURC<b> account associated with ' . $request->email . '. Your OTP for reset password: ' . $otp;

        \Mail::send('email-template', ['body' => $body], function ($message) use ($request) {
            $message->to($request->email)
                ->from('noreply@example.com', 'LURC')
                ->subject('Reset Password');
        });

        return response()->json(['msg' => 'We have sent an OTP to your email.', 'status' => $request->email], 200);
    }

    public function submitResetPassOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $time_now = now();
        \Log::info('Time Now');
        \Log::info($time_now);  
        
        $previous_time = now()->subMinutes(5);
        \Log::info($previous_time);

        if(User::where('email', $request->email)->where('reset_pass_otp', $request->otp)->count()==0){
            User::where('email', $request->email)->update([
                'reset_pass_otp' => null,
                'expires_at' => null,
            ]);
            return response()->json([
                'success' => false,
                'msg' => 'Invalid Token!!'
            ], 401);
        }
        if(User::where('email', $request->email)->whereBetween('expires_at', [$previous_time, $time_now])->count()==0){
            User::where('email', $request->email)->update([
                'reset_pass_otp' => null,
                'expires_at' => null,
            ]);
            return response()->json([
                'success' => false,
                'msg' => 'Token Expired!!'
            ], 402);
        }   
        else {
            return response()->json(['msg' => 'Success!!', 'status' => 'success'], 200);
        } 
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:2|max:20',
            'password_confirmation' => 'required',
        ]);
        $check = User::where('email', $request->email)->where('reset_pass_otp', $request->otp)->count();
        if ($check == 1) {
            User::where('email', $request->email)->update([
                'password' => \Hash::make($request->password),
                'reset_pass_otp' => null,
                'expires_at' => null,
            ]);
            return response()->json(['msg' => 'Password updated successfully', 'status' => 'success'], 200);
        } else {
            return response()->json(['msg' => 'Invalid OTP', 'status' => 'error'], 401);
        }
    }

    function logout()
    {
        // Auth::logout();
        // Session::flush();
        // Session::forget('url.intented');
        Auth::guard('web')->logout();
        return response()->json([
            'success' => true,
            'msg' => 'You are Logged Out',
        ], 200);
    }
}
