<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::with(['rombel', 'rayon'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'nis'       => 'required|unique:users,nis',
            'rombel_id' => 'required|exists:rombels,id_rombel',
            'rayon_id'  => 'required|exists:rayons,id_rayon',
            'password'  => 'required',
            'email'     => 'nullable|email'
        ]);

        $user = User::create([
            'name'      => $request->name,
            'nis'       => $request->nis,
            'rombel_id' => $request->rombel_id,
            'rayon_id'  => $request->rayon_id,
            'password'  => bcrypt($request->password),
            'email'     => $request->email,
        ]);

        return response()->json($user);
    }

    public function show($id)
    {
        return User::with(['rombel', 'rayon'])->findOrFail($id);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'deleted']);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'Old password is incorrect'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Password updated successfully'
        ], 200);
    }


    public function login(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('nis', $request->nis)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'NIS tidak ditemukan'
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'user' => $user
        ]);
    }
}
