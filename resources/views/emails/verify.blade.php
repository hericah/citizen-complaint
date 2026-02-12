<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333333;
        }
        .content {
            color: #555555;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3490dc;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verifikasi Email Anda</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $pengguna->nama_pengguna }}</strong>,</p>
            <p>Terima kasih telah mendaftar di E-Lapor Pemkab Pemalang. Untuk mengaktifkan akun Anda, silakan klik tombol di bawah ini:</p>

            <div style="text-align: center;">
                <a href="{{ $url }}" class="button">Verifikasi Email</a>
            </div>

            <p>Jika tombol di atas tidak berfungsi, Anda juga dapat menyalin dan menempel tautan berikut ke browser Anda:</p>
            <p style="word-break: break-all;"><a href="{{ $url }}">{{ $url }}</a></p>

            <p>Terima kasih,<br>Tim E-Lapor Pemkab Pemalang</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} E-Lapor Pemkab Pemalang. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
