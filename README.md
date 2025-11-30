## 🎫 Eventify - E-Ticketing Platform
Platform e-ticketing event modern yang memudahkan pengguna menemukan, memesan tiket, dan mengelola acara dengan antarmuka yang intuitif.
---
## ✨ Fitur Utama
## 👥 Multi-Level User System
- Admin - Akses penuh manajemen sistem
- Event Organizer - Kelola event dan tiket
- Registered User - Booking tiket dan favorit event
- Guest - Jelajahi event tanpa login
---

## Struktur Project
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
│   │   └── framework/
│   │       ├── cache/
│   │       ├── sessions/
│   │       ├── testing/
│   │       └── views/
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

### 🗄 Database Schema
```plaintext
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
