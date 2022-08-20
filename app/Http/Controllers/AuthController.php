<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(Request $request)
    {

        if (!Auth::check() && $request->path() != '/') {
            return redirect('/');
        }

        if (!Auth::check() && $request->path() == '/') {

            return view('welcome');
        }
        if (Auth::check() && ($request->path() == 'login' || $request->path() == 'register' || $request->path() == '/')) {
            return redirect('/home');
        }
        return view('home');

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
                    'regex:/[a-z]+(_cse)?@lus\.ac\.bd/'
                ],
                'password' => 'bail|required|confirmed|min:2|max:20',
                'password_confirmation' => 'required',
                'designation' => 'required',
                'department' => 'required',

                // 'password' => ['required',
                //    'min:8',
                //    'max:20',
                //    'regex:/^.*((?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%&*<+_-])).*$/',
                //    'confirmed'],

            ],
            [
                'name.regex' => 'Only Characters are allowed!!',
                'email.regex' => 'Please provide your Institutional email!!',
                'password.regex' => '1 upper, 1 lower, 1 digit'
            ]
        );
        $isVerifiedCode = rand( 100000 , 999999 );
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'department' => $request->department,
            'designation' => $request->designation,
            'isVerifiedCode' => $isVerifiedCode, 
        ]);

        $body = 'You have created an <b>LURC<b> account associated with ' . $request->email . '. Your OTP for Email verification is: '. $isVerifiedCode;

        \Mail::send('email-template', ['body' => $body], function ($message) use ($request) {
            $message->to($request->email)
                ->from('noreply@example.com', 'LURC')
                ->subject('Email Verification');
        });

//         $message = 'Hello ' . $request->name . '<br>';
// 
//         $mail_data = [
//             'recipient' => $request->email,
//             'fromEmail' => 'noreply@lus.ac.bd',
//             'fromName' => $request->name,
//             'subject' => 'Email Verification',
//             'body' => $message,
//             'actionLink' => $verifyURL,
//         ];
// 
//         \Mail::send('email-template', $mail_data, function ($message) use ($mail_data) {
//             $message->to($mail_data['recipient'])
//                 ->from($mail_data['fromEmail'], 'LURC')
//                 ->subject($mail_data['subject']);
//         });
        return response()->json(['msg'=>'Registered successfully. We have sent an OTP to your email. Submit your OTP to verify your account. To login, wait for the approval of admin.','status'=>$user], 201);

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
                'password' => 'bail|required|confirmed|min:2|max:20',
                'password_confirmation' => 'required',
                'batch' => 'required',
                'department' => 'required',

                // 'password' => ['required',
                //    'min:8',
                //    'max:20',
                //    'regex:/^.*((?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%&*<+_-])).*$/',
                //    'confirmed'],

            ],
            [
                'name.regex' => 'Only Characters are allowed!!',
                'email.regex' => 'Please provide your Institutional email!!',
                'password.regex' => '1 upper, 1 lower, 1 digit'
            ]
        );
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'department' => $request->department,
            'designation' => $request->batch,
        ]);

        $isVerifiedCode = rand( 100000 , 999999 );
        User::where('email', $request->email)->update([
            'otp' => $otp,
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'department' => $request->department,
            'designation' => $request->designation,
            'isVerifiedCode' => $isVerifiedCode, 
        ]);

        $body = 'You have created an <b>LURC<b> account associated with ' . $request->email . '. Your OTP for Email verification is: '. $isVerifiedCode;

        \Mail::send('email-template', ['body' => $body], function ($message) use ($request) {
            $message->to($request->email)
                ->from('noreply@example.com', 'LURC')
                ->subject('Email Verification');
        });
        return $user;
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

        
        $check = User::where('email', $request->email)->where('isEmailVerified', 1)->count();
        if ($check==1) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json([
                    'success' => true,
                    'msg' => 'You are logged in',
                ], 200);
            } else{
                return response()->json([
                    'success' => false,
                    'msg' => 'Your email is not verified!!'
                ], 401);
            } 
        } else{
            $isVerifiedCode = rand( 100000 , 999999 );
                User::where('email', $request->email)->update([
                    'isVerifiedCode' => $isVerifiedCode,
                ]);
                $body = 'You have created an <b>LURC<b> account associated with ' . $request->email . '. Your OTP for Email verification is: '. $isVerifiedCode;

                \Mail::send('email-template', ['body' => $body], function ($message) use ($request) {
                    $message->to($request->email)
                        ->from('noreply@example.com', 'LURC')
                        ->subject('Email Verification');
                });
                
                return response()->json([
                    'success' => false,
                    'msg' => 'Your email is not verified!!  We have sent an OTP to your email. Submit your OTP to verify your account. To login, wait for the approval of admin.'
                ], 402);
        }
    }

    function logout()
    {
        Auth::logout();
        // Session::flush();
        // Session::forget('url.intented');
        return redirect('/');
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $check = User::where('email', $request->email)->where('isVerifiedCode', $request->otp)->count();
        \Log::info('check');
        \Log::info($check);
        if($check == 1){
            User::where('email', $request->email)->update([
                'isEmailVerified' => 1,
            ]);
            return response()->json(['msg'=>'Email verified successfully!!','status'=>'success'], 200);
        } else{
            return response()->json(['msg'=>'Invalid OTP','status'=>'error'], 401);
        }

    }

    //For forgot password
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand( 100000 , 999999 );
        User::where('email', $request->email)->update([
            'otp' => $otp,
        ]);

        //$action_link = redirect('/reset')->route( ['token' => $token, 'email' => $request->email]);

        $body = 'We have received a request to reset the password for <b>LURC<b> account associated with ' . $request->email . '. Your OTP for reset password: '. $otp;

        \Mail::send('email-template', ['body' => $body], function ($message) use ($request) {
            $message->to($request->email)
                ->from('noreply@example.com', 'LURC')
                ->subject('Reset Password');
        });

        // return back()->with('success', 'We have e-mailed your password reset link!');
        return response()->json(['msg'=>'We have sent an OTP to your email.','status'=>$request->email], 200);
    }

    public function submitOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $check = User::where('email', $request->email)->where('otp', $request->otp)->count();
        \Log::info('check');
        \Log::info($check);
        if($check == 1){
            return response()->json(['msg'=>'Success','status'=>'success'], 200);
        } else{
            return response()->json(['msg'=>'Invalid OTP','status'=>'error'], 401);
        }

        
    }

    public function resetPassword(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:2|max:20',
            'password_confirmation' => 'required',
        ]);
        $check = User::where('email', $request->email)->where('otp', $request->otp)->count();
        if($check == 1){
        User::where('email', $request->email)->update([
            'password' => \Hash::make($request->password),
        ]);
        return response()->json(['msg'=>'Password updated successfully','status'=>'success'], 200);
        } else{
            return response()->json(['msg'=>'Invalid OTP','status'=>'error'], 401);
        }
    }
}
