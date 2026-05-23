<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP | Griya Asri Kos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-100 font-sans antialiased min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">

        <a href="{{ route('password.request') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-slate-400 hover:text-slate-700 transition-colors mb-8 group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl shadow-slate-200/60 p-8">

            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                <i class="fas fa-envelope-open-text text-primary text-base"></i>
            </div>

            <h1 class="text-xl font-bold text-slate-900 mb-1">Cek Email Anda</h1>
            <p class="text-sm text-slate-400 mb-1">Kode 6 digit telah dikirim ke</p>
            <p class="text-sm font-semibold text-slate-700 mb-8">{{ $email }}</p>

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

            <form action="{{ route('password.verify-otp') }}" method="POST" class="space-y-5"
                  x-data="otpInput()">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-3">Kode Verifikasi</label>
                    <div class="flex gap-2 justify-between">
                        <template x-for="(digit, index) in digits" :key="index">
                            <input
                                type="text"
                                inputmode="numeric"
                                maxlength="1"
                                x-model="digits[index]"
                                @input="handleInput(index, $event)"
                                @keydown.backspace="handleBackspace(index, $event)"
                                @paste.prevent="handlePaste($event)"
                                :x-ref="'otp' + index"
                                :id="'otp' + index"
                                class="w-12 h-14 text-center text-xl font-black text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                :class="digits[index] ? 'bg-primary/5 border-primary/40' : ''">
                        </template>
                    </div>
                    <input type="hidden" name="otp" :value="digits.join('')">
                    @error('otp')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-3 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-all shadow-md shadow-primary/20 active:scale-[0.98]">
                    Verifikasi Kode
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-100 text-center" x-data="resendTimer()">
                <p class="text-xs text-slate-400 mb-2">Tidak menerima kode?</p>
                <template x-if="countdown > 0">
                    <p class="text-xs font-semibold text-slate-400">
                        Kirim ulang dalam <span class="text-primary" x-text="countdown + ' detik'"></span>
                    </p>
                </template>
                <template x-if="countdown === 0">
                    <form action="{{ route('password.send-otp') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <button type="submit" class="text-xs font-semibold text-primary hover:underline">
                            Kirim ulang kode
                        </button>
                    </form>
                </template>
            </div>

        </div>

        <p class="text-center text-xs text-slate-400 mt-6">&copy; {{ date('Y') }} Griya Asri Kos Surabaya</p>
    </div>

    <script>
        function otpInput() {
            return {
                digits: ['', '', '', '', '', ''],
                handleInput(index, event) {
                    const val = event.target.value.replace(/\D/g, '');
                    this.digits[index] = val.slice(-1);
                    if (val && index < 5) {
                        document.getElementById('otp' + (index + 1)).focus();
                    }
                },
                handleBackspace(index, event) {
                    if (!this.digits[index] && index > 0) {
                        document.getElementById('otp' + (index - 1)).focus();
                    }
                },
                handlePaste(event) {
                    const paste = event.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
                    paste.split('').forEach((char, i) => {
                        if (i < 6) this.digits[i] = char;
                    });
                    const last = Math.min(paste.length, 5);
                    document.getElementById('otp' + last).focus();
                }
            }
        }

        function resendTimer() {
            return {
                countdown: 60,
                init() {
                    const interval = setInterval(() => {
                        if (this.countdown > 0) this.countdown--;
                        else clearInterval(interval);
                    }, 1000);
                }
            }
        }
    </script>

</body>
</html>
