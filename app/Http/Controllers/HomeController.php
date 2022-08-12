<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index(Request $request)
    {

        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }

        if (!Auth::check() && $request->path() == 'login') {

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
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'department' => $request->department,
            'designation' => $request->designation,
        ]);


        return $user;
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

        return $user;
    }


    public function login(Request $request)
    {
        // $request->validate([
        //     'email' => 'bail|required|email|exists:users,email',
        //     'password' => 'bail|required|min:2|max:20',
        // ], ['email.exists' => 'No account found for this email']);



        //         if (User::where('email', $request->email)->where('userType', '!=', 0)->count() == 0) {
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
                'msg' => 'User not found!!',
                'success' => false
            ], 401);
        }
    }

    function logout()
    {
        Auth::logout();
        // Session::flush();
        // Session::forget('url.intented');
        return redirect('/');
    }

    public function getProfileInfo($id)
    {
        return User::where('id', $id)->first();
    }

    public function deleteImage(Request $request)
    {
        $fileName = $request->image;
        $this->deleteFileFromServer($fileName, false);
        return 'done';
    }
    
    public function deleteFileFromServer($fileName, $hasFullPath = false)
    {
        if (!$hasFullPath) {
            $filePath = public_path() . '/profileImages/' . $fileName;
        }
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        return;
    }

    public function editProfile(Request $request, $id)
    {
        //validate request
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'department' => 'required'
        ]);
        $image = $request->image;
        if(is_null($image)){
            return User::where('id', $id)->update([
                'name' => $request->name,
                'image' => '/profileImages/download.jpg',
                'designation' => $request->designation,
                'department' => $request->department,
            ]);
        } else{
            return User::where('id', $id)->update([
                'name' => $request->name,
                'image' => $request->image,
                'designation' => $request->designation,
                'department' => $request->department,
            ]);
        }
    }

    public function about(Request $request, $id)
    {
        //validate request
        $this->validate($request, [
            'id' => 'required',
            'about' => 'required',
        ]);
        
        return User::where('id', $id)->update([
            'about' => $request->about,
        ]);
        
    }

    public function skills(Request $request, $id)
    {
        //validate request
        $this->validate($request, [
            'id' => 'required',
            'skills' => 'required',
        ]);
        
        return User::where('id', $id)->update([
            'skills' => $request->skills,
        ]);
        
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('profileImages'), $picName);
        return $picName;
    }


    //     public function index(Request $request)
    //     {
    //         //first check if you are loggedin and admin user ...
    //         if (!Auth::check() && $request->path() != 'login') {
    //             return redirect('/login');
    //         }
    //         // if (!Auth::check() && $request->path() == 'login') {
    //         //     return view('welcome');
    //         // }
    //         return view('home');
    //
    //         // // you are already logged in... so check for if you are an admin user..
    //         // $user = Auth::user();
    //         // if ($user->userType == 'User') {
    //         //     return redirect('/login');
    //         // }
    //         // if ($request->path() == 'login') {
    //         //     return redirect('/');
    //         // }
    //     }
    public function admin(Request $request)
    {
        //first check if you are loggedin and admin user ...
        // if(!Auth::check()){
        //     return redirect('/login');
        // }
        return view('admin');
    }


    // public function uploadImages(Request $request)
    // {
    //     request()->file('img')->store('uploads');
    //     $pic = $request->img->hashName();
    //     // $pic = "/uploads/$pic";
    //     $url = env('APP_URL');
    //     $pic = $url . "uploads/$pic";
    //     return response()->json([
    //         'image' => $pic
    //     ], 200);
    // }
}
