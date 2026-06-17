<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $booking->id }} — Griya Asri Kos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* ─── TASK 1: Safari blank-page fix ────────────────────────────────────
         * Safari recalculates vh units against the print page dimensions, so
         * `min-h-screen` (min-height: 100vh) on <body> forces the body to be
         * at least one full print-page tall even when content is shorter.
         * This causes a blank second page. Override to auto so height is purely
         * content-driven in print context. We do NOT remove min-h-screen from
         * the HTML class — it stays for the normal on-screen display.
         * ──────────────────────────────────────────────────────────────────── */
        @media print {
            html, body {
                height: auto !important;
                min-height: 0 !important;
            }

            /* Preserve background colors (dark header, slate panels) in print.
             * Without this, WebKit strips backgrounds by default. */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .no-print {
                display: none !important;
            }

            body {
                /* Reset on-screen body padding (py-10 px-4) to nothing in print —
                 * the @page margin already provides the outer whitespace. */
                padding: 0 !important;
                background: white !important;
            }

            @page {
                /* 0.4in instead of 0.5in to recover ~14.4pt of vertical room
                 * on each side (28.8pt total), which is enough to accommodate
                 * 4–5 service line items without overflow. The visual margin is
                 * still generous and professional at 0.4in. */
                margin: 0.4in;
                size: A4 portrait;
            }

            .receipt-card {
                box-shadow: none !important;
                border: 1px solid #e2e8f0 !important;
                /* Ensure the card fills the page width in print */
                max-width: 100% !important;
                margin: 0 !important;
            }

            /* ─── TASK 2: Print-density overrides to fit one A4 page ────────────
             * Available print area with 0.4in margins on A4 portrait:
             *   Height: 297mm − (2 × 0.4in) = 297mm − 20.3mm ≈ 276.7mm ≈ 784pt
             * Target sections and reduce only vertical spacing/padding.
             * On-screen Tailwind classes are completely untouched.
             * ──────────────────────────────────────────────────────────────────── */

            /* Header block: px-8 py-6 → keep px-8, reduce py-6 (24px) → 12px */
            .receipt-card > div:first-child {
                padding-top: 12px !important;
                padding-bottom: 12px !important;
            }

            /* Body wrapper: px-8 py-6 space-y-6 → keep px-8, reduce py → 12px,
             * reduce space-y-6 (24px gap) → 12px between major sections */
            .receipt-card > div:last-child {
                padding-top: 12px !important;
                padding-bottom: 12px !important;
            }

            /* space-y-6 child gap: override the margin-top Tailwind generates */
            .receipt-card > div:last-child > * + * {
                margin-top: 12px !important;
            }

            /* Check-in/out/duration grid cells: p-4 (16px) → 8px */
            .receipt-card > div:last-child > div > div[class*="p-4"],
            .receipt-card > div:last-child > div > div > div[class*="p-4"] {
                padding: 8px !important;
            }

            /* Room row item: p-4 → p-2 (tighter line items) */
            .receipt-card > div:last-child > div:nth-child(3) > div > div {
                padding: 8px 12px !important;
            }

            /* Service line items: p-4 → tighter */
            .receipt-card > div:last-child > div:nth-child(3) > div > div[class*="space-y-2"] > div,
            .receipt-card > div:last-child > div:nth-child(3) .space-y-2 > div {
                padding: 8px 12px !important;
            }

            /* "Total Lunas" dark banner: p-5 (20px) → 10px */
            .receipt-card > div:last-child > div[class*="bg-slate-900"] {
                padding: 10px 16px !important;
            }

            /* Footer: pt-4 → pt-2 */
            .receipt-card > div:last-child > div:last-child {
                padding-top: 8px !important;
            }

            /* Subtotal row: pt-4 → pt-2 */
            .receipt-card [class*="border-dashed"] {
                padding-top: 8px !important;
            }

            /* Reduce font-size of the large total figure slightly so it doesn't
             * claim excessive vertical space (text-2xl → ~18px in print) */
            .receipt-card p[class*="text-2xl"] {
                font-size: 18px !important;
            }

            /* ─── Font/Icon race-condition guard ────────────────────────────────
             * Google Fonts and Font Awesome are loaded async via <link>.
             * Safari can open the print dialog before these finish loading.
             * Font Awesome icons on this page are purely decorative (home icon,
             * print button is hidden, shield icon in "Verified" badge).
             * None of them are block-level or contain textual content that
             * would be invisible if the icon font hasn't loaded.
             * The print button is already hidden via .no-print.
             * As a safeguard: ensure <i> icon elements are inline with a
             * defined minimum width so they don't collapse or reflow text
             * if the icon font hasn't loaded by print time. */
            i[class*="fas"],
            i[class*="fab"],
            i[class*="fa-"] {
                display: inline-block !important;
                min-width: 0.75em;
                font-style: normal;
            }
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen antialiased py-10 px-4">

    <div class="max-w-2xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('profile', ['tab' => 'history']) }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Riwayat
        </a>
        <button onclick="window.print()"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white text-sm font-semibold rounded-xl hover:bg-black transition-all shadow-md">
            <i class="fas fa-print text-xs"></i> Cetak / Simpan PDF
        </button>
    </div>

    <div
        class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-200 overflow-hidden receipt-card">

        <div class="bg-slate-900 px-8 py-6">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-home text-white text-sm"></i>
                        </div>
                        <span class="text-white font-black text-lg tracking-tight">Griya Asri Kos</span>
                    </div>
                    <p class="text-slate-400 text-xs font-medium">Gunung Anyar, Surabaya, Jawa Timur</p>
                    <p class="text-slate-400 text-xs font-medium mt-0.5">griyakos@gmail.com · +62 895 0239 0206</p>
                </div>
                <div class="text-right">
                    <div
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500/20 border border-emerald-500/30 rounded-lg mb-2">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                        <span class="text-emerald-400 text-xs font-bold uppercase tracking-wide">Lunas</span>
                    </div>
                    <p class="text-slate-300 text-xs font-semibold">{{ $booking->id }}</p>
                    <p class="text-slate-500 text-[10px] mt-0.5">
                        {{ \Carbon\Carbon::parse($paymentTime)->translatedFormat('d M Y, H:i') }} WIB
                    </p>
                </div>
            </div>
        </div>

        <div class="px-8 py-6 space-y-6">

            <div class="grid grid-cols-2 gap-6 pb-6 border-b border-slate-100">
                <div>
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-2">Penyewa</p>
                    <p class="text-sm font-bold text-slate-900">
                        {{ $booking->user->full_name_ktp ?: $booking->user->nickname }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $booking->user->email }}</p>
                    @if ($booking->user->phone)
                        <p class="text-xs text-slate-500">{{ $booking->user->phone }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-2">Metode Bayar</p>
                    <p class="text-sm font-bold text-slate-900">{{ $paymentMethod }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">Powered by Midtrans</p>
                </div>
            </div>

            <div class="grid grid-cols-3 bg-slate-50 rounded-xl border border-slate-200 overflow-hidden">
                <div class="p-4 text-center border-r border-slate-200">
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1">Mulai</p>
                    <p class="text-sm font-bold text-slate-800">{{ $checkIn->translatedFormat('d M Y') }}</p>
                </div>
                <div class="p-4 text-center bg-slate-900">
                    <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-1">Durasi</p>
                    <p class="text-sm font-bold text-white">{{ $days }} Hari</p>
                </div>
                <div class="p-4 text-center border-l border-slate-200">
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1">Selesai</p>
                    <p class="text-sm font-bold text-slate-800">{{ $checkOut->translatedFormat('d M Y') }}</p>
                </div>
            </div>

            <div>
                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-3">Rincian Pesanan</p>
                <div class="space-y-2">

                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Kamar No. {{ $booking->room->room_number }}
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $booking->room->roomType->name }} ·
                                {{ $days }} hari</p>
                        </div>
                        <p class="text-sm font-bold text-slate-900">Rp {{ number_format($roomPrice, 0, ',', '.') }}</p>
                    </div>

                    @foreach ($serviceDetails as $s)
                        <div
                            class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200 border-l-4 border-l-primary">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">{{ $s['name'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    {{ $s['qty'] }} {{ $s['unit'] }} × Rp
                                    {{ number_format($s['price_unit'], 0, ',', '.') }}
                                </p>
                            </div>
                            <p class="text-sm font-bold text-slate-700">Rp {{ number_format($s['cost'], 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach

                    <div class="flex items-center justify-between pt-4 border-t border-dashed border-slate-200">
                        <p class="text-sm font-semibold text-slate-500">Total Pembayaran</p>
                        <p class="text-xl font-black text-slate-900">Rp
                            {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 rounded-xl p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-1">Total Lunas</p>
                    <div class="flex items-center gap-2">
                        <span
                            class="text-[10px] font-semibold text-emerald-400 bg-emerald-500/20 px-2 py-0.5 rounded-md">
                            <i class="fas fa-shield-halved mr-1"></i>Verified
                        </span>
                    </div>
                </div>
                <p class="text-2xl font-black text-white tracking-tight">
                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                </p>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-[10px] text-slate-400 font-medium">Dokumen resmi Griya Asri Kos</p>
                    <p class="text-[10px] text-slate-300 mt-0.5">Dicetak: {{ now()->translatedFormat('d M Y, H:i') }}
                        WIB</p>
                </div>
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_Midtrans.png"
                    class="h-3 opacity-20 grayscale" alt="Midtrans">
            </div>

        </div>
    </div>

    <p class="text-center text-slate-400 text-xs mt-6 no-print">
        &copy; {{ date('Y') }} Griya Asri Kos Surabaya. All rights reserved.
    </p>

</body>

</html>
