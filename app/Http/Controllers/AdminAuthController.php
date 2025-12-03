<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\StudentPTNChoice;
use App\Models\StudentEntryPath;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->where('role', 'admin')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $token = $user->createToken('admin_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => [
                'name' => $user->name,
                'role' => $user->role,
            ],
            'token' => $token,
            'type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }

    /** -------------------------
     * Student Management
     * ------------------------*/

    public function listStudents()
    {
        $students = User::where('role', 'student')->get();

        return response()->json([
            'count' => $students->count(),
            'students' => $students
        ]);
    }

    public function showStudent($id)
    {
        $student = User::where('role', 'student')->find($id);

        if (!$student) {
            return response()->json(['message' => 'Student tidak ditemukan'], 404);
        }

        return response()->json([
            'user' => $student,
            'profile' => StudentProfile::where('user_id', $id)->first(),
            'ptn_choices' => StudentPTNChoice::where('user_id', $id)->get(),
            'entry_paths' => StudentEntryPath::where('user_id', $id)->pluck('path')
        ]);
    }

    public function deleteStudent($id)
    {
        $student = User::where('role', 'student')->find($id);

        if (!$student) {
            return response()->json(['message' => 'Student tidak ditemukan'], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Akun student berhasil dihapus'
        ]);
    }
}
