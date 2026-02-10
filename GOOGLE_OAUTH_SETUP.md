# Google OAuth Setup Guide

## 📋 Ringkasan Integrasi

Google OAuth telah diintegrasikan ke halaman Login dan Register dengan Google Sign-In button. User dapat login/register menggunakan akun Gmail mereka.

---

## 🔧 Setup Google OAuth

### 1. Google Cloud Console Configuration

**Step 1: Buat Project di Google Cloud Console**
1. Akses https://console.cloud.google.com
2. Click "Select a Project" → "New Project"
3. Masukkan nama project: `Citizen Complaint`
4. Click "Create"

**Step 2: Enable Google+ API**
1. Di service search bar, cari "Google+ API"
2. Click pada Google+ API
3. Click "Enable"

**Step 3: Create OAuth 2.0 Credentials**
1. Go to "Credentials" di left sidebar
2. Click "Create Credentials" → "OAuth client ID"
3. Choose "Web application"
4. Masukkan:
   - **Name**: `E-Lapor Web App`
   - **Authorized JavaScript origins**:
     ```
     http://localhost:8000
     http://127.0.0.1:8000
     http://yourapp.local
     https://yourproduction.com
     ```
   - **Authorized redirect URIs**:
     ```
     http://localhost:8000/auth/google/callback
     http://127.0.0.1:8000/auth/google/callback
     http://yourapp.local/auth/google/callback
     https://yourproduction.com/auth/google/callback
     ```
5. Click "Create"
6. Copy `Client ID` dan `Client Secret`

### 2. Laravel Application Setup

**Step 1: Install Laravel Socialite**
```bash
composer require laravel/socialite
```

**Step 2: Update .env file**
```env
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_CALLBACK_URL=http://localhost:8000/auth/google/callback
```

**Step 3: Create OAuth Controller**
```bash
php artisan make:controller GoogleAuthController
```

**Step 4: Implement OAuth Controller**

File: `app/Http/Controllers/GoogleAuthController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Redirect user ke Google OAuth
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari atau buat user
            $user = Pengguna::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'nama_pengguna' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password_hash' => bcrypt(Str::random(24)),
                    'foto_profil' => $googleUser->getAvatar(),
                    'status_verifikasi' => 'verified',
                    'status_aktif' => 'aktif',
                ]
            );

            // Login user
            Auth::loginUsingId($user->id);

            // Redirect ke home/dashboard
            return redirect('/'); // atau route('home')
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login dengan Google');
        }
    }
}
```

**Step 5: Add Routes**

File: `routes/web.php`

```php
use App\Http\Controllers\GoogleAuthController;

Route::middleware('guest')->group(function () {
    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
});
```

**Step 6: Update config/services.php**

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_CALLBACK_URL'),
],
```

---

## 🎨 Frontend Implementation

### Login.vue - Google Sign-In Button

File: `resources/js/Pages/Auth/Login.vue`

```vue
<!-- Or sign in with Google -->
<div class="relative my-6">
  <div class="absolute inset-0 flex items-center">
    <div class="w-full border-t border-gray-300"></div>
  </div>
  <div class="relative flex justify-center text-sm">
    <span class="px-2 bg-white text-gray-500">Atau login dengan</span>
  </div>
</div>

<a href="/auth/google/redirect" class="w-full flex items-center justify-center px-4 py-3 mt-6 font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
  <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"></path>
    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"></path>
    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"></path>
    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"></path>
  </svg>
  Masuk dengan Google
</a>
```

### Register.vue - Google Sign-Up Button

File: `resources/js/Pages/Auth/Register.vue`

```vue
<!-- Or register with Google -->
<div class="relative my-6">
  <div class="absolute inset-0 flex items-center">
    <div class="w-full border-t border-gray-300"></div>
  </div>
  <div class="relative flex justify-center text-sm">
    <span class="px-2 bg-white text-gray-500">Atau daftar dengan</span>
  </div>
</div>

<a href="/auth/google/redirect" class="w-full flex items-center justify-center px-4 py-3 mt-6 font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
  <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
    <!-- Google logo SVG path -->
  </svg>
  Daftar dengan Google
</a>
```

---

## 🔒 Security Considerations

### 1. CSRF Protection
```php
// Automatic dengan Laravel middleware
// Semua POST/PUT/DELETE requests harus include CSRF token
```

### 2. Email Verification
```php
// Optional: Verifikasi email setelah Google login
$user->markEmailAsVerified();
```

### 3. Rate Limiting
```php
Route::middleware('throttle:6,1')->group(function () {
    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect']);
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
});
```

### 4. Secure Redirect
```php
// Validasi redirect URL
$redirect = request()->query('redirect', '/');
if (!in_array($redirect, ['/dashboard', '/home'])) {
    $redirect = '/';
}

return redirect($redirect);
```

---

## 🚀 Testing

### Local Testing
1. Ensure `.env` has `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET`
2. Dalam Google Console, tambahkan `localhost:8000` ke authorized origins
3. Start application: `php artisan serve`
4. Navigate ke `/login` dan click "Masuk dengan Google"

### Production Testing
1. Update `GOOGLE_CALLBACK_URL` di `.env` dengan production URL
2. Tambahkan production domain ke Google Console
3. Test dengan real Google account

---

## 🐛 Troubleshooting

### Error: "Invalid Client ID"
- Pastikan `GOOGLE_CLIENT_ID` di .env benar
- Refresh Google Console dan copy ID lagi

### Error: "Redirect URI mismatch"
- Pastikan URL di callback sama dengan di Google Console
- Include `http://` atau `https://` dengan benar

### Error: "Unable to verify a matching oauth redirect url"
- Recheck authorized redirect URIs di Google Console
- Harus exact match dengan route URL

---

## 📱 OAuth Flow Diagram

```
User → Click "Login with Google"
     ↓
Google OAuth Server
     ↓
User Login di Google (jika belum)
     ↓
User Approve Permissions
     ↓
Google Redirect ke /auth/google/callback
     ↓
GoogleAuthController@callback
     ↓
Find or Create User di Database
     ↓
Auth::loginUsingId()
     ↓
Redirect ke Dashboard
```

---

## 📚 Reference Links

- [Laravel Socialite Documentation](https://laravel.com/docs/socialite)
- [Google OAuth 2.0 Documentation](https://developers.google.com/identity/protocols/oauth2)
- [Google Cloud Console](https://console.cloud.google.com)

---

**Google OAuth Integration Status: ✅ IMPLEMENTED & READY**

Tombol Google sudah tersedia di halaman Login.vue dan Register.vue
Tinggal setup Google Cloud Console credentials dan .env variables
