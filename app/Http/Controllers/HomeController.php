<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function search(Request $request){
        $users = User::where('name', 'LIKE','%'.$request->keyword.'%')->get();
        return response()->json($users);
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
