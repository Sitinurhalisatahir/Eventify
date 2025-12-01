### 🎫 Eventify - E-Ticketing Platform
Platform e-ticketing event modern yang memudahkan pengguna menemukan, memesan tiket, dan mengelola acara dengan antarmuka.

---
### ✨ Fitur Utama
### 👥 Multi-Level User System
- Admin - Akses penuh manajemen sistem
- Event Organizer - Kelola event dan tiket
- Registered User - Booking tiket dan favorit event
- Guest - Jelajahi event tanpa login
---

### Struktur Project
```plaintext
e-ticketing-event/
│
├── app/
│   ├── Console/
│   │   └── Kernel.php
│   ├── Exceptions/
│   │   └── Handler.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├──
│   │   │   │   ├── NewPasswordController.php
│   │   │   │   ├── PasswordController.php
│   │   │   │   ├── PasswordResetLinkController.php
│   │   │   │   ├── RegisteredUserController.php
│   │   │   │   ├
│   │   │   │   └──
│   │   │   │
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   ├── OrganizerApprovalController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── EventController.php
│   │   │   │   ├── TicketController.php
│   │   │   │   ├── BookingController.php
│   │   │   │   ├── ReportController.php
│   │   │   │   └── AnalyticsController.php
│   │   │   │
│   │   │   ├── Organizer/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── EventController.php
│   │   │   │   ├── TicketController.php
│   │   │   │   ├── BookingController.php
│   │   │   │   └── AnalyticsController.php
│   │   │   │
│   │   │   ├── User/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── BookingController.php
│   │   │   │   ├── FavoriteController.php
│   │   │   │   └── ReviewController.php
│   │   │   │
│   │   │   ├── Controller.php
│   │   │   ├── HomeController.php
│   │   │   ├── EventController.php
│   │   │   ├── ProfileController.php
│   │   │   └── ReviewController.php
│   │   │
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   ├── OrganizerMiddleware.php
│   │   │   ├── OrganizerApprovedMiddleware.php
│   │   │   ├── UserMiddleware.php
│   │   │   ├
│   │   │   ├── 
│   │   │
│   │   └── Requests/
│   │       ├── ProfileUpdateRequest.php
│   │       ├── StoreCategoryRequest.php
│   │       ├── UpdateCategoryRequest.php
│   │       ├── StoreEventRequest.php
│   │       ├── UpdateEventRequest.php
│   │       ├── StoreTicketRequest.php
│   │       ├── UpdateTicketRequest.php
│   │       ├── StoreBookingRequest.php
│   │       ├── UpdateBookingRequest.php
│   │       └── StoreReviewRequest.php
│   │
│   ├── Models/
│   │   ├── User.php
│   │   ├── Category.php
│   │   ├── Event.php
│   │   ├── Ticket.php
│   │   ├── Booking.php
│   │   ├── Favorite.php
│   │   ├── Review.php
│   │   └── Profile.php
│   │
│   ├── Providers/
│   │   ├──
│   │
│   └── View/
│       └── Components/
│           ├── AppLayout.php
│           └── GuestLayout.php
│
├── bootstrap/
│   ├── app.php
│   └── cache/
│       ├── packages.php
│       └── services.php
│
├── config/
│   ├── app.php
│   ├
│
├── database/
│   ├── factories/
│   │   ├── UserFactory.php
│   │   ├── CategoryFactory.php
│   │   ├── EventFactory.php
│   │   ├── TicketFactory.php
│   │   ├── BookingFactory.php
│   │   ├── FavoriteFactory.php
│   │   └── ReviewFactory.php
│   │
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2025_11_22_054723_add_organizer_fields_to_users_table.php
│   │   ├── 2025_11_22_054730_create_categories_table.php
│   │   ├── 2025_11_22_054740_create_events_table.php
│   │   ├── 2025_11_22_054752_create_tickets_table.php
│   │   ├── 2025_11_22_054806_create_bookings_table.php
│   │   ├── 2025_11_22_054820_create_favorites_table.php
│   │   ├── 2025_11_22_055203_create_reviews_table.php
│   │   └── 2025_11_29_102625_add_profile_image_to_users_table.php
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── AdminSeeder.php
│       ├── CategorySeeder.php
│       ├── OrganizerSeeder.php
│       ├── UserSeeder.php
│       ├── EventSeeder.php
│       ├── TicketSeeder.php
│       ├── BookingSeeder.php
│       ├── FavoriteSeeder.php
│       └── ReviewSeeder.php
│
├── public/
│   ├── /images
├── resources/
│   ├── css/
│   │   └── app.css
│   │
│   ├── js/
│   │   ├── app.js
│   │   ├── bootstrap.js
│   │   └── components/
│   │       ├── event-filter.js
│   │       ├── booking-modal.js
│   │       ├── favorite-toggle.js
│   │       └── review-rating.js
│   │
│   └── views/
│       │
│       ├── components/
│       │   │
│       │   ├── cards/
│       │   │   ├── event-card.blade.php
│       │   │   ├── ticket-card.blade.php
│       │   │   ├── booking-card.blade.php
│       │   │   ├── stats-card.blade.php
│       │   │   ├── ticket card
│       │   │   └──
│       │   │
│       │   ├── ui/
│       │   │   ├── button.blade.php
│       │   │   ├── badge.blade.php
│       │   │   ├── input.blade.php
│       │   │   ├── textarea.blade.php
│       │   │   ├── select.blade.php
│       │   │   ├── alert.blade.php
│       │   │   ├── modal.blade.php
│       │   │   ├── breadcrumb.blade.php
│       │   │   ├── checkbox-group.blade.php
│       │   │   ├── file-upload.blade.php
│       │   │   ├── radio.blade.php
│       │   │   ├── search-bar.blade.php
│       │   │   ├── pagination.blade.php
│       │   │   ├─
│       │   ├── layout/
│       │   │   ├── navbar.blade.php
│       │   │   ├── footer.blade.php
│       │   │   ├── sidebar-admin.blade.php
│       │   │   ├── sidebar-organizer.blade.php
│       │   │   ├─
│       │   │   └──
│       │   │
│       │   
│       │
│       ├── layouts/
│       │   ├── app.blade.php
│       │   ├── guest.blade.php
│       │   ├── admin.blade.php
│       │   ├── organizer.blade.php
│       │   └── user.blade.php
│       │
│       ├── auth/
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   ├── forgot-password.blade.php
│       │   ├── reset-password.blade.php
│       │   └── pending.blade.php
│       │
│       ├── home/
│       │   ├── index.blade.php
│       │   └── partials/
│       │       ├── hero.blade.php
│       │       ├── featured-events.blade.php
│       │       ├── categories.blade.php
│       │       ├── upcoming-events.blade.php
│       │       └── past-event.blade.php
│       │
│       ├── events/
│       │   ├── index.blade.php
│       │   ├── show.blade.php
│       │   └── partials/
│       │       ├── filter-sidebar.blade.php
│       │       ├── event-grid.blade.php
│       │       ├── event-list.blade.php
│       │       ├── event-hero.blade.php
│       │       ├── event-details.blade.php
│       │       ├── organizer-info.blade.php
│       │       ├── ticket-list.blade.php
│       │       ├── booking-sidebar.blade.php
│       │       ├── review-list.blade.php
│       │       ├── review-form.blade.php
│       │       ├── similar-events.blade.php
│       │       └── sort-header.blade.php
│       │
│       ├── admin/
│       │   │
│       │   ├── dashboard.blade.php
│       │   │
│       │   ├── users/
│       │   │   ├── index.blade.php
│       │   │   ├── show.blade.php
│       │   │
│       │   ├── organizers/
│       │   │   ├── approvalblade.php
│       │   │
│       │   ├── categories/
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │
│       │   ├── events/
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   ├── show.blade.php
│       │   │
│       │   ├── tickets/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │
│       │   ├── bookings/
│       │   │   ├── index.blade.php
│       │   │   ├── show.blade.php
│       │   │
│       │   ├── reports/
│       │   │   ├── index.blade.php
│       │   │
│       │   └── analytics/
│       │       ├── index.blade.php
│       │
│       ├── organizer/
│       │   │
│       │   ├── dashboard.blade.php
│       │   │
│       │   ├── events/
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   ├── show.blade.php
│       │   │
│       │   ├── tickets/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │
│       │   ├── bookings/
│       │   │   ├── index.blade.php
│       │   │   ├── show.blade.php
│       │   │
│       │   └── analytics/
│       │       ├── index.blade.php
│       │
│       └── user/
│           │
│           ├── dashboard.blade.php
│           │
│           ├── profile/
│           │   ├── edit.blade.php
│           │   ├── show.blade.php
│           │
│           ├── bookings/
│           │   ├── index.blade.php
│           │   ├── show.blade.php
│           │   ├── create.blade.php
│           │
│           ├── favorites/
│           │   ├── index.blade.php
│           │
│           └── reviews/
│               ├── create.blade.php
│               ├── edit.blade.php
│               └── partials/
│                   └── review-form-fields.blade.php
│
├── routes/
│   ├── web.php
│   ├── api.php
│   ├── console.php
│   └── auth.php
│
├── storage/
│   ├── app/
│   │   ├── public/
│   │   │   ├── events/
│   │   │   ├── tickets/
│   │   │   ├── profiles/
│   │   │  
│   │   
│   ├── fonts/
│   ├── logs/
│   └── temp/
│
├── tests/
│   ├── Unit/
│   │   ├──
│   │
│   ├── Feature/
│   │   ├──
│   └── TestCase.php
│
├── vendor/
│
├── .env
├── .env.example
├── .gitattributes
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── phpunit.xml
├── README.md
├── server.php
├── tailwind.config.js
├── vite.config.js
└── webpack.mix.js
```
---

