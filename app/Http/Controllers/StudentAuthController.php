<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\StudentPTNChoice;
use App\Models\StudentEntryPath;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'no_telp' => 'required|unique:users|digits_between:10,15',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password),
            'role' => 'student'
        ]);


        return response()->json([
            'message' => 'Registrasi berhasil, silakan login.'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', 'student')
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $token = $user->createToken('student_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => [
                'name'    => $user->name,
                'email'   => $user->email,
                'role'    => $user->role
            ],
            'token' => $token,
            'type' => 'Bearer'
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user(); 

        return response()->json([
            'user' => $user,
            'profile' => StudentProfile::where('user_id', $user->id)->first(),
            'ptn_choices' => StudentPTNChoice::where('user_id', $user->id)->get(),
            'entry_paths' => StudentEntryPath::where('user_id', $user->id)->pluck('path')
        ]);
    }


        public function update(Request $request)
    {
        $user = $request->user(); 

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_telp' => 'required|digits_between:10,15|unique:users,no_telp,' . $user->id,
            'password' => 'nullable|min:6'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_telp = $request->no_telp;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'Data berhasil diperbarui.',
            'user' => $user
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }
}
