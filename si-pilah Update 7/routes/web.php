<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WasteController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\RedeemController;

// ==================== HOME ====================
Route::get('/', function () {
    try {
        $beritaTerkini = \App\Models\Announcement::whereNull('user_id')
            ->where(function($q) {
                $q->whereNull('start_at')
                  ->orWhere('start_at', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('end_at')
                  ->orWhere('end_at', '>=', now());
            })
            ->latest()
            ->take(3)
            ->get();
    } catch (\Exception $e) {
        $beritaTerkini = [];
    }

    try {
        $reviews = \App\Models\Review::with('user')->where('is_visible', true)->latest()->get();
    } catch (\Exception $e) {
        $reviews = [];
    }

    return view('welcome', compact('beritaTerkini', 'reviews'));
});

// ==================== DASHBOARD ====================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ==================== USER ====================
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');

    // Waste
    Route::get('/waste/select', fn () => view('waste.select'))->name('waste.select');
    Route::get('/waste/form', [WasteController::class, 'create']);
    Route::post('/waste/preview', [WasteController::class, 'preview']);
    Route::post('/waste/store', [WasteController::class, 'store']);

    // Halaman sukses setelah submit (menggunakan ID agar data bisa dipanggil kembali)
    Route::get('/waste/success/{id}', [WasteController::class, 'showSuccess'])->name('waste.showSuccess');
    
    // Route Klaim Poin (WAJIB POST agar aman dan tidak bentrok dengan GET)
    Route::post('/waste/claim-point/{id}', [WasteController::class, 'claimPoint'])->name('waste.claim');
    
    // Guidelines
    Route::get('/waste/guidelines', fn () => view('waste.guidelines'))->name('waste.guidelines');
    Route::get('/process-flow', fn () => view('waste.process-flow'))->name('process.flow');
    Route::get('/waste/process', fn () => view('waste.process'))->name('waste.process');
    Route::get('/panduan-setor', fn () => view('waste.panduan-setor'))->name('panduan.setor');
    Route::get('/rules', fn () => view('waste.rules'))->name('rules');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');

    // Announcements (user-facing)
    Route::get('/announcements', [DashboardController::class, 'announcements'])->name('announcements.index');

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // REWARD

    Route::get('/rewards', [RewardController::class, 'index'])
        ->name('rewards.index');

    Route::get('/rewards/redeem', [RedeemController::class, 'index'])
        ->name('rewards.redeem');

    Route::post('/rewards/redeem/{id}', [RedeemController::class, 'redeem'])
        ->name('rewards.claim');

    });

// ==================== PUBLIC ====================
Route::get('/about', function () {
    $settings = \App\Models\AboutSetting::all()->groupBy('section')->map(function ($items) {
        return $items->pluck('value', 'key')->toArray();
    });
    $images = \App\Models\AboutSetting::whereNotNull('image')->get()->groupBy('section')->map(function ($items) {
        return $items->pluck('image', 'key')->toArray();
    });
    return view('pages.about', [
        'hero'     => $settings->get('hero', []),
        'visi'     => $settings->get('visi', []),
        'strategi' => $settings->get('strategi', []),
        'sejarah'  => $settings->get('sejarah', []),
        'team'     => $settings->get('team', []),
        'layanan'  => $settings->get('layanan', []),
        'images'   => $images,
    ]);
})->name('about');
Route::get('/contact', function () {
    $settings = \App\Models\AboutSetting::where('section', 'like', 'contact_%')
        ->get()
        ->groupBy('section')
        ->map(function ($items) {
            return $items->pluck('value', 'key')->toArray();
        });
    return view('pages.contact', [
        'hero'   => $settings->get('contact_hero', []),
        'info'   => $settings->get('contact_info', []),
        'sosmed' => $settings->get('contact_sosmed', []),
    ]);
})->name('contact');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.send');

// ==================== EDUCATION USER ====================
Route::get('/education', [EducationController::class, 'index'])->name('education.index');
Route::get('/education/{education}', [EducationController::class, 'show'])->name('education.show');