### 🛠️ Installatsi & Setup
1. Clone repository
   git clone https://github.com/Sitinurhalisatahir/eventify.git
   cd eventify

3. Install dependencies
   - composer create-project laravel/laravel eventify,
   - require laravel/breeze --dev
   - npm install && npm run build

4. Environment setup
   cp .env.example .env
   - DB_CONNECTION=mysql
   - DB_HOST=127.0.0.1
   - DB_PORT=3306
   - DB_DATABASE=db_eventify
   - DB_USERNAME=root
   - DB_PASSWORD=
  
5. Database configuration
   - Edit .env file dengan database credentials
   - php artisan migrate --seed
   - php artisan storage:link

7. Serve application
   - php artisan serve
   - npm run dev

```

```
## 🏗️ Struktur File & Fungsionalitas

### 🔐 **AUTHENTICATION SYSTEM** (`app/Http/Controllers/Auth/`)
- **AuthenticatedSessionController** - Login/logout session management
- **RegisteredUserController** - Pendaftaran user baru dengan role selection
- **PasswordResetLinkController** - Reset password via email
- **NewPasswordController** - Set password baru setelah reset
- **PasswordController** - Update password user

### 🏠 **PUBLIC PAGES** (`app/Http/Controllers/`)
- **HomeController** - Homepage dengan featured events, categories, upcoming events
- **EventController** - Public event catalog & detail pages
- **ProfileController** - Profile management untuk semua role

