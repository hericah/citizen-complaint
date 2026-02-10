# 🚀 Quick Start & Developer Reference

## 📋 Daftar Isi Cepat

- [Setup Awal](#setup-awal)
- [Menjalankan Project](#menjalankan-project)
- [Command Penting](#command-penting)
- [File Locations](#file-locations)
- [Key Concepts](#key-concepts)

---

## 🔧 Setup Awal

### 1. Clone atau Buka Project
```bash
cd c:\laragon\www\citizen-complaint
```

### 2. Install Dependencies
```bash
# Backend
composer install

# Frontend
npm install
```

### 3. Setup Environment
```bash
# Copy .env
cp .env.example .env

# Generate key
php artisan key:generate
```

### 4. Database Setup
```bash
# Run migrations
php artisan migrate

# Run seeders (opsional)
php artisan db:seed
```

### 5. Google OAuth Configuration
```bash
# Update .env dengan:
GOOGLE_CLIENT_ID=your_id
GOOGLE_CLIENT_SECRET=your_secret
GOOGLE_CALLBACK_URL=http://localhost:8000/auth/google/callback
```

---

## ▶️ Menjalankan Project

### Terminal 1: Start Laravel Server
```bash
php artisan serve
```
**Output:** `Server running at http://127.0.0.1:8000`

### Terminal 2: Start Frontend Watch
```bash
npm run dev
```
**Output:** `VITE v5.0.0 ready in XXX ms`

### Testing
```bash
php artisan test
```

---

## 🎯 Command Penting

### Database Commands
```bash
# Reset database lengkap
php artisan migrate:fresh

# Reset dengan seeder data
php artisan migrate:fresh --seed

# Rollback last migration
php artisan migrate:rollback

# Check migration status
php artisan migrate:status
```

### Cache & Config
```bash
# Clear all cache
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Optimize config (production)
php artisan config:cache

# View cache
php artisan cache:forget key_name
```

### Tinker (Debug Console)
```bash
# Start tinker shell
php artisan tinker

# Contoh:
> $user = App\Models\Pengguna::first();
> $user->email;
> exit()
```

### Code Cleanup
```bash
# Format code dengan PSR-4 standard
composer format

# Run tests
php artisan test

# Check code style
composer lint
```

### Assets
```bash
# Build untuk production
npm run build

# Build dan minify
npm run prod

# Watch changes (development)
npm run dev
```

---

## 📁 File Locations

### Controllers Path
```
app/Http/Controllers/
├── PenggunaController.php
├── PeranController.php
├── KategoriController.php
├── AksesaduanController.php
├── DaftarAduanController.php
├── LaporanAduanController.php
└── PengaturanController.php
```

### Models Path
```
app/Models/
├── Pengguna.php
├── Peran.php
├── KategoriAduan.php
├── AksesAduan.php
├── OPD.php
├── Aduan.php
├── Masyarakat.php
├── StatusAduan.php
├── RiwayatStatusAduan.php
├── TanggapanAduan.php
├── Menu.php
└── HakAkses.php
```

### Views Path
```
resources/js/Pages/Admin/
├── Master/
│   ├── Pengguna/
│   ├── Peran/
│   ├── KategoriAduan/
│   └── AksesAduan/
├── ManajemenAduan/
├── Laporan/
└── Pengaturan/
```

### Routes Path
```
routes/web.php
```

### Migrations Path
```
database/migrations/
```

---

## 🧠 Key Concepts

### Model Relationships

#### Pengguna Model
```php
// Many-to-Many dengan Peran
$user->peran()           // Get all roles
$user->hasRole('admin')  // Check role

// Many-to-Many dengan OPD
$user->opd()             // Get all OPDs
```

#### Aduan Model
```php
// Belongs To relationships
$aduan->masyarakat       // Get reporter data
$aduan->kategoriAduan    // Get category
$aduan->aksesAduan       // Get access level
$aduan->statusAduan      // Get current status

// Has Many relationships
$aduan->riwayatStatus()  // Get status history
$aduan->tanggapan()      // Get responses
```

### Controller Patterns

#### CRUD Pattern
```php
// List dengan pagination
$items = Model::paginate(10);

// Create form
return Inertia::render('view', ['form' => $model]);

// Store dengan validation
$validated = $request->validate([...]);
Model::create($validated);

// Edit dengan pre-filled data
$item = Model::findOrFail($id);
return Inertia::render('view', ['item' => $item]);

// Update
$item->update($validated);

// Delete
$item->delete();
```

#### Inertia Response Pattern
```php
use Inertia\Inertia;

return Inertia::render('ComponentName', [
    'key1' => $value1,
    'key2' => $value2,
]);
```

### Vue 3 Component Pattern
```vue
<script setup>
import { ref } from 'vue'

defineProps({
  user: Object,
  items: Array,
})

const form = ref({
  name: '',
  email: '',
})

const handleSubmit = async () => {
  // Handle form
}
</script>

<template>
  <div>...</div>
</template>
```

---

## 🔐 Authentication Flow

### Login Flow
```
User fills login form
       ↓
POST /login → AuthController@login
       ↓
Validate credentials
       ↓
Store session
       ↓
Redirect to home/dashboard
```

### Google OAuth Flow
```
User clicks "Login with Google"
       ↓
GET /auth/google/redirect
       ↓
Redirect to Google OAuth server
       ↓
User authorizes
       ↓
GET /auth/google/callback?code=XXX
       ↓
GoogleAuthController@callback
       ↓
Exchange code for token
       ↓
Get user info from Google
       ↓
Find or Create Pengguna
       ↓
Log user in
       ↓
Redirect to home
```

### Middleware Protection
```php
Route::middleware(CheckAuth::class)->group(function () {
    // Routes inside this group require authentication
});
```

---

## 📚 Database Schema Quick Reference

### Pengguna Table
```sql
id (PK)
nama_pengguna (VARCHAR)
email (VARCHAR, UNIQUE)
password_hash (VARCHAR)
status_verifikasi (ENUM: verified, unverified)
status_aktif (ENUM: aktif, nonaktif)
created_at
updated_at
```

### Aduan Table
```sql
id (PK)
no_aduan (VARCHAR, UNIQUE)
tanggal_lapor (DATETIME)
kategori_aduan_id (FK)
akses_aduan_id (FK)
status_aduan_id (FK)
masyarakat_id (FK)
isi_aduan (TEXT)
lokasi (VARCHAR)
created_at
updated_at
```

### Peran Table
```sql
id (PK)
nama_peran (VARCHAR)
keterangan (TEXT)
created_at
updated_at
```

---

## 🛠️ Common Development Tasks

### Add New Master Data Menu

1. **Create Migration:**
```bash
php artisan make:migration create_new_table
```

2. **Create Model:**
```bash
php artisan make:model NewModel
```

3. **Create Controller:**
```bash
php artisan make:controller NewController
```

4. **Create Views:**
```bash
# Create Vue component
resources/js/Pages/Admin/Master/New/Index.vue
resources/js/Pages/Admin/Master/New/Create.vue
resources/js/Pages/Admin/Master/New/Edit.vue
```

5. **Add Routes:**
```php
Route::get('/master/new', [NewController::class, 'index']);
Route::get('/master/new/create', [NewController::class, 'create']);
Route::post('/master/new', [NewController::class, 'store']);
Route::get('/master/new/{id}/edit', [NewController::class, 'edit']);
Route::put('/master/new/{id}', [NewController::class, 'update']);
Route::delete('/master/new/{id}', [NewController::class, 'destroy']);
```

### Add Form Validation

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:table,email',
        'status' => 'required|in:aktif,nonaktif',
    ]);
    
    Model::create($validated);
    return redirect()->back()->with('success', 'Data berhasil ditambahkan');
}
```

### Add Authentication Check

```php
public function __construct()
{
    $this->middleware(CheckAuth::class);
}
```

---

## 🐛 Debugging Tips

### Check Active Queries
```php
// In controller
DB::enableQueryLog();
// ... code ...
dd(DB::getQueryLog());
```

### Log Messages
```php
Log::info('Message here');
Log::debug('Debug info');
Log::error('Error occurred');
```

### View Passed Data
```vue
<!-- In Vue template -->
<pre>{{ JSON.stringify(items, null, 2) }}</pre>
```

### Browser DevTools
```
F12 → Console → test JavaScript
F12 → Network → check API calls
F12 → Application → check cookies/storage
```

---

## 📊 Performance Optimization

### Database Queries
```php
// ❌ N+1 Query Problem
$users = Pengguna::all();
foreach ($users as $user) {
    echo $user->peran;  // Query inside loop!
}

// ✅ Use eager loading
$users = Pengguna::with('peran')->get();
foreach ($users as $user) {
    echo $user->peran;  // No extra query!
}
```

### Cache Results
```php
// Cache query results
$users = Cache::remember('users', 3600, function () {
    return Pengguna::all();
});
```

### Pagination
```php
// Already implemented in controllers
$items = Item::paginate(10);  // 10 items per page
```

---

## 🚨 Error Handling

### Try-Catch Pattern
```php
try {
    // Code here
} catch (\Exception $e) {
    Log::error($e->getMessage());
    return redirect()->back()->with('error', 'Terjadi kesalahan');
}
```

### Model Not Found
```php
// Auto returns 404
$item = Model::findOrFail($id);
```

### Validation Errors
```php
// Automatically passed to view
$validated = $request->validate([...]);
```

---

## 📱 Testing URLs (Local)

```
http://localhost:8000              → Home page
http://localhost:8000/login        → Login page
http://localhost:8000/register     → Register page
http://localhost:8000/master/pengguna        → Pengguna list
http://localhost:8000/master/peran           → Peran list
http://localhost:8000/master/kategori        → Kategori list
http://localhost:8000/master/aksesaduan      → Akses list
http://localhost:8000/manajemenaduan/daftaraduan    → Aduan management
http://localhost:8000/laporan/laporanaduan          → Reports
http://localhost:8000/pengaturan/profile            → Settings
```

---

## 🔑 Key Environment Variables

```env
# App
APP_NAME=E-Lapor
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citizen_complaint
DB_USERNAME=root
DB_PASSWORD=

# Google OAuth
GOOGLE_CLIENT_ID=your_id
GOOGLE_CLIENT_SECRET=your_secret
GOOGLE_CALLBACK_URL=http://localhost:8000/auth/google/callback

# Mail
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=
```

---

## 📖 Learning Resources

### Laravel
- [Laravel Documentation](https://laravel.com/docs)
- [Eloquent Documentation](https://laravel.com/docs/eloquent)
- [Inertia.js Guide](https://inertiajs.com)

### Vue
- [Vue 3 Guide](https://vuejs.org)
- [Composition API](https://vuejs.org/guide/extras/composition-api-faq.html)

### Tailwind
- [Tailwind CSS Docs](https://tailwindcss.com)
- [Component Library](https://headlessui.com)

---

## ✅ Pre-Deployment Checklist

- [ ] All tests passing
- [ ] No console errors
- [ ] Database optimized
- [ ] Environment variables set
- [ ] HTTPS configured
- [ ] Assets built & minified
- [ ] Logs configured
- [ ] Backups setup
- [ ] Monitoring active
- [ ] Documentation updated

---

## 🆘 Quick Troubleshooting

| Problem | Solution |
|---------|----------|
| Page not loading | Check `npm run dev` is running |
| 404 errors | Check route in `web.php` |
| Database error | Run `php artisan migrate` |
| Assets not loading | Run `npm run build` |
| Sessions not working | Check `SESSION_DRIVER` in .env |
| Google OAuth fails | Verify `GOOGLE_CLIENT_ID` in .env |

---

**Happy Coding! 🚀**

For more info, see:
- IMPLEMENTATION_STATUS.md
- USER_GUIDE.md
- GOOGLE_OAUTH_SETUP.md
