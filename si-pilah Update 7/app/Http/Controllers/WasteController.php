<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waste;
use App\Models\Reward;
use Illuminate\Support\Facades\Storage;

class WasteController extends Controller
{
    // ... (fungsi create, preview, store, showSuccess tetap SAMA) ...

    public function create(Request $request) { return view('waste.form', ['type' => $request->type]); }

    public function preview(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:organic,inorganic',
            'category' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0.1',
            'tps' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'image' => 'required|image|max:2048'
        ]);

        $result = ($validated['type'] === 'organic') ? $validated['weight'] * 0.5 : $validated['weight'] * 0.8;
        $path = $request->file('image')->store('tmp', 'public');

        return view('waste.preview', ['data' => $validated, 'result' => $result, 'image' => $path]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:organic,inorganic',
            'category' => 'required|string',
            'weight' => 'required|numeric',
            'tps' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kota' => 'required|string',
            'image' => 'required|string',
        ]);

        $result = ($validated['type'] === 'organic') ? $validated['weight'] * 0.5 : $validated['weight'] * 0.8;
        $tmpPath = $validated['image'];
        $newPath = str_replace('tmp/', 'wastes/', $tmpPath);

        if (Storage::disk('public')->exists($tmpPath)) {
            Storage::disk('public')->move($tmpPath, $newPath);
        }

        $waste = Waste::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'weight' => $validated['weight'],
            'tps' => "{$validated['tps']} | {$validated['desa']}, {$validated['kecamatan']}, {$validated['kota']}",
            'image' => $newPath,
            'result' => $result,
            'status' => 'Pending',
        ]);

        return redirect()->route('waste.showSuccess', ['id' => $waste->id]);
    }

    public function showSuccess($id)
    {
        $submission = Waste::findOrFail($id);
        
        if (strpos($submission->tps, ' | ') !== false) {
            $parts = explode(' | ', $submission->tps);
            $submission->tps = $parts[0];
            $geo = explode(', ', $parts[1]);
            $submission->desa = $geo[0] ?? '-';
            $submission->kecamatan = $geo[1] ?? '-';
            $submission->kota = $geo[2] ?? '-';
        }

        return view('waste.success', compact('submission'));
    }

    // 5. Klaim Poin (DIUPDATE: Redirect ke halaman Success)
    public function claimPoint($id)
    {
        $submission = Waste::findOrFail($id);

        if (strtolower($submission->status) !== 'selesai') {
            return redirect()->back()->with('error', 'Status pengajuan belum selesai.');
        }

        $sudahKlaim = Reward::where('user_id', auth()->id())
                            ->where('description', 'like', '%[ID: ' . $id . ']%')
                            ->exists();

        if ($sudahKlaim) {
            return redirect()->back()->with('error', 'Poin untuk pengajuan ini sudah diklaim.');
        }

        $poinDihasilkan = $submission->result * 10;
        
        $user = auth()->user();
        $user->points = ($user->points ?? 0) + $poinDihasilkan;
        $user->save();

        Reward::create([
            'user_id' => $user->id,
            'type' => 'setor',
            'points' => $poinDihasilkan,
            'description' => "Klaim poin hasil konversi " . number_format($submission->result, 2) . " L [ID: {$id}]",
        ]);

        // PERUBAHAN DI SINI: Mengarahkan ke halaman success bukan ke dashboard
        return redirect()->route('waste.showSuccess', ['id' => $id])
                         ->with('success', 'Berhasil! Anda mendapatkan ' . $poinDihasilkan . ' Poin.');
    }
}