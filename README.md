# Laravel Authentication & Authorization System

## 📋 Project Overview

This project is a comprehensive authentication and authorization system built on Laravel 12 framework. It provides complete user, role, and permission management with a modern and responsive admin interface.

## ✨ Key Features

### 🔐 Authentication System

- Password-based login
- Passwordless login (Magic Links)
- Social media login (Google, Facebook, GitHub)
- Account verification via OTP (SMS/Email)
- Password reset functionality
- Session and device management
- Logout from all devices

### 🛡️ Authorization System

- Role Management
- Permission Management
- User-Role assignment
- Permission-based middleware
- Advanced admin interface for permission management

### 👥 User Management

- User listing and management
- User role assignment
- Profile management
- Password change functionality

## 🏗️ Project Structure

```
auth_authorize_12/
├── app/
│   ├── Console/
│   ├── Enums/
│   │   └── PermissionsEnum.php          # Permission definitions
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── RolesController.php  # Role management
│   │   │   │   └── UsersController.php  # User management
│   │   │   └── Auth/
│   │   │       ├── LoginController.php
│   │   │       ├── RegisterController.php
│   │   │       ├── ProfileController.php
│   │   │       ├── UpdateProfileController.php
│   │   │       ├── ChangePasswordController.php
│   │   │       ├── ResetPasswordController.php
│   │   │       ├── ForgetPasswordController.php
│   │   │       ├── VerifyAccountController.php
│   │   │       ├── PasswordLessLoginController.php
│   │   │       └── SocialAuthController.php
│   │   ├── Middleware/
│   │   │   ├── RoleMiddleware.php       # Role verification
│   │   │   └── PermissionMiddleware.php # Permission verification
│   │   └── Requests/
│   │       └── Admin/
│   │           └── Roles/
│   │               ├── CreateRoleRequest.php
│   │               └── UpdateRoleRequest.php
│   ├── Mail/
│   ├── Models/
│   │   ├── User.php                     # User model
│   │   ├── Role.php                     # Role model
│   │   ├── Permission.php               # Permission model
│   │   └── Session.php                  # Session model
│   ├── Policies/
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   └── Services/
├── config/
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2025_08_04_184804_create_roles_table.php
│   │   ├── 2025_08_04_215557_create_permissions_table.php
│   │   ├── 2025_08_04_215804_create_permission_role_table.php
│   │   ├── 2025_08_04_185046_create_role_user_table.php
│   │   └── ... (other migrations)
│   └── seeders/
├── public/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   └── roles/
│   │   │       └── index.blade.php      # Role management interface
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   ├── register.blade.php
│   │   │   ├── profile.blade.php
│   │   │   └── ... (authentication pages)
│   │   ├── pages/
│   │   │   ├── admin.blade.php
│   │   │   ├── teacher.blade.php
│   │   │   └── student.blade.php
│   │   └── emails/
│   └── css/
├── routes/
│   └── web.php                          # Route definitions
├── storage/
├── tests/
└── vendor/
```

## 🗄️ Database Structure

### Main Tables

#### 1. `users` - Users Table

```sql
- id (Primary Key)
- name
- email (Unique)
- phone
- password
- email_verified_at
- otp
- otp_expires_at
- remember_token
- created_at
- updated_at
```

#### 2. `roles` - Roles Table

```sql
- id (Primary Key)
- role (Unique)
- created_at
- updated_at
```

#### 3. `permissions` - Permissions Table

```sql
- id (Primary Key)
- name (Unique)
- created_at
- updated_at
```

#### 4. `role_user` - User-Role Relationship Table

```sql
- role_id (Foreign Key)
- user_id (Foreign Key)
- created_at
- updated_at
```

#### 5. `permission_role` - Permission-Role Relationship Table

```sql
- permission_id (Foreign Key)
- role_id (Foreign Key)
- created_at
- updated_at
```

## 🔧 System Requirements

### Prerequisites

