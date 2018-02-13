<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProfile;
use App\Http\Requests\StoreProfileImage;
use App\User;
use App\Post;
use Storage;
use Image;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $posts = $user->getPosts(0, 5);

        return view('profile.show', compact('posts'), compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProfile $request, User $user)
    {
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->birthday = $request->input('birthday');
        $user->sex = $request->input('sex');
        $user->bio = $request->input('bio');

        $user->save();

        return json_encode($user);
    }

    public function updateImage(StoreProfileImage $request, User $user)
    {
        // Verify if a file is present and upload it in case
        $path = $user->image_url;

        if ($request->hasFile('user-image')) {
            if($request->file('user-image')->isValid()) {
                Storage::delete($path);

                $resize = Image::make($request->file('user-image'))->fit(800)->encode('jpg');
                $hash = md5($resize->__toString());

                $path = 'profile-images/'.$hash.'.jpg';

                Storage::put($path, $resize->__toString());

                $user->image_url = $path;
                $user->save();

                $request->session()->flash('message', 'Immagine del profilo aggiornata.');
                $request->session()->flash('type', 'success');
            }
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}