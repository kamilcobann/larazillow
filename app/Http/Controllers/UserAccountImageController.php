<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAccountImage;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserAccountImageController extends Controller
{
    
    public function create(User $user)
    {
        return inertia(
            'UserAccount/AccountImage/Create'
        );
    }

    public function store(Request $request)
    {
        $request->user()->load(['avatar']);

        if($request->user()->avatar)
        {
            return redirect()->back()->with('success','You already have a profile picture. Try to update it.');
        }

        if($request->hasFile('image'))
        {
            $request->validate([
                'image.*' => 'mimes:jpg,png,jpeg,webp|max:5000'
            ],[
                'image.*.mimes' => 'The file should be in one of the formats: jpg, png, webp, jpeg'
            ]);

            $file =  $request->file('image');
            $path =$file[0]->store('account_images','public');
            $request->user()->avatar()->save(
                new UserAccountImage([
                    'filename' => $path
                ])
                );
        }

        return redirect()->back()->with('success','Profile picture uploaded');
    }

    public function edit()
    {
        return intertia(
            'UserAccount/AccountImage/Edit'
        );
    }

    public function update(Request $request,UserAccountImage $image)
    {
        if($request->hasFile('image'))
        {
            $request->validate([
                'image.*' => 'mimes:jpg,png,jpeg,webp|max:5000'
            ],[
                'image.*.mimes' => 'The file should be in one of the formats: jpg, png, webp, jpeg'
            ]);

            Storage::disk('public')->delete($request->user()->avatar()->filename);
            $request->user()->avatar()->delete();
            $path = $request->file('image')->store('account_images','public');
            $request->user()->avatar()->save(
                new UserAccountImage([
                    'filename' => $path
                ])
                );
        }
        return redirect()->back()->with('success','Profile picture updated');
    }

    public function destroy(Request $request)
    {
        $image = $request->user()->avatar();
        Storage::disk('public')->delete($image->filename);
        $image->delete();

        return redirect()->back()->with('success','Profile picture deleted');
    }
}