### 👑 **ADMIN SYSTEM** (`app/Http/Controllers/Admin/`)
- **DashboardController** - Admin dashboard overview
- **UserController** - Kelola semua user (view, edit, delete)
- **OrganizerApprovalController** - Approve/reject organizer applications
- **CategoryController** - CRUD kategori event
- **EventController** - Kelola semua event (view, edit, delete)
- **TicketController** - Kelola tiket event
- **BookingController** - Lihat & kelola semua pemesanan
- **ReportController** - Laporan penjualan & analytics
- **AnalyticsController** - Dashboard analytics dengan charts

### 🎪 **ORGANIZER SYSTEM** (`app/Http/Controllers/Organizer/`)
- **DashboardController** - Organizer dashboard dengan statistik
- **EventController** - CRUD event milik organizer
- **TicketController** - Kelola tiket untuk event
- **BookingController** - Lihat & approve pemesanan untuk event organizer
- **AnalyticsController** - Analytics khusus organizer (revenue, bookings)

### 👤 **USER SYSTEM** (`app/Http/Controllers/User/`)
- **DashboardController** - User dashboard dengan bookings & favorites
- **BookingController** - Lihat & kelola pemesanan user
- **FavoriteController** - Kelola daftar event favorit
- **ReviewController** - Beri rating & review untuk event yang dihadiri

### 🛡️ **MIDDLEWARE** (`app/Http/Middleware/`)
- **AdminMiddleware** - Restrict akses hanya untuk admin
- **OrganizerMiddleware** - Restrict akses hanya untuk organizer
- **OrganizerApprovedMiddleware** - Restrict hanya organizer yang approved
- **UserMiddleware** - Restrict akses hanya untuk regular user

### 📝 **FORM VALIDATION** (`app/Http/Requests/`)
- **ProfileUpdateRequest** - Validasi update profile
- **StoreCategoryRequest** - Validasi buat kategori baru
- **UpdateCategoryRequest** - Validasi update kategori
- **StoreEventRequest** - Validasi buat event baru
- **UpdateEventRequest** - Validasi update event
- **StoreTicketRequest** - Validasi buat tiket baru
- **StoreBookingRequest** - Validasi pemesanan tiket
- **StoreReviewRequest** - Validasi submit review

### 🗃️ **DATABASE MODELS** (`app/Models/`)
- **User** - Model untuk semua users dengan role management
- **Category** - Model untuk kategori event
- **Event** - Model untuk event dengan status management
- **Ticket** - Model untuk tiket event dengan quota management
- **Booking** - Model untuk pemesanan dengan status tracking
- **Favorite** - Model untuk event favorit user
- **Review** - Model untuk rating & review event

### 🎨 **FRONTEND COMPONENTS** (`resources/views/components/`)

#### 🃏 **CARDS** (`components/cards/`)
- **event-card.blade.php** - Card untuk menampilkan event
- **ticket-card.blade.php** - Card untuk menampilkan tiket
- **booking-card.blade.php** - Card untuk menampilkan booking
- **stats-card.blade.php** - Card untuk statistik dashboard
- **review-card.blade.php** - Card untuk menampilkan review

#### ⚡ **UI COMPONENTS** (`components/ui/`)
- **button.blade.php** - Reusable button components
- **badge.blade.php** - Status badges & labels
- **input.blade.php** - Form input fields
- **textarea.blade.php** - Textarea components
- **select.blade.php** - Dropdown select components
- **alert.blade.php** - Alert/notification components
- **modal.blade.php** - Modal dialog components
- **breadcrumb.blade.php** - Navigation breadcrumbs
- **checkbox-group.blade.php** - Checkbox group components
- **file-upload.blade.php** - File upload components
- **radio.blade.php** - Radio button components
- **search-bar.blade.php** - Search input components

#### 🧭 **LAYOUT COMPONENTS** (`components/layout/`)
- **navbar.blade.php** - Main navigation bar
- **footer.blade.php** - Site footer
- **sidebar-admin.blade.php** - Admin dashboard sidebar
- **sidebar-organizer.blade.php** - Organizer dashboard sidebar

### 🎪 **PUBLIC PAGES** (`resources/views/`)

#### 🏠 **HOMEPAGE** (`home/`)
- **index.blade.php** - Main homepage layout
- **partials/hero.blade.php** - Hero section dengan search
- **partials/featured-events.blade.php** - Featured events section
- **partials/categories.blade.php** - Event categories section
- **partials/upcoming-events.blade.php** - Upcoming events section

#### 📅 **EVENT PAGES** (`events/`)
- **index.blade.php** - Event catalog dengan filter & search
- **show.blade.php** - Event detail page dengan booking form
- **partials/filter-sidebar.blade.php** - Filter sidebar untuk catalog
- **partials/event-grid.blade.php** - Grid layout untuk events
- **partials/ticket-list.blade.php** - List tiket untuk event
- **partials/review-list.blade.php** - List reviews untuk event
- **partials/event-hero.blade.php** - Hero section event detail
- **partials/event-details.blade.php** - Event information section
- **partials/organizer-info.blade.php** - Organizer information
- **partials/similar-events.blade.php** - Related events recommendation
- **partials/booking-sidebar.blade.php** - Booking form sidebar
- **partials/review-form.blade.php** - Form untuk submit review

