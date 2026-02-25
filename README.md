
# Foodpanda Client App (SSO Client)

A Laravel-based client application that authenticates users using a centralized **Single Sign-On (SSO) Auth Server**.

This application does not manage authentication directly.  
Instead, it redirects users to the Auth Server and receives OAuth tokens.

---

# Features

- OAuth2 authentication via central Auth Server
- Single Sign-On login
- Laravel-based client application
- Token-based authentication
- Session management
- Database queue & cache support
- Secure authorization code flow

---

# Tech Stack

- Laravel 11
- OAuth2 Authorization Code Flow
- MySQL
- Vite Asset Bundler

---

# Requirements

Make sure your system has:

- PHP >= 8.2
- Composer
- Node.js >= 18
- npm
- MySQL / MariaDB
- Git

---

# ⚠️ Important — Setup Order

You **must run the Auth Server first** before setting up this project.

Auth Server Repository:
```

[http://127.0.0.1:8000](http://127.0.0.1:8000)

````

This app requires:

- SSO Client ID
- SSO Client Secret

These are generated from the Auth Server.

---

#  Installation Guide (Complete Setup)

Follow all steps carefully.

---

## 1️ Clone Project

```bash
git clone git@github.com:shariyabd/foodpanda.git
cd foodpanda
````

---

## 2️ Install Dependencies

```bash
composer install
npm install
```

---

## 3️ Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

---

## 4️ Configure Application URL

Update `.env`:

```env
APP_URL=http://127.0.0.1:8002
```

---

## 5️ Configure Database

Create database manually:

```sql
CREATE DATABASE foodpanda_app;
```

Update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foodpanda_app
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

## 6️ Configure SSO Connection (Required)

This app connects to the Auth Server.

Update `.env`:

```env
SSO_HOST=http://127.0.0.1:8000
SSO_CLIENT_ID=your-client-id
SSO_CLIENT_SECRET=your-client-secret
SSO_CALLBACK_URL=http://127.0.0.1:8002/auth/callback
SSO_SCOPES="user-read user-email"
```

---

##  How to Get `SSO_CLIENT_ID` and `SSO_CLIENT_SECRET`

You obtain these from the **Auth Server**.

### Option 1 — Seeder (Recommended)

Run on Auth Server:

```bash
php artisan db:seed
```

Copy:

```
Client ID
Client Secret
```

---

### Option 2 — Create Client Manually

```bash
php artisan sso:clients create \
--name="Foodpanda App" \
--redirect="http://127.0.0.1:8002/auth/callback"
```

---

### Option 3 — Refresh Secret

```bash
php artisan sso:clients refresh-secret --id=CLIENT_ID
```

---

## 7️ Create Required Tables

Your project uses:

* database queue
* database cache

Generate tables:

```bash
php artisan cache:table
php artisan queue:table
php artisan migrate
```

---

## 98 Link Storage (Recommended)

```bash
php artisan storage:link
```

---

## 9 Run Application

```bash
php artisan serve --port=8002
```

App runs at:

```
http://127.0.0.1:8002
```

---

#  Authentication Flow

1. User visits Foodpanda app
2. User clicks login
3. Redirect → Auth Server
4. User authenticates once
5. Auth Server returns authorization code
6. App exchanges code → access token
7. User logged in

---

#  OAuth Callback URL

Must match exactly with Auth Server configuration:

```
http://127.0.0.1:8002/auth/callback
```

Mismatch will cause authentication failure.

---

# Project Notes

```
This app acts only as OAuth client.

Auth logic handled by:
→ Central Auth Server
```

---

# Important Notes

* Auth Server must be running first.
* Redirect URL must match exactly.
* Client secret should never be committed.
* Never commit `.env` file.
* Use HTTPS in production.

---

# Troubleshooting

## Clear Cache

```bash
php artisan optimize:clear
```

---

## Migration Issues

```bash
php artisan migrate:fresh
```

---

## Permission Issues (Linux)

```bash
chmod -R 775 storage bootstrap/cache
```

---

## Invalid OAuth Redirect

Check:

* callback URL matches
* client ID correct
* client secret correct
* Auth Server running

---

# Production Deployment Notes

Before production:

* Set `APP_ENV=production`
* Set `APP_DEBUG=false`
* Use HTTPS
* Configure secure session cookies
* Use production database credentials
* Configure queue worker

---

# 👨‍💻 Author

Laravel SSO Client Application.

---

# 📄 License

MIT

