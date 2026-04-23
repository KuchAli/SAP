# SAP : The Book Lending Application System

**The book lending application system** is a system that I designed for library admins to make it easier to process library member data when borrowing books..


<img src="{{ asset('iimages/gambar.png') }}" alt="images Dashboard Admin" width="700" class="align-items-center"/>


## Initial Preperation

Before installation, make sure your system meets the following prerequisites:
- **PHP** v7.4 or newest 
- **Composer**
- **Web Server** (Apache/Nginx)
- **Database** (MySQL/MariaDB/SQLite)

Then, Download via ZIP

Make sure you are in this project directory and have run:
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

## Feature 

in this system the main feature is CRUD, This CRUD is only for book data, loans, users/members and rates.
- **Form Book Data**: Create,Read,Update and Delete book data.
- **Form  Users/Members Data**: Create,Read,Update and Delete users/member data.
- **Form  Loans Data**: Create,Read,Update and Delete loans data.
- **Interface User-Friendly**: Modern and responsive interface for both desktop and mobile.
