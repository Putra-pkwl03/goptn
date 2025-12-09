<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::with('campus')->get();
        return response()->json($majors);
    }

    public function store(Request $request)
    {
        $request->validate([
            'campus_id' => 'required|exists:campuses,id',
            'nama_jurusan' => 'required|string|max:255',
            'fakultas' => 'nullable|string|max:255',
            'akreditasi' => 'nullable|string|max:10',
            'kapasitas' => 'nullable|integer|min:0',
            'peminat' => 'nullable|integer|min:0',
            'diterima' => 'nullable|integer|min:0',
            'tingkat' => 'nullable|string|in:sarjana,diploma',
        ]);

        $major = Major::create($request->all());
        return response()->json($major, 201);
    }

    public function show($id)
    {
        $major = Major::with('campus')->find($id);

        if (!$major) return response()->json(['message' => 'Jurusan tidak ditemukan'], 404);

        return response()->json($major);
    }

    public function update(Request $request, $id)
    {
        $major = Major::find($id);

        if (!$major) return response()->json(['message' => 'Jurusan tidak ditemukan'], 404);

        $request->validate([
            'campus_id' => 'sometimes|exists:campuses,id',
            'nama_jurusan' => 'sometimes|string|max:255',
            'fakultas' => 'nullable|string|max:255',
            'akreditasi' => 'nullable|string|max:10',
            'kapasitas' => 'nullable|integer|min:0',
            'peminat' => 'nullable|integer|min:0',
            'diterima' => 'nullable|integer|min:0',
            'tingkat' => 'nullable|string|in:sarjana,diploma',
        ]);

        $major->update($request->all());

        return response()->json(['message' => 'Jurusan diperbarui']);
    }

    public function destroy($id)
    {
        $major = Major::find($id);

        if (!$major) return response()->json(['message' => 'Jurusan tidak ditemukan'], 404);

        $major->delete();
        return response()->json(['message' => 'Jurusan dihapus']);
    }
}
