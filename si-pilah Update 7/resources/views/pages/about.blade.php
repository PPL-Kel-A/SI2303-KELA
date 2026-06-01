<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tentang SI-Pilah - Platform pengelolaan sampah terpadu berbasis teknologi. Visi, misi, tim, dan layanan kami.">
    <title>Tentang Kami - Si-Pilah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    @php
        $heroBg = ($images['hero']['background'] ?? null) ? asset('images/about/' . $images['hero']['background']) : asset('images/about/hero-banner.png');
        $visiImage = ($images['visi']['image'] ?? null) ? asset('images/about/' . $images['visi']['image']) : asset('images/about/volunteers-cleanup.png');
        $sejarahBg = ($images['sejarah']['background'] ?? null) ? asset('images/about/' . $images['sejarah']['background']) : asset('images/about/sejarah-bg.png');
    @endphp
    <style>
        body { font-family: 'Poppins', sans-serif; }
        html { scroll-behavior: smooth; }
        .bg-sipilah-green { background-color: #1b5e20; }
        .text-sipilah-green { color: #1b5e20; }
        .bg-about-soft { background-color: #eef5e9; }

        /* Hero Section */
        .about-hero {
            position: relative;
            min-height: 380px;
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 40%, #388e3c 100%);
            overflow: hidden;
        }
        .about-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('{{ $heroBg }}') center/cover no-repeat;
            opacity: 0.35;
        }
        .about-hero-content {
            position: relative;
            z-index: 2;
        }

        /* Sejarah Section */
        .sejarah-section {
            position: relative;
            background: #1a2332;
            overflow: hidden;
        }
        .sejarah-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('{{ $sejarahBg }}') center/cover no-repeat;
            opacity: 0.2;
        }

        /* Team member circles */
        .team-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #a5d6a7, #66bb6a);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid #e8f5e9;
            box-shadow: 0 4px 16px rgba(27, 94, 32, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .team-avatar:hover {
            transform: translateY(-6px) scale(1.05);
            box-shadow: 0 8px 24px rgba(27, 94, 32, 0.35);
        }
        .team-avatar-lg {
            width: 120px;
            height: 120px;
        }
        .team-avatar svg {
            width: 48px;
            height: 48px;
            color: #fff;
        }
        .team-avatar-lg svg {
            width: 56px;
            height: 56px;
        }

        /* Service card */
        .service-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.1);
        }

        /* Timeline */
        .timeline-line {
            position: absolute;
            left: 50%;
            top: 40px;
            bottom: 40px;
            width: 2px;
            background: rgba(255,255,255,0.15);
            transform: translateX(-50%);
        }
        .timeline-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #4caf50;
            border: 3px solid rgba(255,255,255,0.3);
            box-shadow: 0 0 12px rgba(76, 175, 80, 0.5);
        }

        /* Fade in animation */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.7s ease-out forwards;
        }
        .delay-200 { animation-delay: 0.2s; }
    </style>