- **PHP**: 8.2 or higher
- **Composer**: 2.0 or higher
- **Node.js**: 18 or higher
- **NPM**: 9 or higher
- **Laravel**: 12.0

### Required Packages

```json
{
    "php": "^8.2",
    "laravel/framework": "^12.0",
    "laravel/sanctum": "^4.0",
    "laravel/socialite": "^5.23",
    "buzz/laravel-google-captcha": "^2.3",
    "jenssegers/agent": "^2.6",
    "propaganistas/laravel-phone": "^6.0"
}
```

## 🚀 Installation & Setup

### 1. Clone the Project

```bash
git clone <repository-url>
cd auth_authorize_12
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration

```bash
# Edit database settings in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Run Seeders (Optional)

```bash
php artisan db:seed
```

### 7. Create Storage Link

```bash
php artisan storage:link
```

### 8. Start the Application

```bash
# Start the server
php artisan serve

# In a separate terminal - Start Vite
npm run dev

# Or run everything together
composer run dev
```

## 🔐 Social Authentication Setup

### Google OAuth Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project
3. Enable Google+ API
4. Create OAuth 2.0 credentials
5. Add credentials to `.env` file:

```env
GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### Facebook OAuth Setup

1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Create a new app
3. Add credentials to `.env` file:

```env
FACEBOOK_CLIENT_ID=your_client_id
FACEBOOK_CLIENT_SECRET=your_client_secret
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback
```

## 📱 Available Permissions

### Role Permissions

- `view_roles` - View roles list
- `view_role` - View specific role
- `create_role` - Create new role
- `update_role` - Update existing role
- `delete_role` - Delete role

### User Permissions

- `view_users` - View users list
- `view_user` - View specific user
- `change_user_roles` - Change user roles

### Page Permissions

- `teacher_view` - Access teacher page
- `student_view` - Access student page
- `admin_view` - Access admin page

## 🛠️ Usage

### Role & Permission Management

#### 1. Access Admin Interface

```
http://localhost:8000/roles
```

#### 2. Create New Role

- Click "Add Role" button
- Enter role name
- Select required permissions
- Click "Save"

#### 3. Edit Existing Role

- Click "Edit" button next to the role
- Modify role name or permissions
- Click "Update"

#### 4. Delete Role

- Click "Delete" button next to the role
- Confirm deletion

### User Management

#### 1. View Users

```
http://localhost:8000/users
```

#### 2. Change User Role

- Click "Change Role" next to the user
- Select new role
- Click "Update"

## 🔒 Security

### Used Middleware

- `auth` - Authentication check
- `role:Admin` - Role verification
- `permission:view_roles` - Permission verification

### CSRF Protection

All forms are protected against CSRF attacks using Laravel's built-in protection.

### Password Hashing

Passwords are hashed using Laravel's Hash facade.

## 🧪 Testing

### Run Tests

```bash
# Run all tests
php artisan test

# Or
composer run test
```

### Run Specific Tests

```bash
php artisan test --filter=UserTest
```

## 📧 Email Configuration

### SMTP Setup

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### WhatsApp Setup (Optional)

```env
WHATSAPP_API_KEY=your_whatsapp_api_key
WHATSAPP_PHONE_NUMBER=your_whatsapp_number
```

## 🚀 Deployment

### Production Setup

```bash
# Optimize the application
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link
```

### Required Production Environment Variables

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

## 🤝 Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License. See the `LICENSE` file for details.

## 📞 Support

If you encounter any issues or have questions:

- Open a new Issue on GitHub
- Check the documentation
- Contact the development team

## 🔄 Updates

### Current Version: 1.0.0

- Complete authentication system
- Role and permission management
- Modern admin interface
- Social authentication support
- Passwordless login

### Planned Updates

- [ ] Add more social authentication providers
- [ ] Improve user interface
- [ ] Add reports and statistics
- [ ] Two-factor authentication (2FA) support
- [ ] API endpoints for mobile apps

---

**This project is developed using Laravel 12 and PHP 8.3 By Abdallh Elzayat**
