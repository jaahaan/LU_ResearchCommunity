<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
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

}
