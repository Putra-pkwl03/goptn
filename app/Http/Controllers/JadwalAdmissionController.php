<?php

namespace App\Http\Controllers;

use App\Models\JadwalAdmission;
use Illuminate\Http\Request;

class JadwalAdmissionController extends Controller
{
    public function index()
    {
        return JadwalAdmission::with('campus')->orderBy('start_date')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:national,mandiri',
            'category' => 'nullable|in:snbp,snbt,mandiri',
            'campus_id' => 'nullable|exists:campuses,id',

            // bulk insert array
            'items' => 'required|array|min:1',

            // fields inside items
            'items.*.name' => 'required|string',
            'items.*.start_date' => 'nullable|date',
            'items.*.end_date' => 'nullable|date|after_or_equal:items.*.start_date',
            'items.*.batch' => 'nullable|integer|min:1',
            'items.*.status' => 'required|string',
            'items.*.description' => 'nullable|string',
        ]);

        // rule tambahan berdasarkan type
        if ($validated['type'] === 'national' && empty($validated['category'])) {
            return response()->json(['error' => 'category is required for national type'], 422);
        }

        if ($validated['type'] === 'mandiri' && empty($validated['campus_id'])) {
            return response()->json(['error' => 'campus_id is required for mandiri type'], 422);
        }

        $records = [];

        foreach ($validated['items'] as $item) {
            $records[] = JadwalAdmission::create([
                'type' => $validated['type'],
                'category' => $validated['category'],
                'campus_id' => $validated['campus_id'] ?? null,
                ...$item
            ]);
        }

        return response()->json([
            'message' => 'Bulk data created successfully',
            'total_inserted' => count($records),
            'data' => $records
        ], 201);
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
            'category' => 'nullable|in:snbp,snbt,mandiri',
            'campus_id' => 'nullable|exists:campuses,id',
            'name' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'batch' => 'nullable|integer|min:1',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if ($validated['type'] === 'national' && empty($validated['category'])) {
            return response()->json(['error' => 'category is required for national type'], 422);
        }

        if ($validated['type'] === 'mandiri' && empty($validated['campus_id'])) {
            return response()->json(['error' => 'campus_id is required for mandiri type'], 422);
        }

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
