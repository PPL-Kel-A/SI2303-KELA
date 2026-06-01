<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Announcement; 
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index(Request $request)
    {
        $query = Education::latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $educations = $query->paginate(9)->withQueryString();

        return view('education.index', compact('educations'));
    }

    public function show(Education $education)
    {
        return view('education.show', compact('education'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'konten' => 'required',
        ]);

        // 2. Simpan Edukasi
        $education = Education::create($validated);

        // 3. Buat Notifikasi Otomatis (LENGKAP DENGAN USER & TANGGAL TAYANG)
        Announcement::create([
            'user_id'   => auth()->id() ?? 1, // Otomatis ambil ID admin yang login, jika tidak ada default ke 1
            'judul'     => 'Edukasi Baru: ' . $education->title,
            'konten'    => 'Terdapat materi edukasi baru: ' . $education->title . '. Yuk baca sekarang!',
            'kategori'  => 'kegiatan',        // Masuk ke kategori kegiatan
            'start_at'  => now(),             // Mulai tayang detik ini juga
            'end_at'    => now()->addYears(2),// Set 2 tahun ke depan agar tidak hilang/berstatus 'Selesai'
        ]);

        return redirect()->route('education.index')->with('success', 'Edukasi berhasil ditambahkan & notifikasi terkirim!');
    }

    public function update(Request $request, Education $education)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'konten' => 'required',
        ]);

        // 2. Update Edukasi
        $education->update($validated);

        // 3. Buat Notifikasi Otomatis (LENGKAP DENGAN USER & TANGGAL TAYANG)
        Announcement::create([
            'user_id'   => auth()->id() ?? 1,
            'judul'     => 'Update Edukasi: ' . $education->title,
            'konten'    => 'Materi edukasi "' . $education->title . '" telah diperbarui. Cek informasinya!',
            'kategori'  => 'kegiatan',
            'start_at'  => now(),
            'end_at'    => now()->addYears(2),
        ]);

        return redirect()->route('education.index')->with('success', 'Edukasi berhasil diperbarui & notifikasi terkirim!');
    }
}