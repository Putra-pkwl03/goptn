<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    public function index()
    {
        $campuses = Campus::with('majors')->get();
        $campuses->map(function ($campus) {
            $campus->total_program_studi = $campus->majors->count();
            return $campus;
        });

        return response()->json($campuses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kampus' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'website' => 'nullable|string',
            'akreditasi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'jalur_masuk' => 'nullable|array', 
        ]);
        $data = $request->all();
        if (isset($data['jalur_masuk'])) {
            $data['jalur_masuk'] = json_encode($data['jalur_masuk']);
        }

        $campus = Campus::create($data);
        return response()->json($campus, 201);
    }

    public function show($id)
    {
        $campus = Campus::with('majors')->find($id);

        if (!$campus) return response()->json(['message' => 'Kampus tidak ditemukan'], 404);

        $campus->total_program_studi = $campus->majors->count();

        return response()->json($campus);
    }

    public function update(Request $request, $id)
    {
        $campus = Campus::find($id);
        if (!$campus) return response()->json(['message' => 'Kampus tidak ditemukan'], 404);

        $data = $request->all();
        if (isset($data['jalur_masuk'])) {
            $data['jalur_masuk'] = json_encode($data['jalur_masuk']);
        }

        $campus->update($data);

        return response()->json(['message' => 'Data kampus diperbarui']);
    }

    public function destroy($id)
    {
        $campus = Campus::find($id);
        if (!$campus) return response()->json(['message' => 'Kampus tidak ditemukan'], 404);

        $campus->delete();
        return response()->json(['message' => 'Kampus dihapus']);
    }
}
