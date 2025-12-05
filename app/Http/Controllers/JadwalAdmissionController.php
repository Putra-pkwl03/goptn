<?php

namespace App\Http\Controllers;

use App\Models\JadwalAdmission;
use Illuminate\Http\Request;

class JadwalAdmissionController extends Controller
{
    public function index()
    {
        return JadwalAdmission::with('campus')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:national,mandiri',
            'campus_id' => 'nullable|exists:campuses,id',
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $jadwal = JadwalAdmission::create($validated);

        return response()->json($jadwal, 201);
    }

    public function show($id)
    {
        return JadwalAdmission::with('campus')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalAdmission::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:national,mandiri',
            'campus_id' => 'nullable|exists:campuses,id',
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $jadwal->update($validated);

        return response()->json($jadwal);
    }

    public function destroy($id)
    {
        $jadwal = JadwalAdmission::findOrFail($id);
        $jadwal->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
