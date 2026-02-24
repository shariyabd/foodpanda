# Foodpanda

A Laravel-based client application that authenticates users via a central SSO (Single Sign-On) Auth Server.

## Requirements

- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL

## Setup

### 1. Clone & install dependencies

```bash
git clone <repository-url>
cd foodpanda
composer install
npm install
```

### 2. Environment configuration

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and configure the following:

**Database**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foodpanda_app
DB_USERNAME=root
DB_PASSWORD=your_password
```

**SSO (required — obtain from the Auth Server)**
```env
SSO_HOST=http://127.0.0.1:8000
SSO_CLIENT_ID=your-client-id
SSO_CLIENT_SECRET=your-client-secret
SSO_CALLBACK_URL=http://127.0.0.1:8002/auth/callback
SSO_SCOPES="user-read user-email"
```

> The `SSO_CLIENT_ID` and `SSO_CLIENT_SECRET` are generated when you register this app as an OAuth client on the Auth Server.

**App URL**
```env
APP_URL=http://127.0.0.1:8002
```

### 3. Run migrations

```bash
php artisan migrate
```

### 4. Start the development server

```bash
composer run dev
```

This starts the Laravel server, queue worker, log watcher, and Vite asset compiler concurrently.

The app will be available at [http://127.0.0.1:8002](http://127.0.0.1:8002).

## SSO Client Registration

Before users can log in, this application must be registered as an OAuth client on the Auth Server:

1. Log in to the Auth Server admin panel.
2. Create a new OAuth client with the redirect URL set to `http://127.0.0.1:8002/auth/callback`.
3. Copy the generated **Client ID** and **Client Secret** into your `.env` as `SSO_CLIENT_ID` and `SSO_CLIENT_SECRET`.
