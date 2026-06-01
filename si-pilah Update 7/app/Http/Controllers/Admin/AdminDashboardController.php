<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Waste;
use App\Models\Report;
use App\Models\Reward;
use App\Models\Schedule;
use App\Models\Announcement;
use App\Models\Education;
use App\Models\AboutSetting;
use App\Models\ContactMessage;
use App\Models\Review;
use App\Models\ReportFeedback;
use App\Services\RewardPointService;
use App\Services\FeedbackService;

class AdminDashboardController extends Controller
{
    // ==================== DASHBOARD ====================

    public function index()
    {
        $data = [
            'total_users'       => User::count(),
            'total_sampah'      => Waste::sum('weight') ?? 0,
            'total_energi'      => Waste::sum('result') ?? 0,
            'total_poin'        => Reward::sum('points') ?? 0,
            'total_laporan'     => Report::count(),
            'laporan_aktif'     => Report::whereNotIn('status', ['Selesai', 'Dibatalkan'])->count(),
            'total_jadwal'      => Schedule::count(),
            'total_pengumuman'  => Announcement::count(),
        ];

        $laporanTerbaru = Report::with('user')->latest()->take(5)->get();
        $wastesTerbaru  = Waste::latest()->take(5)->get();
        $announcements  = Announcement::with('user')->latest()->get();

        return view('admin.dashboard', compact('data', 'laporanTerbaru', 'wastesTerbaru', 'announcements'));
    }

    // ==================== USERS ====================

