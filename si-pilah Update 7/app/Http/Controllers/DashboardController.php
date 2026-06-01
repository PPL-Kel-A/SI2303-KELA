<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Import Model yang dibutuhkan berdasarkan PBI
use App\Models\Waste;
use App\Models\Reward;
use App\Models\Report;
use App\Models\Schedule;
use App\Models\Announcement;
use App\Models\Education;

class DashboardController extends Controller
{
    public function index()
    {
        
        $userId = Auth::id();
        $user = Auth::user();
        $kelurahanUser = $user->kelurahan;

        $tpsData = [
            'TPS Kebon Jeruk' => [
                'lat' => -6.1886, 'lng' => 106.7716,
                'address' => 'Jl. Kebon Jeruk Raya, Jakarta Barat',
                'desa' => 'Kelurahan Kebon Jeruk'
            ],
            'TPS Palmerah' => [
                'lat' => -6.2066, 'lng' => 106.7972,
                'address' => 'Jl. Palmerah Utara, Jakarta Barat',
                'desa' => 'Kelurahan Palmerah'
            ],
            'TPS Grogol' => [
                'lat' => -6.1615, 'lng' => 106.7860,
                'address' => 'Jl. Daan Mogot, Grogol, Jakarta Barat',
                'desa' => 'Kelurahan Grogol'
            ],
            'TPS Cengkareng' => [
                'lat' => -6.1457, 'lng' => 106.7295,
                'address' => 'Jl. Daan Mogot KM.14, Cengkareng, Jakarta Barat',
                'desa' => 'Kelurahan Cengkareng Timur'
            ],
            'TPS Kembangan' => [
                'lat' => -6.1870, 'lng' => 106.7490,
                'address' => 'Jl. Kembangan Raya, Kembangan, Jakarta Barat',
                'desa' => 'Kelurahan Kembangan Utara'
            ],
            'TPS Slipi' => [
                'lat' => -6.1920, 'lng' => 106.7985,
                'address' => 'Jl. S. Parman, Slipi, Jakarta Barat',
                'desa' => 'Kelurahan Slipi'
            ],
            'TPS Taman Sari' => [
                'lat' => -6.1490, 'lng' => 106.8125,
                'address' => 'Jl. Taman Sari Raya, Jakarta Barat',
                'desa' => 'Kelurahan Taman Sari'
            ],
            'TPS Kebayoran Baru' => [
                'lat' => -6.2443, 'lng' => 106.7973,
                'address' => 'Jl. Selong, Kebayoran Baru, Jakarta Selatan',
                'desa' => 'Kelurahan Selong'
            ],
            'TPS Cilandak' => [
                'lat' => -6.2901, 'lng' => 106.7972,
                'address' => 'Jl. Cilandak Raya, Jakarta Selatan',
                'desa' => 'Kelurahan Cilandak Barat'
            ],
            'TPS Menteng' => [
                'lat' => -6.2014, 'lng' => 106.8322,
                'address' => 'Jl. Menteng Raya, Jakarta Pusat',
                'desa' => 'Kelurahan Menteng'
            ],
            'TPS Tanah Abang' => [
                'lat' => -6.2120, 'lng' => 106.8180,
                'address' => 'Jl. KH. Mas Mansyur, Tanah Abang, Jakarta Pusat',
                'desa' => 'Kelurahan Karet Tengsin'
            ],
            'TPS Jatinegara' => [
                'lat' => -6.2250, 'lng' => 106.8790,
                'address' => 'Jl. Jatinegara Timur, Jakarta Timur',
                'desa' => 'Kelurahan Bali Mester'
            ],
            'TPS Duren Sawit' => [
                'lat' => -6.2230, 'lng' => 106.9010,
                'address' => 'Jl. Duren Sawit Raya, Jakarta Timur',
                'desa' => 'Kelurahan Duren Sawit'
            ],
            'TPS Penjaringan' => [
                'lat' => -6.1274, 'lng' => 106.7915,
                'address' => 'Jl. Pluit Raya, Penjaringan, Jakarta Utara',
                'desa' => 'Kelurahan Penjaringan'
            ],
            'TPS Kelapa Gading' => [
                'lat' => -6.1550, 'lng' => 106.9020,
                'address' => 'Jl. Boulevard Raya, Kelapa Gading, Jakarta Utara',
                'desa' => 'Kelurahan Kelapa Gading Timur'
            ]
        ];

        $tpsTerdekatUser = null;
        if ($user->tps_terdekat && isset($tpsData[$user->tps_terdekat])) {
            $tpsTerdekatUser = array_merge(
                ['nama' => $user->tps_terdekat],
                $tpsData[$user->tps_terdekat]
            );
        }

        
        $laporanTerbaru = Report::where('user_id', $userId)->latest()->first();
        $jumlahLaporanAktif = Report::where('user_id', $userId)
                                    ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                                    ->count();

        // Jadwal terdekat — filter berdasarkan kelurahan user
        $jadwalTerdekatQuery = Schedule::where('waktu_jemput', '>=', now())
                                       ->orderBy('waktu_jemput', 'asc');

        if ($kelurahanUser) {
            $jadwalTerdekatQuery->whereRaw('LOWER(kelurahan) = ?', [strtolower($kelurahanUser)]);
        } else {
            $jadwalTerdekatQuery->whereRaw('1 = 0'); // Tidak ada kelurahan, tidak ada jadwal
        }

        $jadwalTerdekat = $jadwalTerdekatQuery->first();

        
        $pengumumanTerbaru = Announcement::where(function($q) use ($userId) {
                                            $q->whereNull('user_id')
                                              ->orWhere('user_id', $userId);
                                         })
                                         ->where(function($q) {
                                            $q->whereNull('start_at')
                                              ->orWhere('start_at', '<=', now());
                                         })
                                         ->where(function($q) {
                                            $q->whereNull('end_at')
                                              ->orWhere('end_at', '>=', now());
                                         })
                                         ->latest()
                                         ->first();

        $data = [
            // Data per-user (filter by user_id)
            'total_sampah'     => Waste::where('user_id', $userId)->sum('weight') ?? 0, 
            'poin_reward'      => Auth::user()->points ?? 0,
            'energi_surya_kwh' => Waste::where('user_id', $userId)->sum('result') ?? 0,
            
            
            'laporan_aktif'  => $jumlahLaporanAktif,
            'status_laporan' => $laporanTerbaru ? $laporanTerbaru->status : 'Tidak ada laporan', 

            
            'jadwal_terdekat' => [
                'hari'    => $jadwalTerdekat ? \Carbon\Carbon::parse($jadwalTerdekat->waktu_jemput)->translatedFormat('l, d F Y - H:i') : 'Belum ada jadwal',
                'jenis'   => $jadwalTerdekat ? $jadwalTerdekat->kategori : '-',
                'petugas' => $jadwalTerdekat ? $jadwalTerdekat->nama_petugas : '-'
            ],

            
            'pengumuman' => $pengumumanTerbaru ? $pengumumanTerbaru->konten : 'Belum ada pengumuman terbaru.'
        ];

        // Riwayat setoran sampah user (5 terbaru)
        $riwayatSampah = Waste::where('user_id', $userId)->latest()->take(5)->get();

        // Jadwal penjemputan mendatang — filter berdasarkan kelurahan user
        $jadwalMendatangQuery = Schedule::where('waktu_jemput', '>=', now())
                                        ->orderBy('waktu_jemput', 'asc');

        if ($kelurahanUser) {
            $jadwalMendatangQuery->whereRaw('LOWER(kelurahan) = ?', [strtolower($kelurahanUser)]);
        } else {
            $jadwalMendatangQuery->whereRaw('1 = 0');
        }

        $jadwalMendatang = $jadwalMendatangQuery->take(10)->get();

        return view('user.dashboard', compact('data', 'riwayatSampah', 'jadwalMendatang', 'kelurahanUser', 'tpsTerdekatUser', 'pengumumanTerbaru')); 
    }

    public function announcements()
    {
        $userId = Auth::id();

        // Tandai semua notifikasi user yang belum dibaca sebagai sudah dibaca
        Announcement::where(function($q) use ($userId) {
                        $q->whereNull('user_id')
                          ->orWhere('user_id', $userId);
                    })
                    ->whereNull('read_at')
                    ->update(['read_at' => now()]);

        $announcements = Announcement::where(function($q) use ($userId) {
                                         $q->whereNull('user_id')
                                           ->orWhere('user_id', $userId);
                                     })
                                     ->where(function($q) {
                                         $q->whereNull('start_at')
                                           ->orWhere('start_at', '<=', now());
                                     })
                                     ->where(function($q) {
                                         $q->whereNull('end_at')
                                           ->orWhere('end_at', '>=', now());
                                     })
                                     ->latest()
                                     ->paginate(10);
        return view('user.announcements', compact('announcements'));
    }
}