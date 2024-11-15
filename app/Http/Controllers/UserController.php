<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => $user->only('id', 'name', 'email', 'password', 'profile_photo_path'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:6'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password !== null) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->banner('Informations mises à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function avatar(User $user, Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        dd($request->all());

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->profile_photo_path = $path;
        $user->save();

        return back()->banner('Avatar mis à jour avec succès.');
    }
}