    public function users(Request $request)
    {
        $query = User::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();
        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'is_admin' => $request->has('is_admin'),
        ]);

        return back()->with('success', 'Data user berhasil diperbarui.');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa hapus akun sendiri.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    // ==================== WASTES ====================

    public function wastes(Request $request)
    {
        $query = Waste::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('tps', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
    $query->where('status', $request->status);
}

    $wastes = $query->paginate(15)->withQueryString();


    $organicCount = Waste::where('type', 'organic')->count();
    $organicWeight = Waste::where('type', 'organic')->sum('weight');

    $inorganicCount = Waste::where('type', 'inorganic')->count();
    $inorganicWeight = Waste::where('type', 'inorganic')->sum('weight');

    $completedCount = Waste::where('status', 'Selesai')->count();

    $totalWaste = Waste::count();

    $completionRate = $totalWaste > 0
        ? round(($completedCount / $totalWaste) * 100)
        : 0;

    return view('admin.wastes', compact(
        'wastes',
        'organicCount',
        'organicWeight',
        'inorganicCount',
        'inorganicWeight',
        'completedCount',
        'completionRate'
    ));
            $request->validate([
                'status' => 'required|in:Pending,Diproses,Selesai,Dibatalkan',
            ]);

            $waste->update([
                'status' => $request->status
            ]);

            // Reward otomatis saat selesai
            if ($request->status === 'Selesai') {

                $rewardService = new RewardPointService();

                $rewardService->awardPointsForCompletedWaste($waste);
            }

            return back()->with('success', 'Status sampah diperbarui.');
        }

    public function updateWasteStatus(Request $request, Waste $waste)
    {
        $request->validate([
            'status' => 'required|in:Pending,Diproses,Selesai,Dibatalkan',
        ]);

        $waste->update([
            'status' => $request->status
        ]);

        if ($request->status === 'Selesai') {

            Announcement::create([
                'user_id' => auth()->id(),
                'judul' => 'Pengolahan Sampah Selesai',
                'konten' => 'Sampah "' . $waste->name . '" berhasil diproses dan telah selesai dikelola.',
                'start_at' => now(),
                'end_at' => now()->addDays(30),
            ]);
        }

        return back()->with('success', 'Status sampah diperbarui.');
    }

    public function deleteWaste(Waste $waste)
    {
        $waste->delete();
        return back()->with('success', 'Data sampah dihapus.');
    }

    // ==================== REPORTS ====================

    public function reports(Request $request)
    {
        $query = Report::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->paginate(15)->withQueryString();
        return view('admin.reports', compact('reports'));
    }

    public function updateReportStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai,Dibatalkan',
        ]);

        $report->update(['status' => $request->status]);

        // Award points if status changed to "Selesai"
        if ($request->status === 'Selesai') {
            $rewardService = new RewardPointService();
            $rewardService->awardPointsForCompletedReport($report);
        }

        return back()->with('success', 'Status diperbarui.');
    }

    // ==================== REPORT FEEDBACKS ====================

    public function showReportFeedbackForm($report_id)
    {
        $report = Report::findOrFail($report_id);
        return view('admin.reports.feedback-form-page', compact('report'));
    }

    public function storeReportFeedback(Request $request, Report $report)
    {
        $request->validate([
            'description' => 'required|string',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $feedbackService = new FeedbackService();

        // Check if feedback already exists
        if ($report->feedback) {
            // Update existing feedback
            $feedbackService->updateFeedback($report->feedback, $request->only('description', 'photo'));
            $message = '✅ Feedback laporan berhasil diperbarui!';
        } else {
            // Create new feedback
            $feedbackService->createFeedback(
                $report,
                $request->only('description', 'photo'),
                Auth::id()
            );
            $message = '✅ Feedback laporan berhasil ditambahkan!';
        }

        return redirect()->route('admin.reports')->with('success', $message);
    }

    public function deleteReportFeedback(ReportFeedback $feedback)
    {
        $feedbackService = new FeedbackService();
        $feedbackService->deleteFeedback($feedback);

        return back()->with('success', '✅ Feedback laporan berhasil dihapus!');
    }

    // ==================== REWARDS ====================

    public function rewards()
    {
        $rewards = Reward::with('user')->latest()->paginate(15);
        $users   = User::orderBy('name')->get();

        return view('admin.rewards', compact('rewards', 'users'));
    }

    public function storeReward(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'points'  => 'required|integer|min:1',
        ]);

        Reward::create([
        'user_id'     => $request->user_id,
        'points'      => $request->points,
        'type'        => 'manual',
        'description' => 'Reward dari admin',
        ]);

        User::find($request->user_id)->increment('points', $request->points);

        // Reward::create($request->only('user_id', 'points'));

        return back()->with('success', 'Reward ditambahkan.');
    }

    public function deleteReward(Reward $reward)
    {
        $reward->delete();
        return back()->with('success', 'Reward dihapus.');
    }

    // ==================== SCHEDULE ====================

    public function schedules()
    {
        $schedules = Schedule::latest()->paginate(15);
        return view('admin.schedules', compact('schedules'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'waktu_jemput' => 'required|date',
            'kategori'     => 'required|string|max:255',
            'nama_petugas' => 'required|string|max:255',
            'kelurahan'    => 'required|string|max:255',
        ]);

        Schedule::create($request->only('waktu_jemput', 'kategori', 'nama_petugas', 'kelurahan'));

        return back()->with('success', 'Jadwal ditambahkan.');
    }

    public function updateSchedule(Request $request, Schedule $schedule)
    {
        $request->validate([
            'waktu_jemput' => 'required|date',
            'kategori'     => 'required|string|max:255',
            'nama_petugas' => 'required|string|max:255',
            'kelurahan'    => 'required|string|max:255',
        ]);

        $schedule->update($request->only('waktu_jemput', 'kategori', 'nama_petugas', 'kelurahan'));

        return back()->with('success', 'Jadwal diupdate.');
    }

    public function deleteSchedule(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal dihapus.');
    }

    // ==================== ANNOUNCEMENT ====================

    public function announcements()
    {
        $announcements = Announcement::latest()->paginate(15);
        return view('admin.announcements', compact('announcements'));
    }

    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'judul'    => 'nullable|string|max:255',
            'konten'   => 'required|string',
            'start_at' => 'nullable|date',
            'end_at'   => 'nullable|date|after_or_equal:start_at',
        ]);

        Announcement::create([
            'judul'    => $request->judul ?: 'Pengumuman',
            'konten'   => $request->konten,
            'start_at' => $request->start_at,
            'end_at'   => $request->end_at,
        ]);

        return back()->with('success', 'Pengumuman ditambahkan.');
    }

    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        $request->validate([
            'judul'    => 'nullable|string|max:255',
            'konten'   => 'required|string',
            'start_at' => 'nullable|date',
            'end_at'   => 'nullable|date|after_or_equal:start_at',
        ]);

        $announcement->update([
            'judul'    => $request->judul ?: 'Pengumuman',
            'konten'   => $request->konten,
            'start_at' => $request->start_at,
            'end_at'   => $request->end_at,
        ]);

        return back()->with('success', 'Pengumuman diupdate.');
    }

    public function deleteAnnouncement(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Pengumuman dihapus.');
    }

    // ==================== EDUCATION ====================

    public function educations()
    {
        $educations = Education::latest()->paginate(15);
        return view('admin.educations', compact('educations'));
    }

    public function storeEducation(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'cover'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $coverName = null;

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time().'_cover_'.$cover->getClientOriginalName();
            $cover->move(public_path('cover'), $coverName);
        }

        $education = Education::create([
            'title'   => $request->title,
            'content' => $request->content,
            'cover'   => $coverName,
        ]);

        // Buat notifikasi otomatis kategori "Kegiatan"
        Announcement::create([
            'user_id'  => auth()->id(),
            'judul'    => 'Kegiatan Edukasi Baru: ' . $education->title,
            'konten'   => 'Terdapat materi edukasi baru: "' . $education->title . '". Yuk baca sekarang!',
            'start_at' => now(),
            'end_at'   => now()->addYears(2),
        ]);

        return back()->with('success', 'Artikel ditambahkan.');
    }

    public function deleteEducation(Education $education)
    {
        if ($education->cover && file_exists(public_path('cover/'.$education->cover))) {
            unlink(public_path('cover/'.$education->cover));
        }

        $education->delete();

        return back()->with('success', 'Artikel dihapus.');
    }

    public function edit(Education $education)
    {
        return view('admin.educations_edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'cover'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            if ($education->cover && file_exists(public_path('cover/'.$education->cover))) {
                unlink(public_path('cover/'.$education->cover));
            }

            $cover = $request->file('cover');
            $coverName = time().'_cover_'.$cover->getClientOriginalName();
            $cover->move(public_path('cover'), $coverName);

            $education->cover = $coverName;
        }

        $education->title   = $request->title;
        $education->content = $request->content;
        $education->save();

        return redirect()->route('admin.educations')
            ->with('success', 'Artikel diupdate.');
    }

    // ==================== CONTACT PAGE ====================

    public function contactPage()
    {
        $settings = AboutSetting::where('section', 'like', 'contact_%')
            ->get()
            ->groupBy('section')
            ->map(function ($items) {
                return $items->pluck('value', 'key')->toArray();
            });

        return view('admin.contact', [
            'hero'   => $settings->get('contact_hero', []),
            'info'   => $settings->get('contact_info', []),
            'sosmed' => $settings->get('contact_sosmed', []),
        ]);
    }

    public function updateContact(Request $request)
    {
        $section = $request->input('section');

        // Process text fields
        $fields = collect($request->all())->filter(function ($value, $key) use ($section) {
            return str_starts_with($key, $section . '_') && !is_null($value) && $key !== '_token' && $key !== 'section';
        });

        foreach ($fields as $inputKey => $value) {
            $key = str_replace($section . '_', '', $inputKey);

            AboutSetting::updateOrCreate(
                ['section' => $section, 'key' => $key],
                ['value' => $value]
            );
        }

        $sectionLabel = str_replace('contact_', '', $section);
        return back()->with('success', 'Konten Contact section "' . ucfirst($sectionLabel) . '" berhasil diperbarui.');
    }

    // ==================== CONTACT MESSAGES ====================

    public function contactMessages(Request $request)
    {
        $query = ContactMessage::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $messages = $query->paginate(15)->withQueryString();
        $unreadCount = ContactMessage::unread()->count();

        return view('admin.contact-messages', compact('messages', 'unreadCount'));
    }

    public function replyContactMessage(Request $request, ContactMessage $contactMessage)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:5000',
        ]);

        $contactMessage->update([
            'admin_reply' => $request->admin_reply,
            'status'      => 'Dibalas',
            'replied_at'  => now(),
        ]);

        // Create a notification (Announcement-style) for the user if they have an account
        if ($contactMessage->user_id) {
            Announcement::create([
                'user_id' => $contactMessage->user_id,
                'konten'  => '📩 Balasan untuk pesan "' . $contactMessage->subject . '": ' . $request->admin_reply,
            ]);
        }

        return back()->with('success', 'Balasan berhasil dikirim ke ' . $contactMessage->name . '.');
    }

    public function markAsRead(ContactMessage $contactMessage)
    {
        if ($contactMessage->status === 'Baru') {
            $contactMessage->update(['status' => 'Dibaca']);
        }
        return back()->with('success', 'Pesan ditandai sebagai dibaca.');
    }

    public function deleteContactMessage(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }

    // ==================== REVIEWS ====================

    public function reviews(Request $request)
    {
        $reviews = Review::with('user', 'waste')->latest()->paginate(15);
        return view('admin.reviews', compact('reviews'));
    }

    public function toggleReviewVisibility(Review $review)
    {
        $review->update(['is_visible' => !$review->is_visible]);
        $status = $review->is_visible ? 'ditampilkan' : 'disembunyikan';
        return back()->with('success', "Feedback berhasil {$status} di Halaman Utama.");
    }
}
