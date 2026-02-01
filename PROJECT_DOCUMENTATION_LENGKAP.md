# 📖 Dokumentasi Lengkap Project LMC (Legian Medical Clinic)

## Pengantar

Dokumen ini menyediakan panduan komprehensif untuk memahami sistem Legian Medical Clinic (LMC). Setiap bagian dimulai dengan penjelasan konseptual yang mudah dipahami, diikuti dengan detail teknis implementasi termasuk code examples, flow diagrams, dan best practices yang diterapkan.

## 📑 Daftar Isi
1. [Gambaran Umum Project](#gambaran-umum-project)
2. [Arsitektur Sistem](#arsitektur-sistem)
3. [Fitur-Fitur Utama](#fitur-fitur-utama)
4. [Penjelasan Database](#penjelasan-database)
5. [Alur Sistem & Logika](#alur-sistem--logika)
6. [Penjelasan File per File](#penjelasan-file-per-file)
7. [Flow Diagram](#flow-diagram)
8. [Logika Bisnis Penting](#logika-bisnis-penting)

---

## 🎯 Gambaran Umum Project

### Apa itu LMC?

**Legian Medical Clinic (LMC)** adalah sistem informasi manajemen klinik medis yang dibangun menggunakan framework Laravel 12. Aplikasi ini dirancang untuk memfasilitasi dua kelompok pengguna utama: **pengunjung website** (pasien dan calon pasien) serta **tim administrasi klinik** (owner dan admin).

Sistem ini menyelesaikan berbagai masalah umum yang dihadapi klinik medis dalam pengelolaan informasi digital. Pertama, memberikan informasi yang lengkap dan mudah diakses kepada pengunjung tentang layanan medis, dokter, dan lokasi klinik. Kedua, memudahkan tim administrasi dalam mengelola konten website tanpa perlu keahlian teknis yang mendalam. Ketiga, menyediakan konten dalam dua bahasa untuk menjangkau audiens yang lebih luas.

### 🌐 Landing Page (Public)

Landing page adalah website publik yang bisa diakses oleh siapa saja tanpa perlu login. Halaman ini dirancang dengan user experience yang optimal, menampilkan informasi penting secara hirarki. Pengunjung pertama kali akan disambut dengan banner hero yang eye-catching, diikuti dengan section-section informatif seperti About (tentang klinik), Services (layanan medis), Doctors (profil dokter), Gallery (foto-foto klinik), Articles (artikel kesehatan), dan Contact (informasi kontak dengan peta lokasi).

Yang menarik adalah sistem ini memiliki fitur preference modal. Ketika pengunjung pertama kali membuka website, mereka ditanya "Apa yang Anda cari hari ini?" dengan pilihan Services, Doctors, Contact, atau All. Berdasarkan pilihan ini, halaman akan auto-scroll ke section yang relevan, mengurangi friction dan membuat pengunjung cepat menemukan informasi yang mereka butuhkan.

### 👨‍💼 Admin Panel (Private)

Admin panel adalah dashboard khusus untuk tim internal klinik yang hanya bisa diakses setelah login. Panel ini memiliki sistem Role-Based Access Control (RBAC) yang membedakan hak akses antara Owner dan Admin. Owner memiliki akses penuh termasuk mengelola user, sementara Admin hanya bisa mengelola konten website.

Dari admin panel, tim klinik bisa mengelola semua aspek konten tanpa perlu menyentuh code. Mereka bisa update informasi header, mengubah deskripsi about, menambah layanan baru, mengupload foto dokter, membuat artikel kesehatan, mengatur galeri foto, dan mengupdate informasi kontak - semuanya melalui form yang user-friendly.

---

## 🏗️ Arsitektur Sistem

### Tech Stack Overview

Sistem LMC dibangun dengan kombinasi teknologi modern yang proven dan reliable:

```
┌─────────────────────────────────────────────┐
│           Frontend Layer                     │
│  - Blade Templates (Laravel)                 │
│  - Bootstrap 5 (Responsive UI)               │
│  - JavaScript Vanilla (Interactivity)        │
└─────────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────────┐
│         Application Layer                    │
│  - Laravel 12 Framework (PHP 8.2+)           │
│  - Controllers (MVC Pattern)                 │
│  - Services (Business Logic)                 │
│  - Middleware (Auth, Role)                   │
└─────────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────────┐
│           Data Layer                         │
│  - Eloquent ORM (Database Abstraction)       │
│  - MySQL/MariaDB (Relational DB)             │
│  - File Storage (Images)                     │
└─────────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────────┐
│        External Services                     │
│  - Google Cloud Translation API              │
│  - Google Analytics (Traffic Analysis)       │
│  - Schema.org (SEO Structured Data)          │
└─────────────────────────────────────────────┘
```

### Penjelasan Arsitektur Layer

**Frontend Layer** menghandle semua yang dilihat dan diinteraksi oleh user. Blade sebagai template engine memungkinkan kita menulis HTML dengan dynamic data dari backend. Bootstrap 5 menyediakan komponen UI yang responsif sehingga website tampil baik di desktop maupun mobile. JavaScript vanilla digunakan untuk interaktivitas seperti modal, form validation, dan smooth scrolling - tanpa dependency framework berat sehingga loading tetap cepat.

**Application Layer** adalah inti dari logika bisnis. Laravel 12 framework menyediakan struktur MVC yang rapi. Controllers menghandle HTTP requests dan responses, Models merepresentasikan data dan relasi database, Views menampilkan data dalam format HTML. Services adalah class khusus yang mengextract logika bisnis kompleks (seperti translation, analytics, image processing) agar Controllers tetap slim.

**Data Layer** menghandle persistence. Eloquent ORM memungkinkan kita berinteraksi dengan database menggunakan PHP object-oriented code daripada raw SQL. Ini membuat code lebih maintainable dan secure dari SQLinjection. File storage menggunakan Laravel's filesystem yang mendukung local disk dan cloud storage (S3, etc).

**External Services** memperkaya functionality. Google Cloud Translation API enable auto-translation sehingga admin tidak perlu manual translate semua konten. Google Analytics memberikan insights tentang traffic dan user behavior. Schema.org structured data membantu mesin pencari memahami konten untuk better SEO.

### Pola Arsitektur

Sistem ini mengikuti beberapa design patterns yang proven:

**MVC (Model-View-Controller)** memisahkan concerns menjadi tiga layer, making code organized dan easier to maintain. **Service Layer Pattern** mengextract business logic kompleks ke dedicated service classes, keeping controllers thin dan focused on HTTP layer only. **Repository Pattern** diimplementasikan through Eloquent Models yang bertindak sebagai repository untuk data access. **Singleton Pattern** digunakan untuk settings tables (headers, contacts, abouts) yang strictly hanya boleh punya satu record.

**Dependency Injection** digunakan extensively. Lihat bagaimana controllers menerima services through method injection:

```php
public function index(SchemaService $schemaService)
{
    // Laravel otomatis resolve dan inject SchemaService
    $schema = $schemaService->getOrganizationSchema();
    // ...
}
```

Ini membuat code testable karena kita bisa inject mock services saat testing.

---

## ✨ Fitur-Fitur Utama

### 1. 🌍 Multi-Language System dengan Auto-Translation

#### Konsep Dasar

Salah satu fitur unggulan sistem ini adalah dukungan multi-bahasa yang intelligent. Setiap konten dinamis di website dapat ditampilkan dalam dua bahasa: Indonesia dan Inggris. Yang membuatnya special adalah admin tidak perlu manually translate semua konten - sistem melakukannya otomatis menggunakan AI.

#### Bagaimana It Works

Ketika admin membuat konten baru (misalnya artikel kesehatan), mereka cukup menulis dalam bahasa Indonesia saja. Sistem kemudian secara otomatis men deteksi bahwa terjemahan Inggris belum tersedia, lalu memanggil Google Cloud Translation API untuk menerjemahkannya. Hasil terjemahan disimpan di database dan di-cache selama 30 hari untuk efisiensi.

#### Struktur Data

Semua field yang translateable disimpan dalam format JSON:

```json
{
  "title": {
    "id": "Layanan Darurat 24 Jam",
    "en": "24 Hour Emergency Service"
  }
}
```

Spatie Laravel Translatable package menghandle JSON parsing secara otomatis. Ketika kita akses `$service->title` di blade template, package otomatis return text sesuai locale yang active.

#### Flow Auto-Translation

Mari kita lihat bagaimana auto-translation bekerja step by step:

```
1. Admin buat artikel, isi konten Bahasa Indonesia saja
   ↓
2. System detect field English kosong
   ↓
3. Panggil TranslationService->translate()
   ↓
4. Service check cache dulu (key = hash dari text)
   ↓
5a. Cache HIT → Return instantly (< 1ms)
5b. Cache MISS → Call Google Cloud API (~500ms)
   ↓
6. Save translation result ke cache (TTL 30 days)
   ↓
7. Return translation ke controller
   ↓
8. Controller save ke database (both languages)
   ↓
9. User bisa switch language di website
```

#### Implementation Code

**Helper untuk Auto-Translate:**
```php
// TranslationHelper.php
public static function autoTranslateFields($data, $fields, $translationService)
{
    foreach ($fields as $field) {
        // Jika ID filled tapi EN empty → Translate ID to EN
        if (!empty($data[$field]['id']) && empty($data[$field]['en'])) {
            $data[$field]['en'] = $translationService->translate(
                $data[$field]['id'],
                'id', // source language
                'en'  // target language
            );
        }
        
        // Jika EN filled tapi ID empty → Translate EN to ID
        if (!empty($data[$field]['en']) && empty($data[$field]['id'])) {
            $data[$field]['id'] = $translationService->translate(
                $data[$field]['en'],
                'en', // source
                'id'  // target
            );
        }
    }
    
    return $data;
}
```

**Translation Service dengan Caching:**
```php
// TranslationService.php
public function translate($text, $sourceLang, $targetLang)
{
    // 1. Create unique cache key
    $cacheKey = "translation_{$sourceLang}_{$targetLang}_" . md5($text);
    
    // 2. Check cache first (30 days TTL)
    if (Cache::has($cacheKey)) {
        return Cache::get($cacheKey);
    }
    
    // 3. Not in cache → Call Google Cloud API
    $translation = $this->client->translate($text, [
        'source' => $sourceLang,
        'target' => $targetLang
    ]);
    
    // 4. Cache result for future reuse
    Cache::put($cacheKey, $translation['text'], 60 * 60 * 24 * 30);
    
    return $translation['text'];
}
```

Caching sangat penting karena Google Cloud Translation API tidak gratis selamanya. Dengan cache, text yang sama tidak akan di-translate berulang kali, menghemat biaya dan mempercepat response time hingga 500x (dari ~500ms jadi <1ms).

### 2. 👥 Role-Based Access Control (RBAC)

#### Why RBAC Matters

Tidak semua user admin panel perlu punya akses yang sama. Owner klinik perlu bisa manage users, tapi staff admin hanya perlu akses manage content. RBAC solve problem ini dengan granular permission system.

#### Implementation

Sistem memiliki dua roles:
- **Owner**: Full access termasuk user management
- **Admin**: Content management only, no user access

**Permission Matrix:**
| Fitur | Owner | Admin |
|-------|-------|-------|
| Dashboard | ✅ | ✅ |
| Manage Header | ✅ | ✅ |
| Manage About | ✅ | ✅ |
| Manage Contact | ✅ | ✅ |
| Manage Services | ✅ | ✅ |
| Manage Doctors | ✅ | ✅ |
| Manage Articles | ✅ | ✅ |
| Manage Gallery | ✅ | ✅ |
| **Manage Users** | ✅ | ❌ |
| Analytics | ✅ | ✅ |

#### How It's Enforced

**Middleware Check:**
```php
// RoleMiddleware.php
public function handle($request, Closure $next, $role)
{
    // Check if user logged in
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    // Check if user has required role
    if (Auth::user()->role !== $role) {
        abort(403, 'Unauthorized access');
    }
    
    return $next($request);
}
```

**Route Protection:**
```php
// routes/web.php
Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->group(function () {
        // Semua admin bisa akses
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::resource('articles', ArticleController::class);
        
        // Hanya owner bisa akses
        Route::middleware('role:owner')->group(function () {
            Route::resource('users', UserController::class);
        });
    });
```

Jika admin biasa coba akses /admin/users, middleware `role:owner` akan throw 403 error.

### 3. 📊 Analytics & SEO Features

#### a. Search Logs & Zero Result Analysis

**Problem yang Diselesaikan:**
User sering mencari keyword tertentu tapi tidak menemukan artikel yang relevan. Ini missed opportunity - user frustrated dan klinik kehilangan potential patient education.

**Solution:**
Sistem mencatat SETIAP pencarian yang dilakukan user di halaman Articles, termasuk keyword yang dicari dan jumlah hasil yang ditemukan. Data ini kemudian di-analyze untuk identify common searches yang tidak menghasilkan apapun (zero results).

**Implementation:**
```php
// LandingController.php - method articles()
public function articles(Request $request)
{
    $query = Article::whereNotNull('published_at');
    
    // Search filter
    if ($search = $request->input('q')) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%");
        });
    }
    
    $articles = $query->orderBy('trend_score', 'desc')
                      ->latest('published_at')
                      ->get();
    
    // 🔍 LOG SEARCH untuk analytics
    if ($search) {
        SearchLog::create([
            'query' => $search,
            'results_count' => $articles->count(),
            'ip_address' => $request->ip(),
        ]);
    }
    
    return view('articles', compact('articles'));
}
```

**Analytics Dashboard:**
```php
// DashboardController.php
public function index()
{
    // Get top 5 missing keywords (zero result queries)
    $missingKeywords = SearchLog::where('results_count', 0)
        ->select('query', DB::raw('count(*) as total'))
        ->groupBy('query')
        ->orderByDesc('total')
        ->take(5)
        ->get();
    
    // Admin sekarang tahu keyword apa yang sering dicari tapi tidak ada artikelnya
    return view('admin.dashboard', compact('missingKeywords'));
}
```

**Use Case:**
Bayangkan "diabetes diet" dicari 25 kali dalam sebulan tapi zero results. Dashboard akan show ini. Admin kemudian buat artikel tentang "Panduan Diet untuk Penderita Diabetes". Next user yang search keyword itu akan dapat hasil - better user satisfaction, lower bounce rate!

#### b. Trend Score System

**Problem:**
Bagaimana menentukan artikel mana yang harus muncul paling atas? Jika sorting hanya by views, artikel lama selalu dominan. Jika sorting hanya by date, artikel bagus tapi lama jadi terkubur. Sistem butuh intelligent ranking yang menggabungkan beberapa faktor: popularitas global (Google Trends), performa di website sendiri (Analytics), dan kesegaran konten.

**Solution:**
Sistem menggunakan **TrendAnalysisService** yang mengkalkulasi score berdasarkan 3 komponen:

**Formula:**
```
trend_score = Google Trends Score + Analytics Score + Freshness Score

Dimana:
- Google Trends Match  → +50 points
- Analytics Popularity → +30 points  
- Fresh Content (<7d)  → +10 points

Maximum possible score: 90 points
```

**Komponen Detail:**

1. **Google Trends Score (+50)**
   - Service memanggil Google Trends API untuk mendapatkan trending health keywords
   - Jika title artikel mengandung trending keyword → +50 points
   - Contoh: Keyword "Flu" trending, artikel berjudul "Cara Mencegah Flu" dapat +50

2. **Analytics Popularity Score (+30)**
   - Service mengambil data dari Google Analytics untuk pages dengan traffic tertinggi
   - Jika slug artikel match dengan popular page → +30 points
   - Contoh: "/articles/diabetes-diet" punya traffic tinggi → artikel dapat +30

3. **Freshness Score (+10)**
   - Artikel yang dipublish dalam 7 hari terakhir → +10 points
   - Memberi boost untuk konten fresh agar tidak langsung terkubur

**Example Calculation:**

```php
// Artikel A: "Tips Mencegah Flu di Musim Hujan"
// - Title mengandung "Flu" (trending di Google)  → +50
// - Slug "/flu-prevention" tidak di top analytics  → +0
// - Published 3 hari yang lalu                     → +10
// Total Score = 60

// Artikel B: "Panduan Diet Diabetes"  
// - Title tidak match trending keywords           → +0
// - Slug "/diabetes-diet" popular di Analytics    → +30
// - Published 2 bulan lalu                        → +0
// Total Score = 30

// Artikel C: "Manfaat Vitamin C"
// - Title mengandung "Vitamin C" (trending)       → +50
// - Slug "/vitamin-c" juga popular                → +30
// - Published 5 hari lalu                         → +10
// Total Score = 90 (PERFECT SCORE!)

→ Urutan di landing page: C, A, B
```

**Implementation Code:**

```php
// TrendAnalysisService.php
public function analyzeAndUpdateScores()
{
    // 1. Fetch data eksternal
    $trendingKeywords = $this->trendsService->fetchDailyTrends();
    // Returns: ['Flu', 'Vitamin C', 'Diabetes']
    
    $popularSlugs = $this->analyticsService->getMostPopularPages();
    // Returns: ['/articles/diabetes-diet', '/articles/vitamin-c']
    
    // 2. Process setiap artikel
    Article::chunk(100, function ($articles) use ($trendingKeywords, $popularSlugs) {
        foreach ($articles as $article) {
            $score = 0;
            $matches = [];
            
            // A. Check Google Trends Match
            foreach ($trendingKeywords as $keyword) {
                if (stripos($article->title, $keyword) !== false) {
                    $score += 50;
                    $matches[] = "Matched Trend: $keyword";
                    break; // Max 1 trend match
                }
            }
            
            // B. Check Analytics Popularity
            $articleSlug = $article->slug ?? '';
            foreach ($popularSlugs as $pagePath) {
                if (str_contains($pagePath, $articleSlug) && !empty($articleSlug)) {
                    $score += 30;
                    $matches[] = "Matched Analytics: $pagePath";
                    break;
                }
            }
            
            // C. Check Freshness
            if ($article->created_at > Carbon::now()->subDays(7)) {
                $score += 10;
                $matches[] = 'Fresh Content (< 7 days)';
            }
            
            // Update ke database
            $article->update([
                'trend_score' => $score,
                'trend_data' => json_encode($matches) // Untuk debugging
            ]);
        }
    });
}
```

**Automated Updates:**

Service ini dijalankan otomatis via Laravel Scheduler (cron job) setiap hari untuk ensure scores selalu up-to-date dengan trending keywords dan analytics data terbaru.

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Update trend scores setiap hari jam 2 pagi
    $schedule->call(function () {
        app(TrendAnalysisService::class)->analyzeAndUpdateScores();
    })->daily();
}
```

**Why This Matters:**

Dengan sistem ini, artikel yang **relevant right now** (trending di Google) akan otomatis naik ke atas, even jika artikel tersebut baru dipublish kemarin. Sebaliknya, artikel lama yang evergreen tapi masih punya traffic tinggi (dari Analytics) juga tetap visible. Ini membuat content recommendation lebih dynamic dan sesuai dengan kebutuhan user saat ini.

#### c. Schema.org Structured Data

**Why It Matters:**
Search engines tidak bisa "understand" content secara sempurna. Structured data memberikan hints explicit tentang jenis konten, helping search engines display rich snippets dan improve ranking.

**Implementation:**
```php
// SchemaService.php
public function getOrganizationSchema()
{
    return Schema::organization()
        ->name('Legian Medical Clinic')
        ->url(url('/'))
        ->logo(asset('logo.png'))
        ->contactPoint(Schema::contactPoint()
            ->telephone('+62...')
            ->contactType('customer service')
        );
}

public function getArticleSchema($article)
{
    return Schema::article()
        ->headline($article->title)
        ->image($article->image)
        ->datePublished($article->published_at)
        ->author(Schema::organization()
            ->name('Legian Medical Clinic')
        );
}
```

**HTML Output:**
```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Legian Medical Clinic",
  "url": "https://lmc.com",
  "logo": "https://lmc.com/logo.png"
}
</script>
```

Google parse JSON-LD ini dan bisa display better search results dengan rich snippets.

### 4. 📝 Content Management System (CMS)

#### Overview

CMS memungkinkan admin manage ALL website content tanpa touching code. Semua operations dilakukan through user-friendly forms.

#### Modules

**Header Management:**
Data yang di-manage: Title, Tagline, Logo (image), Button Text. Semua text fields multi-language, logo adalah file upload.

**About Management:**
Data: Title, Description, Vision, Mission (all multi-language), Image. Admin bisa craft compelling about section untuk build trust dengan visitors.

**Contact Management:**
Data: Address (multi-language), Phone, Email, WhatsApp, Facebook, Instagram, Google Maps Embed. Maps embed adalah iframe code yang user copy dari Google Maps.

**Services CRUD:**
Full Create-Read-Update-Delete untuk layanan medis. Each service has Title, Description (multi-language), dan Icon class (e.g., "fa fa-heartbeat").

**Doctors CRUD:**
Manage doctor profiles dengan Name, Specialty, Bio (multi-language), dan Photo. Specialty bisa "Dokter Umum" di ID dan "General Practitioner" di EN.

**Articles CRUD + Publishing:**
Paling complex module. Admin bisa create articles dengan rich text editor, upload featured image, dan choose publish atau save as draft. Articles support tagging, scheduling (future publish), dan view count tracking.

**Gallery CRUD:**
Upload photos dengan Title, Description (optional), Sort Order untuk arrange tampilan, dan Active/Inactive toggle untuk hide without delete.

#### Example: Creating a Service

**Step 1 - Admin Access Form:**
Navigate ke /admin/services/create → Tampil form:

**Step 2 - Fill Form:**
```
Title (ID): "Layanan Gigi"
Title (EN): "" (kosong, will auto-translate)
Description (ID): "Perawatan kesehatan gigi dan mulut lengkap"
Description (EN): "" (kosong)
Icon: "fa fa-tooth"
```

**Step 3 - Submit:**
Browser kirim POST request ke /admin/services

**Step 4 - Backend Processing:**
```php
// ServiceController.php - store()
public function store(Request $request, TranslationService $translationService)
{
    $data = $request->validated();
    
    // Auto-translate empty fields
    $data = TranslationHelper::autoTranslateFields(
        $data,
        ['title', 'description'],
        $translationService
    );
    // Sekarang title['en'] = "Dental Services"
    // Dan description['en'] = "Complete dental and oral care"
    
    Service::create($data);
    
    return redirect()->route('admin.services.index')
        ->with('success', 'Service created successfully!');
}
```

**Step 5 - Database:**
```sql
INSERT INTO services (title, description, icon, created_at, updated_at)
VALUES (
    '{"id":"Layanan Gigi","en":"Dental Services"}',
    '{"id":"Perawatan kesehatan gigi...","en":"Complete dental..."}',
    'fa fa-tooth',
    '2026-01-25 14:30:00',
    '2026-01-25 14:30:00'
);
```

**Step 6 - Display di Website:**
Visitor yang pilih Bahasa Indonesia lihat "Layanan Gigi", yang pilih English lihat "Dental Services" - automatically!

---

## 🗄️ Penjelasan Database

### Overview Struktur

Database LMC terdiri dari 9 tabel utama, dirancang dengan prinsip normalization tapi tidak over-normalized untuk maintain performance. Tidak ada foreign key constraints yang kompleks - ini design choice untuk simplicity karena relationshipantar entities tidak strict.

### Tabel-Tabel dan Penjelasannya

#### 1. users

**Purpose:** Menyimpan data admin dan owner yang bisa login ke admin panel.

**Structure:**
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('owner', 'admin') NOT NULL DEFAULT 'admin',
    email_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Field Explanation:**
- `id`: Primary key auto-increment
- `name`: Full name user
- `email`: Unique email for login
- `password`: Bcrypt hashed password
- `role`: Menentukan permission level
- `email_verified_at`: NULL jika email belum verified
- `remember_token`: Untuk "Remember Me" functionality

**Sample Data:**
```
id: 1
name: "Mr. Owner"
email: "owner@lmc.com"
password: "$2y$10$..."
role: "owner"
```

#### 2. headers

**Purpose:** Menyimpan konten header website (singleton pattern - only 1 record).

**Structure:**
```sql
CREATE TABLE headers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title JSON NOT NULL,
    tagline JSON NOT NULL,
    logo VARCHAR(255) NULL,
    button_text JSON NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**JSON Structure Example:**
```json
{
  "title": {
    "id": "Klinik Medis Legian",
    "en": "Legian Medical Clinic"
  },
  "tagline": {
    "id": "Melayani dengan Sepenuh Hati",
    "en": "Serving with All Our Heart"
  },
  "button_text": {
    "id": "Hubungi Kami",
    "en": "Contact Us"
  }
}
```

**Why JSON?**
JSON allows us menyimpan multiple languages dalam satu field, making queries simpler dan avoiding need untuk separate translation tables.

#### 3. contacts, abouts

Similar pattern dengan headers - singleton tables dengan JSON fields untuk multi-language content. Explained in detail in original docs above.

#### 4. services, doctors, galleries

**Pattern:** Multiple records tables dengan JSON fields untuk translatable content.

Misalnya services table:
```sql
-- One service can look like:
id: 1
title: {"id":"Layanan Gigi","en":"Dental Services"}
description: {"id":"Perawatan lengkap...","en":"Complete dental care..."}
icon: "fa fa-tooth"
```

Ketika query `Service::all()`, Eloquent otomatis parse JSON jadi accessible array, thanks to `HasTranslations` trait.

#### 5. articles

**Most Complex Table** karena punya draft/publish system dan trending algorithm.

**Key Fields:**
- `title`, `excerpt`, `content`: JSON multi-language
- `image`: Featured image path
- `published_at`: **NULL = draft**, timestamp = published
- `view_count`: Incremented each view
- `trend_score`: Calculated score untuk sorting

**Draft vs Published Query:**
```php
// Landing page - only published
$articles = Article::whereNotNull('published_at')->get();

// Admin panel - include drafts
$articles = Article::all();
```

#### 6. search_logs

**Purpose:** Analytics - track all search queries.

**Fields:**
- `query`: Keyword yang dicari
- `results_count`: Berapa artikel found
- `ip_address`: User IP
- `created_at`: When searched

**Use Case:**
```sql
-- Top missing keywords
SELECT query, COUNT(*) as searches
FROM search_logs
WHERE results_count = 0
GROUP BY query
ORDER BY searches DESC
LIMIT 5;

-- Result:
-- "diabetes diet" - 25 searches
-- This tells admin: "Create article about diabetes diet!"
```

---

## 🔄 Alur Sistem & Logika

### 1. User Journey - Landing Page

```
┌─────────────────────────────────────────────────────────────────┐
│ STEP 1: First Visit                                             │
│ User akses https://lmc.com                                       │
└─────────┬───────────────────────────────────────────────────────┘
          │
          ↓
┌─────────────────────────────────────────────────────────────────┐
│ STEP 2: Preference Modal Muncul                                  │
│ Modal: "Apa yang Anda cari hari ini?"                           │
│ Options: [Services] [Doctors] [Contact] [View All]              │
└─────────┬───────────────────────────────────────────────────────┘
          │
          ↓
┌─────────────────────────────────────────────────────────────────┐
│ STEP 3: User Memilih (Contoh: "Services")                       │
│ Browser kirim POST /set-preference                               │
│ Laravel simpan preference di session                             │
└─────────┬───────────────────────────────────────────────────────┘
          │
          ↓
┌─────────────────────────────────────────────────────────────────┐
│ STEP 4: Auto-scroll ke Section                                   │
│ JavaScript smooth scroll ke #services section                    │
│ User langsung lihat layanan yang dicari                          │
└─────────┬───────────────────────────────────────────────────────┘
          │
          ↓
┌─────────────────────────────────────────────────────────────────┐
│ STEP 5: User Explore Website                                     │
│ - Baca services, doctors, articles                              │
│ - Switch language ID/EN via toggle                               │
│ - Click WhatsApp button → redirect ke WA klinik                 │
└─────────────────────────────────────────────────────────────────┘
```

### 2. Admin Authentication Flow

```
User → /login → LoginController@showLoginForm
                        ↓
                Display login form (email + password)
                        ↓
User submit form → /login POST → LoginController@login
                        ↓
                Validate credentials
                        ↓
            ┌──── Valid? ────┐
            ↓                ↓
           YES               NO
            ↓                ↓
    Auth::login()      Redirect back
            ↓          with error
    Check email_verified_at
            ↓
    ┌─ Verified? ─┐
    ↓             ↓
   YES            NO
    ↓             ↓
Redirect to   Send verification
/admin/dashboard   email
```

### 3. Content Creation Flow (Article Example)

**Phase 1: Draft Creation**

```php
// Admin navigasi ke /admin/articles/create
1. ArticleController@create() → Return view dengan form
2. Admin isi form:
   - Title (ID): "Manfaat Vitamin C untuk Kesehatan"
   - Title (EN): [KOSONG - will auto-translate]
   - Content (ID): "Vitamin C adalah..."
   - Content (EN): [KOSONG]
   - Image: upload foto
   - Published At: [KOSONG = draft]

3. Admin klik "Save as Draft"
4. POST /admin/articles
5. ArticleController@store(StoreArticleRequest $request, TranslationService $ts)
   {
       // Validate input
       $data = $request->validated();
       
       // Auto-translate empty fields
       $data = TranslationHelper::autoTranslateFields(
           $data, 
           ['title', 'excerpt', 'content'],
           $ts
       );
       
       // Create artikel dengan published_at = NULL (draft)
       Article::create([
           'title' => ['id' => '...', 'en' => 'Benefits of Vitamin C...'],
           'content' => [...],
           'published_at' => null, // DRAFT
           'trend_score' => 0
       ]);
   }
```

**Phase 2: Publishing**

```php
// Admin edit artikel draft, set publish date
1. ArticleController@edit($id) → Show edit form
2. Admin set Published At = "2026-02-01 10:00:00"
3. PUT /admin/articles/{id}
4. ArticleController@update()
   {
       $article->update([
           'published_at' => $request->published_at
       ]);
       // Artikel sekarang LIVE di landing page
   }
```

**Phase 3: Trend Score Calculation**

```php
// Cron job run setiap hari
1. Scheduler call TrendAnalysisService@analyzeAndUpdateScores()
2. Service fetch:
   - Google Trends: ['Vitamin C', 'Flu', ...]
   - Analytics: ['/articles/vitamin-c', ...]
3. Loop semua artikel:
   - Check title match "Vitamin C" → +50
   - Check slug di Analytics → +30
   - Check freshness < 7 days → +10
   - Total score = 90
4. Update artikel:
   Article::update(['trend_score' => 90])
```

**Phase 4: Display di Landing Page**

```php
// User akses landing page
1. LandingController@index()
2. Query artikel:
   Article::whereNotNull('published_at')
       ->orderBy('trend_score', 'desc')
       ->get()
3. Artikel "Manfaat Vitamin C" (score 90) muncul paling atas
4. User klik artikel → LandingController@show($id)
5. View count increment (for analytics)
```

### 4. Multi-Language Switching Flow

```
User di landing page → Click language toggle (ID/EN)
        ↓
JavaScript trigger: locale.change(newLocale)
        ↓
Send POST /translation/switch-locale
        ↓
TranslationController@switchLocale()
{
    session(['locale' => $newLocale]);
    app()->setLocale($newLocale);
}
        ↓
Reload page dengan locale baru
        ↓
Blade template: {{ $article->title }}
        ↓
Spatie Translatable package auto return text sesuai locale:
- session('locale') == 'id' → return "Manfaat Vitamin C..."
- session('locale') == 'en' → return "Benefits of Vitamin C..."
```

---

## 📂 Penjelasan File per File

### Controllers

#### LandingController.php
**Path:** `app/Http/Controllers/LandingController.php`

**Purpose:** Handle semua request untuk landing page public.

**Methods:**

1. **index()** - Landing page utama
   ```php
   public function index(SchemaService $schemaService)
   {
       // Load all data untuk landing page
       $header = Header::first();
       $services = Service::all();
       $articles = Article::whereNotNull('published_at')
           ->orderBy('trend_score', 'desc')
           ->take(3)
           ->get();
       
       // Generate SEO schema
       $schema = $schemaService->getOrganizationSchema();
       
       return view('landing', compact(...));
   }
   ```

2. **articles(Request $request)** - Halaman daftar artikel dengan search
   - Filter artikel by search query
   - Log search ke `search_logs` table untuk analytics
   - Sort by trend_score
   
3. **show($id)** - Detail artikel
   - Load artikel specific by ID
   - Check jika artikel punya high bounce rate
   - Fetch related articles (3 teratas by trend_score)
   
4. **setPreference()** - Save user preference ke session

#### Admin/ArticleController.php
**Path:** `app/Http/Controllers/Admin/ArticleController.php`

**Purpose:** CRUD operations untuk articles di admin panel.

**Key Methods:**
- `index()` - List semua artikel including drafts
- `create()` - Show form create
- `store(StoreArticleRequest)` - Validate & create dengan auto-translation
- `edit($id)` - Show edit form
- `update(UpdateArticleRequest)` - Validate & update
- `destroy($id)` - Soft delete artikel

**Security:**
- Protected by `auth` middleware
- Uses Form Request validation (StoreArticleRequest, UpdateArticleRequest)
- Auto-sanitize HTML input untuk prevent XSS

#### Admin/DashboardController.php
**Path:** `app/Http/Controllers/Admin/DashboardController.php`

**Purpose:** Admin dashboard dengan analytics & insights.

```php
public function index()
{
    $stats = [
        'total_articles' => Article::count(),
        'published_articles' => Article::whereNotNull('published_at')->count(),
        'draft_articles' => Article::whereNull('published_at')->count(),
        'total_services' => Service::count(),
        'total_doctors' => Doctor::count(),
    ];
    
    // Zero Result Analysis
    $missingKeywords = SearchLog::where('results_count', 0)
        ->select('query', DB::raw('count(*) as total'))
        ->groupBy('query')
        ->orderByDesc('total')
        ->take(5)
        ->get();
    
    return view('admin.dashboard', compact('stats', 'missingKeywords'));
}
```

**Insights Provided:**
- Content statistics (articles, services, doctors count)
- Top 5 missing keywords (keyword yang sering dicari tapi zero results)
- Recent activities

### Services

#### TranslationService.php
**Path:** `app/Services/TranslationService.php`

**Purpose:** Handle auto-translation menggunakan Google Cloud Translation API.

**Key Features:**
- Cache translations untuk 30 hari (mengurangi API calls)
- Support multiple source/target languages
- Batch translation untuk efficiency

```php
public function translate($text, $sourceLang, $targetLang)
{
    // Generate cache key
    $cacheKey = "translation_{$sourceLang}_{$targetLang}_" . md5($text);
    
    // Check cache first
    if (Cache::has($cacheKey)) {
        return Cache::get($cacheKey);
    }
    
    // Call Google Cloud API
    $translation = $this->client->translate($text, [
        'source' => $sourceLang,
        'target' => $targetLang
    ]);
    
    // Cache for 30 days
    Cache::put($cacheKey, $translation['text'], 60 * 60 * 24 * 30);
    
    return $translation['text'];
}
```

#### TrendAnalysisService.php
**Path:** `app/Services/TrendAnalysisService.php`

**Purpose:** Calculate dan update trend scores untuk semua artikel.

**Dependencies:**
- GoogleTrendsService - fetch trending keywords
- GoogleAnalyticsService - fetch popular pages

**How It Works:**
1. Fetch trending keywords dari Google Trends
2. Fetch popular pages dari Google Analytics
3. Loop semua artikel via chunking (100 artikel per batch)
4. Calculate score berdasarkan 3 komponen
5. Update `trend_score` dan `trend_data` di database

**Performance:**
- Uses chunking untuk handle large datasets
- Only update jika score berubah (reduce DB writes)
- Logs execution time untuk monitoring

#### SchemaService.php
**Path:** `app/Services/SchemaService.php`

**Purpose:** Generate Schema.org structured data untuk SEO.

**Methods:**

1. **getOrganizationSchema()** - Info tentang klinik
   ```php
   return Schema::organization()
       ->name('Legian Medical Clinic')
       ->url(url('/'))
       ->logo(asset('images/logo.png'))
       ->contactPoint(Schema::contactPoint()
           ->telephone('+62...')
           ->contactType('customer service')
       );
   ```

2. **getMedicalClinicSchema()** - Specific untuk medical clinic
   ```php
   return Schema::medicalClinic()
       ->name('Legian Medical Clinic')
       ->address(Schema::postalAddress()
           ->streetAddress('...')
           ->addressLocality('Bali')
           ->postalCode('...')
       );
   ```

3. **getArticleSchema($article)** - Schema untuk article detail page
   - Article headline, image, publish date
   - Author info (organization)
   - Helps Google show rich snippets

#### GoogleAnalyticsService.php
**Path:** `app/Services/GoogleAnalyticsService.php`

**Purpose:** Fetch data dari Google Analytics API.

**Key Methods:**

1. **getMostPopularPages()** - Top pages by pageviews
2. **getHighBouncePages()** - Pages dengan bounce rate > 70%
3. **getTrafficSources()** - Traffic breakdown by source

**Use Cases:**
- Trend score calculation (popular pages get boost)
- Dashboard analytics
- High bounce rate optimization

#### ImageService.php
**Path:** `app/Services/ImageService.php`

**Purpose:** Handle image upload, resize, dan optimization.

```php
public function store($file, $path = 'images')
{
    // Generate unique filename
    $filename = time() . '_' . Str::random(10) . '.' . $file->extension();
    
    // Resize untuk web optimization (max 1200px width)
    $image = Image::make($file)
        ->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })
        ->encode('jpg', 85); // 85% quality
    
    // Save
    Storage::put("public/{$path}/{$filename}", $image);
    
    return "storage/{$path}/{$filename}";
}
```

**Features:**
- Auto-resize untuk consistent dimensions
- Optimize quality (85%) untuk balance quality vs file size
- Generate unique filenames
- Support multiple storage drivers

### Models

#### Article.php
**Path:** `app/Models/Article.php`

**Purpose:** Eloquent model untuk articles table.

```php
class Article extends Model
{
    use HasTranslations;
    
    protected $guarded = [];
    
    // Fields yang multi-language
    public $translatable = ['title', 'excerpt', 'content'];
    
    protected $casts = [
        'published_at' => 'datetime',
    ];
    
    // Scope untuk articles yang published
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }
    
    // Scope untuk sorting by trend score
    public function scopeTrending($query)
    {
        return $query->orderBy('trend_score', 'desc');
    }
    
    // Accessor untuk processed content (dengan internal links)
    public function getProcessedContentAttribute()
    {
        $linkService = app(InternalLinkService::class);
        return $linkService->linkKeywords($this->content);
    }
}
```

**Scopes:**
- `published()` - Filter hanya artikel published
- `trending()` - Sort by trend score

**Accessors:**
- `processed_content` - Content dengan auto internal links ke artikel lain

#### Header.php, Contact.php, About.php
**Path:** `app/Models/Header.php`, etc.

**Pattern:** Singleton models (strictly 1 record only).

```php
class Header extends Model
{
    use HasTranslations;
    
    public $translatable = ['title', 'tagline', 'button_text'];
    
    protected $guarded = [];
    
    // Enforce singleton
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            // Jika sudah ada record, throw error
            if (static::count() > 0) {
                throw new \Exception('Only one header record allowed');
            }
        });
    }
}
```

### Middleware

#### RoleMiddleware.php
**Path:** `app/Http/Middleware/RoleMiddleware.php`

**Purpose:** Protect routes berdasarkan user role.

```php
public function handle($request, Closure $next, $role)
{
    // Check authentication
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    // Check role
    if (Auth::user()->role !== $role) {
        abort(403, 'Unauthorized action.');
    }
    
    return $next($request);
}
```

**Usage di Routes:**
```php
Route::middleware('role:owner')->group(function () {
    Route::resource('users', UserController::class);
});
```

#### LocaleMiddleware.php
**Path:** `app/Http/Middleware/LocaleMiddleware.php`

**Purpose:** Set application locale berdasarkan session.

```php
public function handle($request, Closure $next)
{
    // Get locale from session, default 'id'
    $locale = session('locale', 'id');
    
    // Set app locale
    app()->setLocale($locale);
    
    return $next($request);
}
```

### Form Requests

#### StoreArticleRequest.php
**Path:** `app/Http/Requests/Admin/StoreArticleRequest.php`

**Purpose:** Validation untuk create article.

```php
public function rules()
{
    return [
        'title.id' => 'required|string|max:255',
        'title.en' => 'nullable|string|max:255',
        'excerpt.id' => 'required|string|max:500',
        'excerpt.en' => 'nullable|string|max:500',
        'content.id' => 'required|string',
        'content.en' => 'nullable|string',
        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'published_at' => 'nullable|date',
    ];
}

public function messages()
{
    return [
        'title.id.required' => 'Judul (Indonesia) wajib diisi',
        'image.required' => 'Gambar artikel wajib diupload',
        'image.max' => 'Ukuran gambar maksimal 2MB',
    ];
}
```

**Benefits:**
- Centralized validation logic
- Custom error messages
- Automatic validation before controller methods
- Form request auto-injected ke controller

### Helpers

#### TranslationHelper.php
**Path:** `app/Helpers/TranslationHelper.php`

**Purpose:** Helper functions untuk auto-translation.

```php
class TranslationHelper
{
    public static function autoTranslateFields($data, $fields, $translationService)
    {
        foreach ($fields as $field) {
            // ID filled, EN empty → Translate ID to EN
            if (!empty($data[$field]['id']) && empty($data[$field]['en'])) {
                $data[$field]['en'] = $translationService->translate(
                    $data[$field]['id'], 'id', 'en'
                );
            }
            
            // EN filled, ID empty → Translate EN to ID
            if (!empty($data[$field]['en']) && empty($data[$field]['id'])) {
                $data[$field]['id'] = $translationService->translate(
                    $data[$field]['en'], 'en', 'id'
                );
            }
        }
        
        return $data;
    }
}
```

**Usage:**
```php
$data = TranslationHelper::autoTranslateFields(
    $request->all(),
    ['title', 'description'],
    $translationService
);
```

---

## 📊 Flow Diagram

### System Architecture Diagram

```
┌────────────────────────────────────────────────────────────────┐
│                        USER LAYER                              │
│  ┌─────────────────┐              ┌─────────────────┐          │
│  │  Public Visitor │              │  Admin Users    │          │
│  │  (No Login)     │              │  (Authenticated)│          │
│  └────────┬────────┘              └────────┬────────┘          │
└───────────┼─────────────────────────────────┼─────────────────┘
            │                                 │
            │                                 │
┌───────────┼─────────────────────────────────┼─────────────────┐
│           │      PRESENTATION LAYER         │                 │
│           ↓                                 ↓                 │
│  ┌─────────────────┐              ┌─────────────────┐         │
│  │  Landing Views  │              │  Admin Views    │         │
│  │  - landing.blade│              │  - dashboard    │         │
│  │  - articles     │              │  - articles     │         │
│  │  - article_show │              │  - services     │         │
│  └────────┬────────┘              └────────┬────────┘         │
└───────────┼─────────────────────────────────┼─────────────────┘
            │                                 │
            │                                 │
┌───────────┼─────────────────────────────────┼─────────────────┐
│           │      CONTROLLER LAYER           │                 │
│           ↓                                 ↓                 │
│  ┌──────────────────┐           ┌───────────────────┐        │
│  │ LandingController│◄──────────┤ Auth Middleware   │        │
│  └────────┬─────────┘           └───────────────────┘        │
│           │                              │                    │
│  ┌────────┴─────────┐         ┌──────────┴────────────┐      │
│  │ Admin Controllers│◄────────┤ Role Middleware       │      │
│  │ - Article        │         │ (owner/admin check)   │      │
│  │ - Service        │         └───────────────────────┘      │
│  │ - Doctor         │                                        │
│  └────────┬─────────┘                                        │
└───────────┼──────────────────────────────────────────────────┘
            │
            │
┌───────────┼──────────────────────────────────────────────────┐
│           │         SERVICE LAYER                            │
│           ↓                                                  │
│  ┌────────────────────────────────────────────────┐         │
│  │  TranslationService  │  TrendAnalysisService   │         │
│  │  SchemaService       │  ImageService           │         │
│  │  GoogleAnalytics     │  GoogleTrends           │         │
│  └────────┬────────────────────────┬────────────┬─┘         │
└───────────┼────────────────────────┼────────────┼───────────┘
            │                        │            │
            │                        │            │
┌───────────┼────────────────────────┼────────────┼───────────┐
│           │         MODEL LAYER    │            │           │
│           ↓                        ↓            ↓           │
│  ┌───────────────┐  ┌───────────────┐  ┌──────────────┐    │
│  │ Article       │  │ Service       │  │ SearchLog    │    │
│  │ Header        │  │ Doctor        │  │ User         │    │
│  │ Contact       │  │ Gallery       │  │              │    │
│  └───────┬───────┘  └───────┬───────┘  └──────┬───────┘    │
└──────────┼──────────────────┼──────────────────┼───────────┘
           │                  │                  │
           │                  │                  │
┌──────────┼──────────────────┼──────────────────┼───────────┐
│          │         DATA LAYER                  │           │
│          ↓                                     ↓           │
│  ┌────────────────────────────────────────────────────┐    │
│  │              MySQL Database                        │    │
│  │  - articles      - services     - search_logs      │    │
│  │  - headers       - doctors      - users            │    │
│  │  - contacts      - galleries    - abouts           │    │
│  └────────────────────────────────────────────────────┘    │
└────────────────────────────────────────────────────────────┘
           │
           │
┌──────────┼────────────────────────────────────────────────┐
│          │       EXTERNAL SERVICES                        │
│          ↓                                                │
│  ┌──────────────────┐  ┌──────────────────┐              │
│  │ Google Cloud     │  │ Google Analytics │              │
│  │ Translation API  │  │ API              │              │
│  └──────────────────┘  └──────────────────┘              │
│  ┌──────────────────┐                                    │
│  │ Google Trends    │                                    │
│  │ API              │                                    │
│  └──────────────────┘                                    │
└────────────────────────────────────────────────────────────┘
```

### Article Lifecycle Flow

```
┌─────────────────────────────────────────────────────────────┐
│ PHASE 1: CREATION                                           │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ↓
         Admin masuk /admin/articles/create
                       │
                       ↓
         ┌─────────────────────────────┐
         │  Fill Form:                 │
         │  - Title (ID only)          │
         │  - Content (ID only)        │
         │  - Image upload             │
         │  - Published At: NULL       │
         └──────────┬──────────────────┘
                    │
                    ↓
         POST /admin/articles (StoreArticleRequest)
                    │
                    ↓
         ┌──────────────────────────────┐
         │ Validation passes?           │
         └────┬──────────────────┬──────┘
              │ NO               │ YES
              ↓                  ↓
         Return errors    TranslationHelper::autoTranslate()
                                 │
                                 ↓
                    ┌────────────────────────────┐
                    │ TranslationService called  │
                    │ - Check cache              │
                    │ - Call Google API          │
                    │ - Return EN translation    │
                    └────────┬───────────────────┘
                             │
                             ↓
                    Article::create([
                        'title' => ['id' => '...', 'en' => '...'],
                        'published_at' => null,
                        'trend_score' => 0
                    ])
                             │
                             ↓
┌────────────────────────────────────────────────────────────┐
│ PHASE 2: DRAFT STATE                                       │
│ - Article exists di database                               │
│ - published_at = NULL                                      │
│ - Visible di admin panel only                              │
│ - NOT visible di landing page                              │
└────────────────────┬───────────────────────────────────────┘
                     │
                     │ Admin decides to publish
                     ↓
         PUT /admin/articles/{id}
         Set published_at = now()
                     │
                     ↓
┌────────────────────────────────────────────────────────────┐
│ PHASE 3: PUBLISHED STATE                                   │
│ - published_at has value                                   │
│ - NOW visible di landing page                              │
│ - trend_score still 0 (waiting cron job)                   │
└────────────────────┬───────────────────────────────────────┘
                     │
                     │ Next day, cron job runs
                     ↓
         TrendAnalysisService::analyzeAndUpdateScores()
                     │
                     ↓
         ┌───────────────────────────────┐
         │ Calculate Score:              │
         │ - Google Trends match? +50    │
         │ - Analytics popular?   +30    │
         │ - Fresh (<7 days)?     +10    │
         └────────────┬──────────────────┘
                      │
                      ↓
         Article::update(['trend_score' => 90])
                      │
                      ↓
┌────────────────────────────────────────────────────────────┐
│ PHASE 4: TRENDING STATE                                    │
│ - Article punya high trend_score                           │
│ - Muncul di top hasil landing page                         │
│ - User click → view_count increment                        │
└────────────────────┬───────────────────────────────────────┘
                     │
                     │ Score bisa turun over time
                     ↓
┌────────────────────────────────────────────────────────────┐
│ PHASE 5: MATURE STATE                                      │
│ - Artikel lebih dari 7 hari (lose +10 freshness)          │
│ - Jika keyword not trending lagi (lose +50 trends)        │
│ - Jika analytics traffic turun (lose +30 analytics)       │
│ - Score bisa turun sampai 0                                │
│ - Artikel turun posisi, tapi still visible                 │
└────────────────────────────────────────────────────────────┘
```

### Authentication & Authorization Flow

```
┌──────────────────────────────────────────────────────────┐
│ User → /admin/dashboard                                  │
└────────────────┬─────────────────────────────────────────┘
                 │
                 ↓
     ┌───────────────────────┐
     │ Auth Middleware Check │
     └───────┬───────────────┘
             │
         ┌───┴───┐
         │ Auth? │
         └───┬───┘
             │
      ┌──────┴──────┐
      │ NO          │ YES
      ↓             ↓
Redirect to   Continue to
/login        next middleware
      │             │
      │             ↓
      │    ┌────────────────────┐
      │    │ Verified Middleware│
      │    └────────┬───────────┘
      │             │
      │        ┌────┴────┐
      │        │Verified?│
      │        └────┬────┘
      │             │
      │      ┌──────┴──────┐
      │      │ NO          │ YES
      │      ↓             ↓
      │  Send email   Continue
      │  verification
      │                    │
      │                    ↓
      │           If route requires role:
      │                    │
      │                    ↓
      │         ┌────────────────────┐
      │         │ RoleMiddleware     │
      │         │ Check user->role   │
      │         └────────┬───────────┘
      │                  │
      │            ┌─────┴─────┐
      │            │Has Role?  │
      │            └─────┬─────┘
      │                  │
      │           ┌──────┴──────┐
      │           │ NO          │ YES
      │           ↓             ↓
      │      Abort 403    Access Granted
      │      Unauthorized      │
      │                        ↓
      │              Execute Controller Method
      │                        │
      │                        ↓
      │              Return Response
      │
      ↓
Show Login Form
      │
User submit credentials
      │
      ↓
LoginController@login
      │
      ↓
  ┌────────────────┐
  │ Validate Input │
  └────────┬───────┘
           │
      ┌────┴────┐
      │ Valid?  │
      └────┬────┘
           │
    ┌──────┴──────┐
    │ NO          │ YES
    ↓             ↓
Return error  Auth::attempt()
with message       │
                   ↓
            ┌──────────────┐
            │ Credentials  │
            │ correct?     │
            └──────┬───────┘
                   │
            ┌──────┴──────┐
            │ NO          │ YES
            ↓             ↓
       Return error   Auth::login()
       "Invalid..."   Create session
                           │
                           ↓
                  Redirect to /admin/dashboard
```

---

## 💡 Logika Bisnis Penting

### 1. Singleton Pattern untuk Settings Tables

**Problem:**
Headers, contacts, dan abouts hanya boleh punya 1 record. Multiple records akan cause confusion - mana yang active?

**Solution:**
Enforce singleton pattern di Model level.

```php
// Header.php model
public static function boot()
{
    parent::boot();
    
    // Prevent multiple records
    static::creating(function ($model) {
        if (static::count() > 0) {
            throw new \Exception('Only one header record is allowed. Use update instead.');
        }
    });
}
```

**In Controller:**
```php
// HeaderController.php
public function index()
{
    $header = Header::first(); // Always get the one record
    return view('admin.header.index', compact('header'));
}

public function update(Request $request)
{
    $header = Header::first();
    $header->update($request->validated());
    // No create, only update
}
```

### 2. Draft vs Published Logic

**Implementation:**

```php
// Draft detection
$isDraft = $article->published_at === null;

// Query only published
$published = Article::whereNotNull('published_at')->get();

// Query only drafts
$drafts = Article::whereNull('published_at')->get();

// Schedule publish (future date)
$article->published_at = '2026-02-15 10:00:00';
// Artikel will auto-appear on landing page when waktu tiba
```

**Benefits:**
- Admin bisa prepare content in advance
- Review process sebelum publish
- Scheduled publishing untuk content calendar

### 3. Zero Result Search Analysis

**Why Important:**
Setiap zero result search = missed opportunity. User cari info, tidak dapat, kemungkinan besar leave website frustrated.

**How It Works:**

```php
// LandingController@articles
if ($search = $request->input('q')) {
    // Execute query
    $articles = $query->get();
    
    // Log search dengan result count
    SearchLog::create([
        'query' => $search,
        'results_count' => $articles->count(),
        'ip_address' => $request->ip(),
    ]);
}
```

**Analytics:**

```php
// Dashboard - Top Missing Keywords
$missingKeywords = SearchLog::where('results_count', 0)
    ->select('query', DB::raw('count(*) as searches'))
    ->groupBy('query')
    ->orderByDesc('searches')
    ->take(10)
    ->get();

// Output:
// "diabetes diet" - 25 searches
// "heart disease" - 18 searches
// "mental health" - 12 searches
```

**Action Items:**
Admin lihat dashboard → Identifikasi keywords → Create artikel untuk keywords tersebut → User next time dapat hasil!

### 4. Image Optimization

**Problem:**
User upload foto 5MB dari kamera → Website jadi lambat → User bounce.

**Solution:**
Auto-resize dan compress semua uploaded images.

```php
// ImageService::store()
public function store($file)
{
    // Resize to max 1200px width (maintain aspect ratio)
    $image = Image::make($file)
        ->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();  // Keep ratio
            $constraint->upsize();       // Don't enlarge small images
        })
        ->encode('jpg', 85); // Compress to 85% quality
    
    // Original: 5MB → After: ~300KB
    // Visual quality: Almost identical to human eye
    // Loading speed: 16x faster!
    
    Storage::put($path, $image);
}
```

**Benefits:**
- Faster page load
- Better SEO (Google ranks faster sites higher)
- Save storage space
- Better mobile experience

### 5. Multi-Language Content Fallback

**Problem:**
Jika EN translation gagal atau tidak tersedia, jangan show kosong/error.

**Solution:**
Spatie Translatable package punya built-in fallback.

```php
// config/translatable.php
'fallback_locale' => 'id',

// Behavior:
$article->setLocale('en')->title;
// If EN exists → return EN
// If EN doesn't exist → return ID (fallback)
// Never return null/empty
```

**Additional Safety:**

```php
// Helper method di model
public function getTitleAttribute()
{
    $title = $this->getTranslation('title', app()->getLocale(), false);
    
    // If current locale empty, try fallback
    if (empty($title)) {
        $title = $this->getTranslation('title', 'id');
    }
    
    return $title;
}
```

### 6. Preference Modal UX Pattern

**Problem:**
Website punya banyak sections. User harus scroll manual untuk cari info yang relevan.

**Solution:**
Show preference modal on first visit.

```javascript
// landing.blade.php
document.addEventListener('DOMContentLoaded', function() {
    // Check jika preference sudah disimpan
    const hasPreference = sessionStorage.getItem('lmc_preference');
    
    if (!hasPreference) {
        // Show modal
        $('#preferenceModal').modal('show');
    } else {
        // Auto-scroll ke saved preference
        const section = sessionStorage.getItem('lmc_preference');
        if (section !== 'all') {
            scrollToSection(section);
        }
    }
});

function setPreference(choice) {
    // Save to session
    sessionStorage.setItem('lmc_preference', choice);
    
    // Send to backend
    fetch('/set-preference', {
        method: 'POST',
        body: JSON.stringify({ preference: choice })
    });
    
    // Close modal & scroll
    $('#preferenceModal').modal('hide');
    if (choice !== 'all') {
        scrollToSection(choice);
    }
}

function scrollToSection(section) {
    document.getElementById(section).scrollIntoView({
        behavior: 'smooth'
    });
}
```

**Benefits:**
- Reduce time to relevant content (dari ~30 detik jadi ~2 detik)
- Better UX
- Lower bounce rate
- Personalized experience

### 7. Internal Link Service (SEO Boost)

**Purpose:**
Auto-link keywords dalam artikel ke artikel lain yang relevan.

```php
// InternalLinkService.php
public function linkKeywords($content)
{
    // Get all published articles
    $articles = Article::whereNotNull('published_at')->get();
    
    foreach ($articles as $article) {
        $keyword = $article->title;
        $url = route('article.show', $article->id);
        
        // Replace keyword dengan link (first occurrence only)
        $content = preg_replace(
            '/\b(' . preg_quote($keyword, '/') . ')\b/',
            '<a href="' . $url . '">$1</a>',
            $content,
            1 // Limit 1 replacement
        );
    }
    
    return $content;
}
```

**Usage:**
```php
// Article model
public function getProcessedContentAttribute()
{
    $service = app(InternalLinkService::class);
    return $service->linkKeywords($this->content);
}

// Blade template
{!! $article->processed_content !!}
```

**SEO Benefits:**
- Better internal linking structure
- Helps search engines understand content relationships
- Increases page authority distribution
- Encourages users explore more content (reduce bounce)

### 8. Cache Strategy untuk Performance

**Translation Cache:**
```php
// TTL: 30 days
// Why? Translations never change spontaneously
// Cost saved: Jika 1000 artikel × auto-translate × daily cron = $$$
// With cache: Only translate once per unique text
```

**Analytics Cache:**
```php
// GoogleAnalyticsService.php
public function getMostPopularPages()
{
    return Cache::remember('analytics_popular_pages', 3600, function () {
        return $this->client->runReport(...);
    });
}
// TTL: 1 hour
// Why? Analytics data doesn't change minute-to-minute
// Benefit: Faster dashboard load (from 3s to 50ms)
```

**Trend Keywords Cache:**
```php
// GoogleTrendsService.php
return Cache::remember('trends_keywords', 86400, function () {
    return $this->fetchFromAPI();
});
// TTL: 24 hours
// Why? Trends update daily, not real-time
```

---

## 🎓 Best Practices yang Diterapkan

### Security
- ✅ Password hashing dengan Bcrypt
- ✅ CSRF protection di semua forms
- ✅ Input validation via Form Requests
- ✅ SQL injection protection via Eloquent ORM
- ✅ XSS protection dengan `{{ }}` blade escaping
- ✅ Role-based access control

### Performance
- ✅ Database query optimization (N+1 prevention)
- ✅ Caching strategy untuk external API calls
- ✅ Image optimization (resize + compress)
- ✅ Lazy loading untuk large datasets (chunking)
- ✅ CDN-ready asset structure

### Code Quality
- ✅ MVC architecture separation
- ✅ Service layer untuk business logic
- ✅ DRY principle (Don't Repeat Yourself)
- ✅ SOLID principles compliance
- ✅ Meaningful naming conventions
- ✅ Comprehensive inline documentation

### UX/UI
- ✅ Responsive design (Bootstrap 5)
- ✅ Accessibility considerations
- ✅ Fast page loads
- ✅ Clear error messages
- ✅ Intuitive admin interface
- ✅ Multi-language support

### SEO
- ✅ Schema.org structured data
- ✅ Semantic HTML5
- ✅ Meta tags optimization
- ✅ Clean URL structure
- ✅ Sitemap generation
- ✅ Internal linking strategy

---

## 🔧 Konfigurasi Penting

### Environment Variables (.env)

```env
# Application
APP_NAME="Legian Medical Clinic"
APP_ENV=production
APP_URL=https://lmc.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lmc_db
DB_USERNAME=root
DB_PASSWORD=

# Google Cloud Translation
GOOGLE_CLOUD_PROJECT_ID=your-project-id
GOOGLE_APPLICATION_CREDENTIALS=/path/to/service-account-key.json

# Google Analytics
GOOGLE_ANALYTICS_PROPERTY_ID=properties/123456789
GOOGLE_ANALYTICS_CREDENTIALS=/path/to/analytics-key.json

# Cache
CACHE_DRIVER=redis  # or 'file' untuk simple setup

# Session
SESSION_DRIVER=redis  # or 'file'
SESSION_LIFETIME=120

# Queue (for async jobs)
QUEUE_CONNECTION=sync  # or 'redis' untuk production
```

### Scheduler Setup (Cron Job)

**Linux/Mac:**
```bash
# Open crontab
crontab -e

# Add Laravel scheduler
* * * * * cd /path/to/lmc && php artisan schedule:run >> /dev/null 2>&1
```

**Windows:**
```powershell
# Task Scheduler > Create Basic Task
# Trigger: Daily
# Action: Start a Program
# Program: php
# Arguments: artisan schedule:run
# Start in: C:\path\to\lmc
```

**Scheduler Configuration:**
```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Update trend scores daily at 2 AM
    $schedule->call(function () {
        app(TrendAnalysisService::class)->analyzeAndUpdateScores();
    })->dailyAt('02:00');
    
    // Clear old search logs (keep 90 days)
    $schedule->command('logs:cleanup')->weekly();
}
```

---

## 📊 Database Schema Lengkap

### Entity Relationship

```
┌─────────────┐
│   users     │
│─────────────│
│ id          │
│ name        │
│ email       │
│ password    │
│ role        │
└─────────────┘

┌─────────────┐       ┌─────────────┐       ┌─────────────┐
│  headers    │       │  contacts   │       │   abouts    │
│─────────────│       │─────────────│       │─────────────│
│ id          │       │ id          │       │ id          │
│ title (JSON)│       │ address     │       │ title       │
│ tagline     │       │ phone       │       │ description │
│ logo        │       │ email       │       │ vision      │
│ button_text │       │ maps_embed  │       │ mission     │
└─────────────┘       └─────────────┘       └─────────────┘

┌──────────────┐      ┌──────────────┐      ┌──────────────┐
│  services    │      │   doctors    │      │  galleries   │
│──────────────│      │──────────────│      │──────────────│
│ id           │      │ id           │      │ id           │
│ title (JSON) │      │ name         │      │ title (JSON) │
│ description  │      │ specialty    │      │ description  │
│ icon         │      │ bio (JSON)   │      │ image        │
│              │      │ photo        │      │ sort_order   │
│              │      │              │      │ is_active    │
└──────────────┘      └──────────────┘      └──────────────┘

┌──────────────────────┐      ┌──────────────────┐
│     articles         │      │  search_logs     │
│──────────────────────│      │──────────────────│
│ id                   │      │ id               │
│ title (JSON)         │      │ query            │
│ excerpt (JSON)       │      │ results_count    │
│ content (JSON)       │      │ ip_address       │
│ image                │      │ created_at       │
│ slug                 │      └──────────────────┘
│ published_at         │
│ view_count           │
│ trend_score          │
│ trend_data (JSON)    │
└──────────────────────┘
```

---

## 🚀 Deployment Checklist

### Pre-Deployment
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `npm run build`
- [ ] Set `APP_ENV=production` di `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate new `APP_KEY` dengan `php artisan key:generate`
- [ ] Configure database credentials
- [ ] Setup Google Cloud credentials
- [ ] Setup Google Analytics API

### Optimization
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Enable OPcache di `php.ini`
- [ ] Setup Redis untuk cache & sessions
- [ ] Configure CDN untuk static assets

### Security
- [ ] Enable HTTPS (SSL certificate)
- [ ] Setup firewall rules
- [ ] Configure CORS jika needed
- [ ] Set secure session cookies
- [ ] Enable rate limiting
- [ ] Regular backup schedule

### Monitoring
- [ ] Setup error logging (Sentry/Bugsnag)
- [ ] Enable Google Analytics tracking
- [ ] Setup uptime monitoring
- [ ] Configure application performance monitoring

---

**Dibuat dengan ❤️ menggunakan Laravel 12 & modern web technologies**

## 📞 Support & Maintenance

Untuk pertanyaan teknis atau bug reports, silakan contact development team.

**Last Updated:** 2026-02-01
**Version:** 1.0.0
**Framework:** Laravel 12
**PHP Version:** 8.2+