// ==================== ADMIN ====================
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('users.delete');

    // Wastes
    Route::get('/wastes', [AdminDashboardController::class, 'wastes'])->name('wastes');
    Route::put('/wastes/{waste}/status', [AdminDashboardController::class, 'updateWasteStatus'])->name('wastes.status');
    Route::delete('/wastes/{waste}', [AdminDashboardController::class, 'deleteWaste'])->name('wastes.delete');

    // Reports
    Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
    Route::put('/reports/{report}/status', [AdminDashboardController::class, 'updateReportStatus'])->name('reports.status');
    
    // Report Feedbacks
    Route::get('/reports/{report}/feedback', [AdminDashboardController::class, 'showReportFeedbackForm'])->name('reports.feedback.form');
    Route::post('/reports/{report}/feedback', [AdminDashboardController::class, 'storeReportFeedback'])->name('reports.feedback.store');
    Route::delete('/report-feedbacks/{feedback}', [AdminDashboardController::class, 'deleteReportFeedback'])->name('reports.feedback.delete');

    // Rewards
    Route::get('/rewards', [AdminDashboardController::class, 'rewards'])->name('rewards');
    Route::post('/rewards', [AdminDashboardController::class, 'storeReward'])->name('rewards.store');
    Route::delete('/rewards/{reward}', [AdminDashboardController::class, 'deleteReward'])->name('rewards.delete');

    // Schedules
    Route::get('/schedules', [AdminDashboardController::class, 'schedules'])->name('schedules');
    Route::post('/schedules', [AdminDashboardController::class, 'storeSchedule'])->name('schedules.store');
    Route::put('/schedules/{schedule}', [AdminDashboardController::class, 'updateSchedule'])->name('schedules.update');
    Route::delete('/schedules/{schedule}', [AdminDashboardController::class, 'deleteSchedule'])->name('schedules.delete');

    // Announcements
    Route::get('/announcements', [AdminDashboardController::class, 'announcements'])->name('announcements');
    Route::post('/announcements', [AdminDashboardController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::put('/announcements/{announcement}', [AdminDashboardController::class, 'updateAnnouncement'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AdminDashboardController::class, 'deleteAnnouncement'])->name('announcements.delete');

    // ==================== EDUCATIONS (FULL CRUD) ====================

    // LIST
    Route::get('/educations', [AdminDashboardController::class, 'educations'])->name('educations');

    // CREATE
    Route::post('/educations', [AdminDashboardController::class, 'storeEducation'])->name('educations.store');

    // DELETE
    Route::delete('/educations/{education}', [AdminDashboardController::class, 'deleteEducation'])->name('educations.delete');

    // EDIT PAGE
    Route::get('/educations/{education}/edit', [AdminDashboardController::class, 'edit'])->name('educations.edit');

    // UPDATE
    Route::put('/educations/{education}', [AdminDashboardController::class, 'update'])->name('educations.update');


    // ==================== ABOUT PAGE ====================
    Route::get('/about', [AdminDashboardController::class, 'aboutPage'])->name('about');
    Route::post('/about', [AdminDashboardController::class, 'updateAbout'])->name('about.update');

    // ==================== CONTACT PAGE ====================
    Route::get('/contact', [AdminDashboardController::class, 'contactPage'])->name('contact');
    Route::post('/contact', [AdminDashboardController::class, 'updateContact'])->name('contact.update');

    // ==================== CONTACT MESSAGES ====================
    Route::get('/contact-messages', [AdminDashboardController::class, 'contactMessages'])->name('contact.messages');
    Route::post('/contact-messages/{contactMessage}/reply', [AdminDashboardController::class, 'replyContactMessage'])->name('contact.messages.reply');
    Route::delete('/contact-messages/{contactMessage}', [AdminDashboardController::class, 'deleteContactMessage'])->name('contact.messages.delete');
    Route::patch('/contact-messages/{contactMessage}/read', [AdminDashboardController::class, 'markAsRead'])->name('contact.messages.read');

    // ==================== REVIEWS ====================
    Route::get('/reviews', [AdminDashboardController::class, 'reviews'])->name('reviews');
    Route::put('/reviews/{review}/toggle-visibility', [AdminDashboardController::class, 'toggleReviewVisibility'])->name('reviews.toggle');

});

require __DIR__.'/auth.php';