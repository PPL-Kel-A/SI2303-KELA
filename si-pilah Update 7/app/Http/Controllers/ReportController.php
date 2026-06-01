<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::where('user_id', auth()->id())
                        ->latest()
                        ->get();

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(StoreReportRequest $request)
    {
        // Store the image file
        $fotoPath = $request->file('foto_laporan')->store('reports', 'public');

        Report::create([
            'user_id'       => auth()->id(),
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'detail_alamat' => $request->detail_alamat,
            'foto_laporan'  => $fotoPath,
            'status'        => 'Menunggu',
        ]);

        return redirect()->route('reports.index')->with('success', '✅ Laporan berhasil dibuat! Tim kami akan segera memprosesnya.');
    }

    public function edit($id)
    {
        $report = Report::where('id', $id)
                       ->where('user_id', auth()->id())
                       ->firstOrFail();

        return view('reports.edit', compact('report'));
    }

    public function update(UpdateReportRequest $request, $id)
    {
        $report = Report::where('id', $id)
                       ->where('user_id', auth()->id())
                       ->firstOrFail();

        // If new photo is uploaded, delete the old one and store the new one
        if ($request->hasFile('foto_laporan')) {
            // Delete old photo from storage
            if ($report->foto_laporan && Storage::disk('public')->exists($report->foto_laporan)) {
                Storage::disk('public')->delete($report->foto_laporan);
            }

            // Store new photo
            $fotoPath = $request->file('foto_laporan')->store('reports', 'public');
            $report->foto_laporan = $fotoPath;
        }

        $report->update([
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'detail_alamat' => $request->detail_alamat,
            'foto_laporan'  => $report->foto_laporan,
        ]);

        return redirect()->route('reports.index')->with('success', '✅ Laporan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $report = Report::where('id', $id)
                       ->where('user_id', auth()->id())
                       ->firstOrFail();

        // Delete photo from storage
        if ($report->foto_laporan && Storage::disk('public')->exists($report->foto_laporan)) {
            Storage::disk('public')->delete($report->foto_laporan);
        }

        $report->delete();

        return redirect()->route('reports.index')->with('success', '✅ Laporan berhasil dihapus!');
    }
}