### 👑 **ADMIN PANEL** (`resources/views/admin/`)
- **dashboard.blade.php** - Admin dashboard dengan analytics
- **users/index.blade.php** - Kelola semua users
- **organizers/index.blade.php** - Approve/reject organizers
- **categories/*** - CRUD kategori event
- **events/*** - Kelola semua events
- **bookings/*** - Lihat semua pemesanan
- **reports/index.blade.php** - Sales reports & analytics
- **analytics/index.blade.php** - Advanced analytics dashboard

### 🎪 **ORGANIZER PANEL** (`resources/views/organizer/`)
- **dashboard.blade.php** - Organizer dashboard
- **events/*** - Kelola event milik organizer
- **tickets/*** - Kelola tiket event
- **bookings/*** - Kelola pemesanan untuk event organizer
- **analytics/index.blade.php** - Analytics khusus organizer

### 👤 **USER DASHBOARD** (`resources/views/user/`)
- **dashboard.blade.php** - User personal dashboard
- **bookings/*** - Kelola pemesanan user
- **favorites/index.blade.php** - Daftar event favorit
- **reviews/*** - Form untuk edit review

---

## 🚀 **FITUR UTAMA**

### 👤 **Untuk User Reguler:**
- 🔍 Browse & search events
- ❤️ Add events to favorites
- 🎫 Book tickets dengan berbagai tipe
- ⭐ Beri rating & review untuk event yang dihadiri
- 📱 Kelola pemesanan & lihat history

### 🎪 **Untuk Organizer:**
- ➕ Buat & kelola event
- 🎫 Kelola tiket dengan berbagai harga & quota
- ✅ Approve/reject pemesanan
- 📊 Analytics pendapatan & performance
- 👀 Preview event sebelum publish

### 👑 **Untuk Admin:**
- 👥 Kelola semua users & organizers
- ✅ Approve/reject organizer applications
- 🏷️ Kelola kategori event
- 📊 Analytics sistem lengkap
- 📈 Reports penjualan & growth
- 🔧 Moderasi content

## 🛠️ **TEKNOLOGI**
- **Backend:** Laravel 10, PHP 8.1+
- **Frontend:** Tailwind CSS, Alpine.js
- **Database:** MySQL
- **Authentication:** Laravel Breeze
- **File Storage:** Local/Flysystem
- **Icons:** Font Awesome
  
```

```
## 📦 **INSTALASI**
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
```

---
```
### 🗄 Database Schema

users (id, name, email, role, organizer_status, profile_image)
  │
  ├─1:N─► events (id, organizer_id, category_id, name, event_date, ...)
  │         │
  │         ├─1:N─► tickets (id, event_id, name, price, quota, ...)
  │         │         │
  │         │         └─1:N─► bookings (id, user_id, ticket_id, booking_code, status)
  │         │
  │         ├─1:N─► favorites (id, user_id, event_id)
  │         │
  │         └─1:N─► reviews (id, user_id, event_id, booking_id, rating, comment)
  │
  └─1:N─► bookings, favorites, reviews

categories (id, name, slug, icon, color)
  │
  └─1:N─► events
  ```
 ---

 
  ### 🗄 Relasi Database 
  <img width="449" height="368" alt="image" src="https://github.com/user-attachments/assets/fac259bc-13ea-472f-8a2e-2ed712b5a24d" />


----
```
### **👨‍💻 Akun Default**
**Akun Admin**
- Email: admin@eventify.com
- Kata Sandi: password123
- Fitur: Mengatur semua manajemen tiket dan acara, Dapat menyetujui Organizer, Pending, dan Batalkan

**Akun Organizer** 
- Email: organizer1@eventify.com
- Kata Sandi: password123
- Fitur: Manajemen akun event dan tiket sendiri dan Menyetujui Pesanan

**Akun User**
- Email: jane@example.com
- Kata Sandi: password123
- Fitur: Pesan Tiket, Riview dan Bisa Favorit Event

---

## 🏠 Halaman Beranda (Homepage)

### **Beranda**
<img width="941" height="317" alt="image" src="https://github.com/user-attachments/assets/fad2140a-110b-4797-bee4-bb7d83e3d53e" />

- 🎯 **Tempat Pencarian Acara** - Search bar dengan autocomplete
- 🔍 **Jelajahi Acara** - Button untuk langsung ke katalog event
- 📝 **Daftar Akun** - CTA untuk register (jika belum login)
- 🎨 **Design menarik** - Banner dengan event highlights

---

#### **🎪 Acara Populer**
<img width="467" height="392" alt="image" src="https://github.com/user-attachments/assets/8c83fdd8-f16b-4b46-a998-4f4e89c4a2bd" />

- Menampilkan event dengan booking terbanyak
- Rating tertinggi dari user
- Dilengkapi badge "POPULAR"

---

### **🎉 Kategori**
<img width="929" height="424" alt="image" src="https://github.com/user-attachments/assets/eb2e7098-fc9f-40d1-a38a-fb56d6b99cd0" />

berbagai macam kategori:
- Musik
- Kuliner
- Workshop
- Olahraga
- Teater
- Seni
- Seminar
- Konser

---

#### **📅 Acara Mendatang**
<img width="939" height="414" alt="image" src="https://github.com/user-attachments/assets/c9504d81-55c3-4730-9678-56c050c9a027" />

- Event yang akan datang dalam 30 hari
- Sort by tanggal terdekat
- Countdown timer ke event

---

#### **⏳ Acara Telah Berlangsung**
<img width="955" height="439" alt="image" src="https://github.com/user-attachments/assets/f09149cb-5c7d-41d8-88f0-facd2f489e86" />

- Archive event yang sudah selesai
- Bisa lihat review & rating

--- 

### Guest (Pengunjung)
🔍 **Jelajahi event** 
<img width="926" height="361" alt="image" src="https://github.com/user-attachments/assets/eb6dc7a3-67dd-4a85-a475-efddab0c7436" />

- Browse semua event yang tersedia

---

📱 **View details** - Lihat detail event lengkap
<img width="956" height="449" alt="image" src="https://github.com/user-attachments/assets/966aaca0-9f5d-47b5-a5d1-8be7d83db0e8" />
<img width="430" height="398" alt="image" src="https://github.com/user-attachments/assets/f2db4050-681b-4196-8448-210523864309" />

---

🔎 **Search & filter** 



<img width="190" height="396" alt="image" src="https://github.com/user-attachments/assets/e2d70344-e6b0-48b3-a1ed-379632831a4e"/>

  
- Cari event berdasarkan kategori, lokasi, tanggal
  
---

🔐 **Login required** 



<img width="491" height="420" alt="image" src="https://github.com/user-attachments/assets/8c3c8fce-bb43-4ab7-a835-47fa8de3d0be" />

- Harus login untuk booking & favorit

---
### Antarmuka Login Eventify

<img width="926" height="430" alt="image" src="https://github.com/user-attachments/assets/4702dc6e-fbe7-4fd2-841e-3f75b7e3ab28" />


login untuk platform Eventify dengan:
- Form autentikasi pengguna
- Opsi "Ingat saya"
- Fitur lupa kata sandi
- Navigasi ke pendaftaran akun baru

---

### 📋 Registrasi - Eventify Platform

<img width="949" height="433" alt="image" src="https://github.com/user-attachments/assets/a80fa8d4-4fae-43bb-9ad3-0bb09705c945" />

Komponen halaman pendaftaran user baru:
- Form data pribadi lengkap 🔐
- Validasi input email & password ✅
- Optional phone number field 📱
- Password confirmation 🔄
- Navigasi ke halaman login ➡️

---

## 🎯 Dashboard Pengguna - Eventify

**Dashboard Utama 🏠**

<img width="1153" height="877" alt="image" src="https://github.com/user-attachments/assets/82958b77-5d11-42a5-a55c-a14e2518a42e" />

- Ringkasan pemesanan & status
- Tabel pesanan terbaru
- Sorotan acara mendatang
- Daftar acara favorit

---
  
**Halaman Favorit ❤️**

<img width="1873" height="853" alt="image" src="https://github.com/user-attachments/assets/77ada7fb-2942-4a98-9d9f-96245533830e" />


- Acara pilihan yang dikurasi
- Kartu acara detail
- Metrik harga & minat peserta
- Manajemen langganan notifikasi

---


### 🎯 Dashboard & Manajemen Pemesanan Pengguna - Eventify

**Dashboard Profil 🏠**

<img width="1881" height="351" alt="image" src="https://github.com/user-attachments/assets/915baa3c-5fd1-4a1e-b4ad-a87b2a9176e5" />


- Sambutan personal dengan nama user
- Ringkasan statistik pemesanan:
  - Total Pemesanan
  - Disetujui
  - Menunggu
- Menu navigasi sidebar:
  - Edit Profile
  - Pesanan Saya
  - Logout
- Info total pengeluaran

---

**Halaman Pemesanan Saya 📋**

<img width="1912" height="913" alt="image" src="https://github.com/user-attachments/assets/e8e6f257-5ea1-4f00-8f24-3629f16d65d9" />

- Filter status pemesanan:
  - Semua Pemesanan (4)
  - Menunggu (0)
  - Disetujui (2)
  - Dibatalkan (2)
- Fitur pencarian berdasarkan kode booking/nama acara
- Tabel detail pemesanan dengan kolom:
  - Kode PEMESANAN & booking
  - Nama acara & tiket
  - Tanggal & waktu
  - Jumlah harga
  - Status persetujuan
  - Aksi lihat detail

**Fitur Utama:**
✅ Tracking status pemesanan real-time  
🔍 Sistem pencarian & filter  
📊 Ringkasan finansial  
👤 Manajemen profil user  
🎫 Detail tiket & booking code

---

### 👤 Halaman "Edit Profil" - Eventify

<img width="536" height="432" alt="image" src="https://github.com/user-attachments/assets/fa9fc352-3b33-49db-9905-cae05b040744" />


**Fitur Utama:**
- 📝 **Informasi Dasar**
  - Nama Lengkap (contoh: "iis")
  - Nomor Telepon
  - Foto Profil
  - Alamat Email (contoh: isi@gmail.com)

- 🖼️ **Upload Foto Profil**
  - Pilih file dengan tombol "Choose File"
  - Format yang didukung: JPG, PNG
  - Ukuran maksimal: 2MB

- 🔐 **Ubah Password**
  - Input password saat ini
  - Input password baru
  - Konfirmasi password baru
  - Validasi keamanan password

**Tombol Aksi:**
💾 **Simpan Perubahan** - Untuk menyimpan semua update profil

**Fitur Keamanan:**
✅ Update informasi pribadi  
✅ Ganti foto profil  
✅ Ubah password dengan konfirmasi  
✅ Validasi format file upload

**User Experience:**
- Form yang terorganisir rapi
- Section terpisah untuk data dasar dan keamanan
- Petunjuk upload file yang jelas
- Tombol simpan yang prominent

---

## 🎪 Dashboard Organizer - Eventify

<img width="942" height="449" alt="image" src="https://github.com/user-attachments/assets/28311199-3ebe-4628-ad68-8bdea240d8f7" />


### 📊 **Ringkasan Statistik**
- Memantau jumlah acara yang telah dibuat
- Melacak total pemesanan tiket yang masuk
- Menyajikan gambaran keseluruhan kinerja event

### 🎯 **Manajemen Acara**
- **Acara Saya**: Mengelola dan mengedit detail event
- **Buat Acara**: Membuat event baru dengan formulir lengkap
- **Klasifikasi Acara**: Memisahkan antara acara populer dan mendatang

### 📈 **Analisis Popularitas**
- Mengidentifikasi acara yang paling diminati
- Melihat jumlah pemesanan per event
- Memantau tingkat engagement peserta

### 📅 **Penjadwalan Acara**
- Melihat acara yang akan datang
- Mengatur timeline persiapan event
- Memiliki pengingat untuk acara mendatang

### 💰 **Manajemen Pemesanan**
- Memantau pemesanan terbaru
- Melacak status konfirmasi pemesanan
- Mengelola pembayaran dan pendapatan

### 🔍 **Pencarian dan Filter**
- Mencari acara atau pemesanan tertentu
- Memfilter berdasarkan status
- Mengelompokkan tampilan acara

---

### 🎪 Panel Kelola Acara Organizer - Eventify

## Halaman "Buat Acara Baru"

<img width="1894" height="903" alt="image" src="https://github.com/user-attachments/assets/3332956d-2b8e-4224-8fc7-464ed8843c8e" />


**Fungsi:** Formulir untuk membuat event baru
- Input nama acara
- Pilih kategori event
- Atur tanggal dan waktu
- Tentukan lokasi
- Tambahkan deskripsi
- Upload gambar poster (maks. 2MB)
- Opsi simpan sebagai draft atau publish

---

## Halaman "Acara Saya"  

<img width="1645" height="835" alt="image" src="https://github.com/user-attachments/assets/2fafa1de-42da-4b47-8067-36e9da8f7e94" />

**Fungsi:** Mengelola semua event yang dibuat
- Daftar semua acara dengan status
- Filter berdasarkan kategori dan status
- Info setiap acara: tanggal, lokasi, jumlah pemesanan
- Tombol aksi untuk edit dan kelola tiket
- Statistik pendapatan per event

----


## Halaman "Edit Acara"
**Fungsi:** Mengubah detail event yang sudah dibuat
- Edit informasi dasar (nama, kategori, jadwal)
- Update lokasi dan deskripsi
- Ubah status publikasi
- Edit gambar poster
- Kelola pengaturan tiket dan harga

---

<img width="951" height="442" alt="image" src="https://github.com/user-attachments/assets/7bb1804a-4c6a-4e3f-9cb6-df37d2f2ae07" />

---

## 🎪 Panel Organizer - Manajemen Pemesanan

### Halaman "Pemesanan Acara Organizer"

<img width="1909" height="1021" alt="image" src="https://github.com/user-attachments/assets/903e1191-fb4e-4f3a-bfa0-1a921baa3e3f" />


**Fungsi:** Melihat dan mengelola semua pemesanan
- Ringkasan status: Menunggu (0), Disetujui (3)
- Filter berdasarkan acara
- Daftar pemesanan dengan detail:
  - Kode booking & nama pemesan
  - Acara & jenis tiket
  - Jumlah dan total harga
  - Status persetujuan
  - Tanggal pemesanan
  - Tombol aksi "Lihat" detail
 
---

### Halaman "Detail Pemesanan"
**Fungsi:** Melihat informasi lengkap satu pemesanan
- **Informasi Pemesanan:**
  - Kode booking, status, jumlah tiket
  - Total harga & tanggal pemesanan

- **Detail Acara:**
  - Nama acara dan deskripsi
  - Tanggal & lokasi event
  - Jenis tiket dan harga
  - Kapasitas tersedia (250/1000)

- **Aksi Cepat:**
  - Unduh tiket
  - Hubungi pelanggan

- **Timeline Pemesanan:**
  - History status dari dibuat hingga disetujui
  - Countdown menuju tanggal acara

- **Profil Pelanggan:**
  - Data lengkap pemesan
  - Member sejak dan riwayat pemesanan
  - Status kehadiran di acara

## Fitur Utama:
- Tracking status pemesanan real-time
- Manajemen approval tiket
- Data lengkap pelanggan
- Timeline progress pemesanan
- Aksi cepat untuk operasional

---

## 🎪 Panel Organizer Analitik - Eventify

<img width="1912" height="883" alt="image" src="https://github.com/user-attachments/assets/4637ce9b-eaaf-4ee6-8b45-8890cbb5f845" />


### Halaman Analitik
- Lihat total pendapatan dan pemesanan
- Track tren pendapatan bulanan (grafik)
- Monitor tren pemesanan bulanan (grafik)
- Filter data berdasarkan periode
- Bandingkan performa antar acara
- Lihat distribusi status pemesanan
- Identifikasi acara paling laris
- Analisis rata-rata nilai tiket


---

<img width="1894" height="913" alt="image" src="https://github.com/user-attachments/assets/8087a38a-8d29-4d24-aecc-59453cfb198e" />


## Halaman Detail Analitik
- Ranking performa tiap acara
- Bandingkan jumlah pemesanan per event
- Bandingkan pendapatan per event
- Lihat persentase pemesanan sukses vs gagal
- Analisis harga rata-rata per tiket
- Evaluasi kinerja tiap acara


---

## Admin Dashboard

<img width="954" height="445" alt="image" src="https://github.com/user-attachments/assets/809af492-287e-4970-b4e3-60183af2b56b" />

## 🎪 Panel Admin - Management Acara
## Dashboard Management
- Mengelola program acara
- Memverifikasi dan menyetujui organizer
- Mengelola kategori acara
- Memantau semua acara
- Mengelola pemesanan tiket
- Membuat laporan sistem

## Analitik & Monitoring
- Memantau total program (7 program)
- Melacak organizer disetujui (2 organizer)
- Melihat ringkasan pendapatan
- Memonitor total pendapatan Rp 1.650.000
- Melacak status pemesanan (Disetujui, Dokumen, Ditolak)

## Manajemen Acara
- Melihat acara popular berdasarkan pemesanan
- Memantau performa tiap event
- Melihat detail pemesanan per acara

## Sistem Admin
- Menerima notifikasi pengingat
- Mengatur tema tampilan (dark/light)
- Mengelola preferensi warna
- Melihat pemesanan terbaru
- Memfilter acara berdasarkan kategori

---

### 👥 Management Pengguna - Panel Admin

<img width="1900" height="897" alt="image" src="https://github.com/user-attachments/assets/a8871c4c-d1d7-4144-96d3-61223158091f" />

## Dashboard Management
- Mengelola data pengguna sistem
- Memverifikasi dan menyetujui organizer
- Mengelola kategori pengguna
- Melihat semua akun pengguna
- Mengelola status pemesanan user
- Membuat laporan aktivitas pengguna
- Menganalisa statistik pengguna

## Statistik Pengguna
- Memantau total pengguna (7 users)
- Melihat device yang digunakan (4 computer)
- Mengelola akses admin (2 admin)
- Filter pengguna berdasarkan peran
- Mencari pengguna berdasarkan nama/email

## Manajemen Data Pengguna
- Melihat daftar semua pengguna
- Memantau status aktivitas user
- Melihat tanggal bergabung pengguna
- Mengelola akses dan peran pengguna
- Filter dan hapus data pengguna

<img width="1911" height="918" alt="image" src="https://github.com/user-attachments/assets/539d73f8-a30b-42d2-b280-efdc86ac5e47" />

## Detail Informasi Pengguna
- Melihat profil lengkap pengguna
- Memantau informasi kontak (email, telepon)
- Melihat statistik pemesanan user
- Memantau total pengeluaran pengguna
- Melihat riwayat pemesanan terbaru
- Melacak favorit dan preferensi user

---
## 🏷️ Management Kategori - Panel Admin

<img width="1908" height="910" alt="image" src="https://github.com/user-attachments/assets/01cccb2e-0c37-4564-9d2c-34ba2157a5e5" />


## Manajemen Kategori
- Mengelola kategori acara dan propertinya
- Menambah kategori acara baru
- Mengedit detail kategori yang sudah ada
- Menghapus kategori yang tidak diperlukan

<img width="1866" height="901" alt="image" src="https://github.com/user-attachments/assets/7208efcb-de90-45aa-8295-35fe1faacb17" />


## Form Tambah/Edit Kategori
- Menginput nama kategori (contoh: Music Concert)
- Menambahkan icon class (contoh: fas fa-music)
- Menulis deskripsi untuk kategori
- Mengatur slug/URL yang user-friendly
- Memilih warna tema kategori dengan kode hex

## Daftar Kategori
- Melihat semua kategori yang tersedia
- Memantau ikon dan warna setiap kategori
- Melihat jumlah acara per kategori
- Membaca deskripsi setiap kategori
- Mengakses aksi edit dan hapus untuk setiap kategori

## Fitur Kategori
- Filter dan organisasi kategori
- Monitoring penggunaan kategori
- Pengelolaan properti visual (ikon, warna)
- Sistem audit perubahan data

---

## 📅 Management Acara - Panel Admin

<img width="936" height="438" alt="image" src="https://github.com/user-attachments/assets/f1d5c0be-0ef0-44f4-b65c-6d95efa3863e" />


## Dashboard Management
- Mengelola semua acara dalam sistem
- Memantau persetujuan organizer
- Mengatur kategori acara
- Melihat semua acara yang tersedia
- Mengelola pemesanan tiket
- Membuat laporan acara
- Menganalisa performa acara

## Fitur Pencarian & Filter
- Mencari acara berdasarkan nama
- Filter berdasarkan status acara
- Filter berdasarkan kategori acara
- Filter berdasarkan organizer
- Melihat total acara (9 acara)

## Manajemen Daftar Acara
- Melihat semua acara yang terdaftar
- Memantau detail acara (nama, deskripsi)
- Melihat kategori dan jenis acara
- Memantau tanggal dan waktu acara
- Melihat jumlah tiket tersedia
- Mengelola ketersediaan tiket
- Akses edit dan hapus acara

## Informasi Acara
- Melihat organizer penyelenggara
- Memantau lokasi acara
- Melihat jumlah peserta terdaftar
- Monitoring status ketersediaan tiket
- Mengelola detail deskripsi acara

---

# 📋 Management Pemesanan - Panel Admin

<img width="1891" height="880" alt="image" src="https://github.com/user-attachments/assets/5e3054a7-c85b-4a9c-ab2e-fecb6b8a4322" />


## Dashboard Pemesanan
- Mengelola semua pemesanan tiket dalam sistem
- Melacak status pemesanan (Disetujui, Pending, Ditolak)
- Memantau kode booking dan detail transaksi
- Filter pemesanan berdasarkan status dan tanggal

---

<img width="1872" height="894" alt="image" src="https://github.com/user-attachments/assets/cbfc650f-c17d-474b-a00f-54da916400f3" />

<img width="1888" height="883" alt="image" src="https://github.com/user-attachments/assets/d009a328-3ef0-449e-83b8-01c1d163ef1f" />

## Detail Booking
- Melihat informasi lengkap pesanan (#7FILWJJHWW)
- Memantau status pemesanan (Disetujui)
- Mengecek jumlah tiket dan total harga
- Melihat tanggal booking yang dilakukan

## Informasi Tiket
- Melihat jenis tiket (Student Pass, General Admission, VIP)
- Memantau harga per tiket dan ketersediaan
- Mengecek deskripsi dan syarat tiket
- Monitoring kuota tiket yang tersedia

## Informasi Acara
- Melihat detail acara yang dipesan
- Memantau tanggal, waktu, dan lokasi acara
- Mengecek organizer penyelenggara
- Melihat deskripsi lengkap acara

## Informasi Pelanggan
- Melihat data lengkap pemesan (nama, email, telepon)
- Memantau detail kontak pelanggan
- Melakukan verifikasi data pemesan

## Timeline & Status
- Melacak timeline pemesanan (Booking Dibuat, Disetujui)
- Memantau progress status booking
- Melihat estimasi waktu hingga acara
- Konfirmasi penerimaan tiket digital

---

## 📊 Laporan & Analitik - Panel Admin

<img width="1893" height="880" alt="image" src="https://github.com/user-attachments/assets/50dece0b-95ba-4ce6-afa7-ca0ea37ad9fe" />

<img width="1885" height="927" alt="image" src="https://github.com/user-attachments/assets/41766b0b-f8f7-4c8e-9fcb-b768b85cb2eb" />


## Dashboard Laporan
- Membuat laporan penjualan dan analitik
- Menganalisa data pemesanan dan pendapatan
- Melihat statistik performa acara
- Filter laporan berdasarkan periode tanggal

## Analitik Pendapatan
- Melihat total pendapatan (Rp 550.000)
- Memantau pendapatan berdasarkan status (Disetujui, Tertunda, Ditolak)
- Menganalisa tren pendapatan harian/bulanan
- Membandingkan target vs realisasi pendapatan

## Statistik Pemesanan
- Melihat total pemesanan (4 pesanan)
- Memantau pemesanan berdasarkan status
- Menganalisa tingkat konversi pemesanan
- Melihat tren jumlah pemesanan over time

## Performa Acara
- Melihat acara terlaris berdasarkan pendapatan
- Memantau performa tiap organizer
- Menganalisa pendapatan per kategori acara
- Melihat distribusi acara aktif (8 acara)

## Filter & Export
- Filter laporan berdasarkan tanggal mulai dan akhir
- Reset filter untuk melihat data keseluruhan
- Export data laporan untuk analisa lebih lanjut
- Generate report dalam berbagai format

---

## 📈 Dashboard Analitik - Panel Admin

<img width="1902" height="885" alt="image" src="https://github.com/user-attachments/assets/e854840c-e456-41a7-9785-e539a441e670" />

<img width="1882" height="886" alt="image" src="https://github.com/user-attachments/assets/70ea369d-32c0-4ae6-a6c3-e1715fc36f71" />


## Overview Performa
- Melihat tren pendapatan bulanan dalam Rupiah
- Memantau pertumbuhan pengguna baru
- Menganalisa total pendapatan (Rp 1.650.000)
- Melihat total pemesanan (9 pesanan)
- Memantau total pengguna (7 users)
- Mengecek persentase pertumbuhan pemesanan

<img width="1897" height="901" alt="image" src="https://github.com/user-attachments/assets/23ce8dec-df33-42ac-bcd3-8627b615fd75" />

## Performa Organizer/EO
- Melihat ranking organizer berdasarkan pendapatan
- Memantau total acara per organizer
- Menganalisa kontribusi pendapatan tiap EO
- Mengecek email dan kontak organizer

## Acara Terbaik
- Mengidentifikasi acara dengan kinerja terbaik
- Melihat tingkat pemesanan dan konversi
- Memantau rating rata-rata acara
- Membandingkan performa antar acara



<img width="1897" height="901" alt="image" src="https://github.com/user-attachments/assets/d637a747-fbe2-45b5-8493-5a604419988a" />


## Kinerja Kategori
- Menganalisa performa tiap kategori acara
- Melihat total pemesanan per kategori
- Memantau pendapatan per kategori
- Mengecek jumlah acara aktif per kategori
- Membandingkan kinerja kategori (Concert, Conference, Music, Workshop, Sports, Theater)




