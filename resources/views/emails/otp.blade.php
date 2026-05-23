<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP</title>
</head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="480" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:16px;border:1px solid #e2e8f0;overflow:hidden;">

                    <tr>
                        <td style="background:#0f172a;padding:28px 40px;">
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background:#1e293b;border-radius:10px;padding:8px 12px;display:inline-block;">
                                        <span style="color:#ffffff;font-size:13px;font-weight:800;letter-spacing:-0.3px;">Griya Asri Kos</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:36px 40px;">
                            <p style="margin:0 0 6px;font-size:20px;font-weight:800;color:#0f172a;letter-spacing:-0.5px;">Reset Kata Sandi</p>
                            <p style="margin:0 0 28px;font-size:14px;color:#64748b;line-height:1.6;">
                                Gunakan kode OTP berikut untuk mereset kata sandi akun Anda. Kode berlaku selama <strong style="color:#0f172a;">15 menit</strong>.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                                <tr>
                                    <td align="center" style="background:#f1f5f9;border-radius:12px;border:1px solid #e2e8f0;padding:24px;">
                                        <p style="margin:0 0 6px;font-size:11px;font-weight:700;color:#94a3b8;letter-spacing:0.2em;text-transform:uppercase;">Kode Verifikasi</p>
                                        <p style="margin:0;font-size:40px;font-weight:900;color:#0f172a;letter-spacing:12px;">{{ $otp }}</p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 8px;font-size:13px;color:#94a3b8;line-height:1.6;">
                                Jika Anda tidak meminta reset kata sandi, abaikan email ini. Akun Anda tetap aman.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#f8fafc;border-top:1px solid #f1f5f9;padding:20px 40px;">
                            <p style="margin:0;font-size:11px;color:#cbd5e1;text-align:center;">
                                &copy; {{ date('Y') }} Griya Asri Kos Surabaya &nbsp;·&nbsp; Gunung Anyar, Surabaya
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
