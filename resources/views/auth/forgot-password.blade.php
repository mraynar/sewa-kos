<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi | Griya Asri Kos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="bg-slate-100 font-sans antialiased min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">

        <a href="{{ route('login') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-slate-400 hover:text-slate-700 transition-colors mb-8 group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke halaman masuk
        </a>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl shadow-slate-200/60 p-8">

            <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mb-6">
                <i class="fas fa-lock text-slate-600 text-base"></i>
            </div>

            <h1 class="text-xl font-bold text-slate-900 mb-1">Lupa Kata Sandi?</h1>
            <p class="text-sm text-slate-400 mb-8">Masukkan email terdaftar Anda. Kami akan mengirimkan kode verifikasi 6 digit.</p>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-500 text-sm flex-shrink-0"></i>
                    <p class="text-sm font-semibold text-emerald-700">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-400 text-sm flex-shrink-0"></i>
                    <p class="text-sm font-semibold text-red-600">{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ route('password.send-otp') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="contoh@gmail.com"
                        class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all
                        @error('email') border-red-300 @enderror">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-3 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-all shadow-md shadow-primary/20 active:scale-[0.98]">
                    Kirim Kode Verifikasi
                </button>
            </form>

        </div>

        <p class="text-center text-xs text-slate-400 mt-6">&copy; {{ date('Y') }} Griya Asri Kos Surabaya</p>
    </div>

</body>
</html>