</head>
<body class="bg-about-soft text-gray-800">

    @include('partials.navbar', ['variant' => 'welcome'])

    {{-- ========== HERO SECTION ========== --}}
    <section id="about-hero" class="about-hero flex items-center">
        <div class="about-hero-content container mx-auto px-6 py-20 md:py-28">
            <div class="max-w-2xl">
                <span class="inline-block bg-white/15 backdrop-blur-sm text-white/90 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4 border border-white/20">
                    {{ $hero['badge'] ?? 'SI-PILAH' }}
                </span>
                <p class="text-green-200 text-sm mb-2 font-medium">{{ $hero['subtitle'] ?? 'Platform pengelolaan sampah terpadu' }}</p>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white leading-tight mb-4">
                    {{ $hero['title'] ?? 'Solusi mutakhir untuk pengelolaan sampah yang terintegrasi' }}
                </h1>
                <p class="text-green-100/80 text-sm md:text-base max-w-lg leading-relaxed">
                    {{ $hero['description'] ?? 'Mengubah cara masyarakat mengelola sampah melalui teknologi digital, edukasi, dan kolaborasi komunitas.' }}
                </p>
            </div>
        </div>
    </section>

    {{-- ========== VISI DAN STRATEGI ========== --}}
    <section id="visi-strategi" class="py-16 md:py-20 bg-about-soft">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16 max-w-6xl mx-auto">
                {{-- Image --}}
                <div class="w-full md:w-1/2 animate-fade-in-up">
                    <div class="rounded-2xl overflow-hidden shadow-xl border-4 border-white">
                        <img src="{{ $visiImage }}" alt="Relawan SI-Pilah membersihkan lingkungan" class="w-full h-[280px] md:h-[340px] object-cover hover:scale-105 transition-transform duration-700">
                    </div>
                </div>
                {{-- Text --}}
                <div class="w-full md:w-1/2 animate-fade-in-up delay-200">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                        Visi dan Strategi <span class="text-sipilah-green">SI-Pilah</span>
                    </h2>
                    <div class="space-y-4">
                        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                            <h3 class="font-bold text-sipilah-green mb-2 flex items-center gap-2">
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 text-green-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </span>
                                {{ $visi['title'] ?? 'Visi SI-Pilah' }}
                            </h3>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $visi['description'] ?? '' }}</p>
                        </div>
                        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                            <h3 class="font-bold text-sipilah-green mb-2 flex items-center gap-2">
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 text-green-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                </span>
                                {{ $strategi['title'] ?? 'Strategi Kami' }}
                            </h3>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $strategi['description'] ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== SEJARAH SI-PILAH ========== --}}
    <section id="sejarah" class="sejarah-section py-16 md:py-24">
        <div class="relative z-10 container mx-auto px-6">
            <div class="text-center mb-14">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">Sejarah <span class="text-green-400">SI-Pilah</span></h2>
                <div class="w-16 h-1 bg-green-500 mx-auto rounded-full"></div>
            </div>

            <div class="max-w-4xl mx-auto relative">
                <div class="hidden md:block timeline-line"></div>

                <div class="space-y-10 md:space-y-16">
                    @for($i = 1; $i <= 4; $i++)
                        @php
                            $year  = $sejarah['item_'.$i.'_year']  ?? '';
                            $title = $sejarah['item_'.$i.'_title'] ?? '';
                            $desc  = $sejarah['item_'.$i.'_desc']  ?? '';
                            $isLast = $i === 4;
                            $isLeft = $i % 2 === 1;
                        @endphp
                        @if($year || $title)
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            @if($isLeft)
                            <div class="w-full md:w-5/12 text-right">
                                <div class="{{ $isLast ? 'bg-green-500/20 border-green-500/30 hover:bg-green-500/25' : 'bg-white/10 border-white/10 hover:bg-white/15' }} backdrop-blur-sm rounded-xl p-5 border transition">
                                    <span class="text-green-400 font-bold text-sm">{{ $year }}</span>
                                    <h4 class="text-white font-bold mt-1">{{ $title }}</h4>
                                    <p class="text-gray-300 text-sm mt-2 leading-relaxed">{{ $desc }}</p>
                                </div>
                            </div>
                            <div class="hidden md:flex items-center justify-center w-2/12"><div class="timeline-dot"></div></div>
                            <div class="w-full md:w-5/12"></div>
                            @else
                            <div class="w-full md:w-5/12"></div>
                            <div class="hidden md:flex items-center justify-center w-2/12"><div class="timeline-dot"></div></div>
                            <div class="w-full md:w-5/12">
                                <div class="{{ $isLast ? 'bg-green-500/20 border-green-500/30 hover:bg-green-500/25' : 'bg-white/10 border-white/10 hover:bg-white/15' }} backdrop-blur-sm rounded-xl p-5 border transition">
                                    <span class="text-green-400 font-bold text-sm">{{ $year }}</span>
                                    <h4 class="text-white font-bold mt-1">{{ $title }}</h4>
                                    <p class="text-gray-300 text-sm mt-2 leading-relaxed">{{ $desc }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif
                    @endfor
                </div>
            </div>
        </div>
    </section>

    {{-- ========== MEET OUR TEAM ========== --}}
    <section id="team" class="py-16 md:py-20 bg-about-soft">
        <div class="container mx-auto px-6">
            <div class="text-center mb-4">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Meet Our <span class="text-sipilah-green">Team</span></h2>
                <div class="w-16 h-1 bg-green-600 mx-auto mt-3 rounded-full"></div>
            </div>
            <p class="text-center text-gray-500 text-sm max-w-2xl mx-auto mb-14 leading-relaxed">
                "{{ $team['description'] ?? 'Kami adalah tim yang berdedikasi tinggi dalam menciptakan solusi inovatif untuk pengelolaan sampah yang berkelanjutan di Indonesia.' }}"
            </p>

            <div class="max-w-4xl mx-auto">
                {{-- Row 1: Leader --}}
                @if(($team['member_1_name'] ?? '') !== '')
                <div class="flex justify-center mb-10">
                    <div class="text-center group">
                        <div class="team-avatar team-avatar-lg mx-auto mb-3">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm group-hover:text-sipilah-green transition">{{ $team['member_1_name'] }}</h4>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $team['member_1_role'] ?? '' }}</p>
                    </div>
                </div>
                @endif

                {{-- Row 2: Members 2-4 --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mb-10">
                    @for($i = 2; $i <= 4; $i++)
                        @if(($team['member_'.$i.'_name'] ?? '') !== '')
                        <div class="text-center group">
                            <div class="team-avatar mx-auto mb-3">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <h4 class="font-bold text-gray-800 text-sm group-hover:text-sipilah-green transition">{{ $team['member_'.$i.'_name'] }}</h4>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $team['member_'.$i.'_role'] ?? '' }}</p>
                        </div>
                        @endif
                    @endfor
                </div>

                {{-- Row 3: Members 5-7 --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                    @for($i = 5; $i <= 7; $i++)
                        @if(($team['member_'.$i.'_name'] ?? '') !== '')
                        <div class="text-center group">
                            <div class="team-avatar mx-auto mb-3">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <h4 class="font-bold text-gray-800 text-sm group-hover:text-sipilah-green transition">{{ $team['member_'.$i.'_name'] }}</h4>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $team['member_'.$i.'_role'] ?? '' }}</p>
                        </div>
                        @endif
                    @endfor
                </div>
            </div>
        </div>
    </section>

    {{-- ========== LAYANAN KAMI ========== --}}
    <section id="layanan" class="py-16 md:py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-14">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Layanan <span class="text-sipilah-green">Kami</span></h2>
                <div class="w-16 h-1 bg-green-600 mx-auto mt-3 rounded-full"></div>
            </div>

            @php
                $defaultImages = ['service-consulting.png', 'service-collection.png', 'service-recycling.png', 'service-digital.png'];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                @for($i = 1; $i <= 4; $i++)
                    @php
                        $lTitle = $layanan['item_'.$i.'_title'] ?? '';
                        $lDesc  = $layanan['item_'.$i.'_desc']  ?? '';
                        $lImg   = ($images['layanan']['item_'.$i.'_image'] ?? null) 
                                    ? asset('images/about/' . $images['layanan']['item_'.$i.'_image']) 
                                    : asset('images/about/' . ($defaultImages[$i-1] ?? 'service-consulting.png'));
                    @endphp
                    @if($lTitle)
                    <div class="service-card flex flex-col sm:flex-row">
                        <div class="sm:w-3/5 p-6">
                            <h3 class="font-bold text-gray-800 text-lg mb-2">{{ $lTitle }}</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">{{ $lDesc }}</p>
                        </div>
                        <div class="sm:w-2/5">
                            <img src="{{ $lImg }}" alt="{{ $lTitle }}" class="w-full h-full min-h-[160px] object-cover">
                        </div>
                    </div>
                    @endif
                @endfor
            </div>
        </div>
    </section>

    {{-- ========== CTA SECTION ========== --}}
    <section class="bg-gradient-to-r from-green-800 to-green-600 py-14">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Siap Bergabung dengan SI-Pilah?</h2>
            <p class="text-green-100 text-sm md:text-base max-w-xl mx-auto mb-8">Mulai kontribusi Anda untuk lingkungan yang lebih bersih dan masa depan yang lebih baik.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/register" class="bg-white text-sipilah-green font-bold px-8 py-3 rounded-full shadow-lg hover:bg-green-50 hover:scale-105 transition-all duration-300 text-sm uppercase tracking-wider">
                    Daftar Sekarang
                </a>
                <a href="{{ route('contact') }}" class="border-2 border-white text-white font-bold px-8 py-3 rounded-full hover:bg-white hover:text-sipilah-green transition-all duration-300 text-sm uppercase tracking-wider">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    @include('partials.footer')

</body>
</html>
