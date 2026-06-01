<x-guest-layout>
    <h1 class="auth-card-title">Selamat Datang Kembali 👋</h1>
    <p class="auth-card-subtitle">Masuk ke akun Si-Pilah Anda untuk melanjutkan</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com">
            @error('email')
                <p class="input-error-msg">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi">
            @error('password')
                <p class="input-error-msg">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin: 1rem 0;">
            <div class="form-check" style="margin: 0;">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Ingat saya</label>
            </div>
            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-sipilah">
            Masuk ke Akun
        </button>
    </form>

    <div class="auth-bottom-link">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
    </div>
</x-guest-layout>
