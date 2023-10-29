<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserColletion;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());
        // return response()->json(User::all());
        // return new UserColletion(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::create($request->all());

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::findOrFail($id);
        // return new UserResource($user);
        return response([
            "data" => $user,
            "status" => 200
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id
        ]);

        $user->update($request->all());

        return [
            "status" => 1,
            "data" => $user,
            "msg" => "User updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json($user);
    }

    // public function getUser(string $id)
    public function getUser()
    {
        // return auth()->user();
        // $user = User::findOrFail($id);
        return new UserResource(auth()->user());
        // return response([
        //     "data" => $user,
        //     "status" => 200
        // ]);
    }

    public function addavatar(Request $request, User $user)
    {
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName); // Speichere das Bild im öffentlichen Ordner

            $user = auth()->user();
            $user->update(['imageurl' => 'http://localhost:8000/images/' . $imageName]);

            return response()->json([
                'message' => 'Bild erfolgreich hochgeladen',
                'user' => new UserResource($user),
                ], 201);
        }else
        {
            return response()->json(['message' => 'Fehler beim Hochladen des Bildes'], 400);
        }
    }
}
