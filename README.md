# 🏥 Legian Medical Clinic (LMC)

A modern, multi-language medical clinic management system built with Laravel 12. Features a beautiful landing page for visitors and a powerful admin panel for content management.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)

## ✨ Features

### 🌐 Landing Page
- **Responsive Design** - Beautiful, mobile-friendly interface
- **Multi-language Support** - Indonesian & English (JSON-based translations)
- **Dynamic Content** - Header, About, Services, Doctors, Articles
- **Contact Information** - Phone, email, address, WhatsApp, social media links
- **Google Maps Integration** - Embedded clinic location
- **User Preference Modal** - Personalized content navigation

### 👨‍💼 Admin Panel
- **Role-based Access Control** - Owner & Admin roles
- **Content Management**
  - ✏️ Header Settings (title, tagline, logo)
  - 📞 Contact Information (multi-channel)
  - ℹ️ About Section (vision, mission, description)
  - 💼 Services CRUD
  - 👨‍⚕️ Doctors CRUD
  - 📰 Articles CRUD with publishing
- **User Management** (Owner only)
- **Dashboard Analytics**
- **Multi-language Content Editor**

## 🛠️ Tech Stack

- **Framework:** Laravel 12.x
- **PHP:** 8.2+
- **Database:** MySQL/MariaDB
- **Authentication:** Laravel Breeze
- **Frontend:** Blade Templates, Bootstrap 5
- **Translation:** Spatie Laravel Translatable
- **Package Manager:** Composer, NPM

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Git

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/aryaintarann/lmc.git
cd lmc
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lmc
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations & Seeders

```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

**Default Credentials:**
- **Owner:** owner@lmc.com / password
- **Admin:** admin@lmc.com / password

### 6. Build Assets

```bash
# For development
npm run dev

# For production
npm run build
```

### 7. Start Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

### 8. Google Cloud Translation Setup (Optional but Recommended)

For auto-translation feature, follow the detailed guide in [GOOGLE_CLOUD_SETUP.md](GOOGLE_CLOUD_SETUP.md).

**Quick Setup:**
1. Create a Google Cloud project
2. Enable Cloud Translation API
3. Create Service Account and download JSON key
4. Save key to `storage/app/google-cloud/service-account-key.json`
5. Update `.env` with your project ID:
   ```env
   GOOGLE_CLOUD_PROJECT_ID=your-project-id
   GOOGLE_CLOUD_KEY_FILE=google-cloud/service-account-key.json
   ```

**Without Google Cloud:** The app will still work, but dynamic content won't be auto-translated. Admin must manually provide translations for all content.

## 📚 Database Structure

### Core Tables

#### headers
- `title` (JSON: id, en) - Site title
- `tagline` (JSON: id, en) - Site tagline
- `logo` - Logo image path

#### contacts
- `address` (JSON: id, en) - Clinic address
- `phone` - Phone number
- `email` - Email address
- `whatsapp` - WhatsApp number
- `maps_embed` - Google Maps embed code
- `facebook` - Facebook URL
- `instagram` - Instagram URL

#### abouts
- `title` (JSON: id, en) - About title
- `description` (JSON: id, en) - About description
- `vision` (JSON: id, en) - Clinic vision
- `mission` (JSON: id, en) - Clinic mission
- `image` - About image

#### services
- `title` (JSON: id, en) - Service name
- `description` (JSON: id, en) - Service description
- `icon` - Icon identifier

#### doctors
- `name` - Doctor name
- `specialty` (JSON: id, en) - Specialization
- `bio` (JSON: id, en) - Biography
- `image` - Doctor photo

#### articles
- `title` (JSON: id, en) - Article title
- `excerpt` (JSON: id, en) - Short excerpt
- `content` (JSON: id, en) - Full content
- `image` - Article image
- `published_at` - Publication date

#### users
- `name` - User name
- `email` - Email (unique)
- `password` - Hashed password
- `role` - Role (owner/admin)

## 🎯 Usage

### Landing Page
Access the public landing page at `/`

Features:
- View clinic information
- Browse services and doctors
- Read health articles
- Contact information with map
- Language switcher (ID/EN)

### Admin Panel
Access admin panel at `/admin`

**Owner Capabilities:**
- Full admin access +
- User management (create/edit/delete admins)

**Admin Capabilities:**
- Manage header settings
- Manage contact information
- Manage about section
- CRUD services
- CRUD doctors
- CRUD articles (with publish/unpublish)

## 🌍 Multi-language Support

Content is stored in JSON format for easy translation:

```php
// Example: Service title
'title' => [
    'id' => 'Layanan Darurat',
    'en' => 'Emergency Care'
]
```

Access translated content:
```php
$service->title['id']; // Indonesian
$service->title['en']; // English
```

### ✨ Auto-Translation Feature

**NEW:** The app now features automatic translation powered by **Google Cloud Translation API**!

**How it works:**
1. Admin creates content in their preferred language (e.g., Indonesian)
2. When a visitor switches to English, content is automatically translated using Google Cloud
3. Translations are cached for performance and to minimize API calls
4. Manual translations can override auto-translations anytime

**Benefits:**
- ✅ No need to manually translate all content
- ✅ Instant translation for new content
- ✅ Free tier: 500,000 characters/month
- ✅ Cached results for better performance

**Setup:** Follow [GOOGLE_CLOUD_SETUP.md](GOOGLE_CLOUD_SETUP.md) for complete instructions.


## 🔐 Security

- CSRF protection on all forms
- Password hashing with bcrypt
- Role-based access control
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade escaping)
- Session security

## 📁 Project Structure

```
lmc/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   └── LandingController.php
│   └── Models/             # Eloquent models
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/           # Database seeders
├── resources/
│   └── views/
│       ├── admin/         # Admin views
│       ├── landing.blade.php
│       └── layouts/       # Shared layouts
└── public/
    └── storage/           # Uploaded files
```

## 🧪 Testing

```bash
# Run tests
php artisan test
```

## 📝 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**Arya Intaran**
- GitHub: [@aryaintarann](https://github.com/aryaintarann)

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'feat: add some amazing feature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

**Commit Convention:** We use [Semantic Commit Messages](https://www.conventionalcommits.org/)

## 🐛 Known Issues

None at the moment. Please report any issues on the [Issues](https://github.com/aryaintarann/lmc/issues) page.

## 🗺️ Roadmap

- [ ] Add appointment booking system
- [ ] Email notification system
- [ ] Patient portal
- [ ] Online consultation
- [ ] Payment gateway integration
- [ ] API for mobile app

## 📞 Support

For support, email support@legianmedical.com or create an issue on GitHub.

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [Bootstrap](https://getbootstrap.com) - UI Framework
- [Spatie](https://spatie.be) - Translation package
- All contributors who helped with this project

---

Made with ❤️ by Arya Intaran
