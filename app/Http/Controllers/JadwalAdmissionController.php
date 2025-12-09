<?php

namespace App\Http\Controllers;

use App\Models\JadwalAdmission;
use App\Models\AdmissionItem;
use Illuminate\Http\Request;

class JadwalAdmissionController extends Controller
{
    public function index()
    {
        return JadwalAdmission::with(['campus', 'items'])->orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:national,mandiri',
            'category' => 'nullable|in:snbp,snbt,mandiri',
            'campus_id' => 'nullable|exists:campuses,id',

            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.start_date' => 'nullable|date',
            'items.*.end_date' => 'nullable|date|after_or_equal:items.*.start_date',
            'items.*.batch' => 'nullable|integer|min:1',
            'items.*.status' => 'required|string',
            'items.*.description' => 'nullable|string',
        ]);

        if ($validated['type'] === 'national' && empty($validated['category'])) {
            return response()->json(['error' => 'category is required for national type'], 422);
        }

        if ($validated['type'] === 'mandiri' && empty($validated['campus_id'])) {
            return response()->json(['error' => 'campus_id is required for mandiri type'], 422);
        }
        $admission = JadwalAdmission::create([
            'type' => $validated['type'],
            'category' => $validated['type'] === 'mandiri' ? 'mandiri' : ($validated['category'] ?? null),
            'campus_id' => $validated['campus_id'] ?? null,
        ]);

        foreach ($validated['items'] as $item) {
            AdmissionItem::create([
                'admission_id' => $admission->id,
                ...$item
            ]);
        }

        return response()->json([
            'message' => 'Admission & items stored successfully',
            'parent' => $admission,
            // 'items' => $admission->items,
        ], 201);
    }

    public function show($id)
    {
        return JadwalAdmission::with(['campus', 'items'])->findOrFail($id);
    }

    public function destroy($id)
    {
        $jadwal = JadwalAdmission::findOrFail($id);
        $jadwal->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
