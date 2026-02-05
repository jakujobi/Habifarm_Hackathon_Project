# Habifarm Development Guide

This document provides comprehensive setup instructions and development workflows for contributors to the Habifarm project.

## Table of Contents

- [Development Environment Setup](#development-environment-setup)
- [Project Structure](#project-structure)
- [Running the Project](#running-the-project)
- [Development Workflows](#development-workflows)
- [Testing](#testing)
- [Code Style](#code-style)
- [Troubleshooting](#troubleshooting)

## Development Environment Setup

### Prerequisites

Ensure you have the following installed:

#### For WordPress Development

- **PHP 7.4 or higher**
  ```bash
  # Check PHP version
  php -v
  
  # Required extensions
  php -m | grep -E "mysqli|gd|curl|zip|xml|mbstring"
  ```

- **MySQL 8.0+ or MariaDB 10.3+**
  ```bash
  # Check MySQL version
  mysql --version
  ```

- **Web Server** (one of the following):
  - Nginx 1.18+
  - Apache 2.4+

- **Composer** (PHP dependency manager)
  ```bash
  # Install Composer
  curl -sS https://getcomposer.org/installer | php
  sudo mv composer.phar /usr/local/bin/composer
  ```

#### For C++ Development

- **g++ compiler with C++11 support**
  ```bash
  # Check g++ version
  g++ --version
  
  # Install on Ubuntu/Debian
  sudo apt-get install build-essential
  
  # Install on macOS
  xcode-select --install
  ```

#### For JavaScript Development

- **Node.js 14+** (optional, for testing)
  ```bash
  # Check Node version
  node --version
  
  # Install using nvm (recommended)
  curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
  nvm install 14
  ```

### Initial Setup

#### 1. Clone the Repository

```bash
git clone https://github.com/jakujobi/Habifarm_Hackathon_Project.git
cd Habifarm_Hackathon_Project
```

#### 2. Database Setup

```bash
# Start MySQL service
sudo systemctl start mysql  # Linux
# or
brew services start mysql   # macOS

# Create database
mysql -u root -p <<EOF
CREATE DATABASE habifarm_dev CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;
GRANT ALL PRIVILEGES ON habifarm_dev.* TO 'habifarm_user'@'localhost' IDENTIFIED BY 'secure_password';
FLUSH PRIVILEGES;
EOF

# Import initial data
mysql -u root -p habifarm_dev < habifarm/app/sql/local.sql
```

#### 3. WordPress Configuration

```bash
# Copy WordPress files to web root
sudo mkdir -p /var/www/habifarm-dev
sudo cp -r habifarm/app/public/* /var/www/habifarm-dev/

# Set ownership
sudo chown -R www-data:www-data /var/www/habifarm-dev  # Linux
# or
sudo chown -R _www:_www /var/www/habifarm-dev  # macOS

# Set permissions
sudo find /var/www/habifarm-dev -type d -exec chmod 755 {} \;
sudo find /var/www/habifarm-dev -type f -exec chmod 644 {} \;
sudo chmod -R 775 /var/www/habifarm-dev/wp-content/uploads
```

#### 4. Configure wp-config.php

Edit `/var/www/habifarm-dev/wp-config.php`:

```php
// Update database credentials
define( 'DB_NAME', 'habifarm_dev' );
define( 'DB_USER', 'habifarm_user' );
define( 'DB_PASSWORD', 'secure_password' );
define( 'DB_HOST', 'localhost' );

// Generate and add security keys from:
// https://api.wordpress.org/secret-key/1.1/salt/
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
// ... add all keys

// Enable debug mode for development
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'SCRIPT_DEBUG', true );
```

#### 5. Web Server Configuration

**For Nginx:**

Create `/etc/nginx/sites-available/habifarm-dev`:

```nginx
server {
    listen 80;
    server_name habifarm.local;
    root /var/www/habifarm-dev;
    
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$args;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~* \.(jpg|jpeg|gif|png|css|js|ico|xml)$ {
        expires 5d;
    }
}
```

```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/habifarm-dev /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# Add to /etc/hosts
echo "127.0.0.1 habifarm.local" | sudo tee -a /etc/hosts
```

**For Apache:**

Create `/etc/apache2/sites-available/habifarm-dev.conf`:

```apache
<VirtualHost *:80>
    ServerName habifarm.local
    DocumentRoot /var/www/habifarm-dev
    
    <Directory /var/www/habifarm-dev>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/habifarm-error.log
    CustomLog ${APACHE_LOG_DIR}/habifarm-access.log combined
</VirtualHost>
```

```bash
# Enable site and required modules
sudo a2ensite habifarm-dev
sudo a2enmod rewrite
sudo systemctl reload apache2

# Add to /etc/hosts
echo "127.0.0.1 habifarm.local" | sudo tee -a /etc/hosts
```

#### 6. Complete WordPress Installation

```bash
# Visit in browser
http://habifarm.local

# OR use WP-CLI
wp core install \
  --url="http://habifarm.local" \
  --title="Habifarm Development" \
  --admin_user="admin" \
  --admin_password="admin_password" \
  --admin_email="admin@habifarm.local"
```

## Project Structure

```
Habifarm_Hackathon_Project/
├── Cpp Impelemtation/              # C++ reference implementation
│   ├── Habibit.h                   # Header file with class definitions
│   ├── Habibit.cpp                 # Class implementations
│   ├── mainFile.cpp                # Main program with menu system
│   ├── Habibit Main.cpp            # Alternative main file
│   └── Javascript implementation/
│       └── Habibit.js              # JavaScript version
├── habifarm/                       # WordPress platform
│   ├── app/
│   │   ├── public/                 # WordPress root
│   │   │   ├── wp-admin/           # Admin dashboard
│   │   │   ├── wp-content/
│   │   │   │   ├── plugins/        # Installed plugins
│   │   │   │   │   ├── dc-woocommerce-multi-vendor/
│   │   │   │   │   ├── woocommerce/
│   │   │   │   │   ├── elementor/
│   │   │   │   │   └── ajax-search-for-woocommerce/
│   │   │   │   └── themes/         # Installed themes
│   │   │   │       ├── astra/      # Active theme
│   │   │   │       └── twentytwentythree/
│   │   │   └── wp-config.php       # WordPress config
│   │   └── sql/
│   │       └── local.sql           # Database dump
│   ├── conf/                       # Server configurations
│   │   ├── nginx/                  # Nginx config templates
│   │   ├── php/                    # PHP config templates
│   │   └── mysql/                  # MySQL config templates
│   └── logs/                       # Application logs
├── Habifarm Logo Design/           # Brand assets
├── Site Media/                     # Marketing images/videos
├── docs/                           # Documentation
│   ├── ARCHITECTURE.md
│   └── DEVELOPMENT.md (this file)
├── LICENSE
└── README.md
```

### Key Directories for Development

- **WordPress Customization:** `habifarm/app/public/wp-content/`
- **Theme Development:** `habifarm/app/public/wp-content/themes/astra/`
- **Plugin Development:** `habifarm/app/public/wp-content/plugins/`
- **C++ Logic:** `Cpp Impelemtation/`
- **JavaScript Logic:** `Cpp Impelemtation/Javascript implementation/`

## Running the Project

### WordPress Platform

```bash
# Ensure services are running
sudo systemctl status nginx   # or apache2
sudo systemctl status mysql
sudo systemctl status php-fpm # if using Nginx

# Access the site
http://habifarm.local

# Admin dashboard
http://habifarm.local/wp-admin
# Default credentials from local.sql (check database)
```

### C++ Application

```bash
cd "Cpp Impelemtation"

# Compile
g++ -std=c++11 -Wall -Wextra mainFile.cpp Habibit.cpp -o habibit

# Run
./habibit

# Alternative main file
g++ -std=c++11 "Habibit Main.cpp" -o habibit_main
./habibit_main
```

### JavaScript Application

```bash
cd "Cpp Impelemtation/Javascript implementation"

# Run in Node.js (limited, requires prompt support)
node Habibit.js

# OR open in browser console
# 1. Open browser DevTools (F12)
# 2. Copy/paste Habibit.js content
# 3. Interact via prompts
```

## Development Workflows

### Working on WordPress Theme

```bash
# Navigate to theme directory
cd habifarm/app/public/wp-content/themes/astra

# Make changes to PHP files
# Changes are reflected immediately (no build step)

# Check error logs
tail -f habifarm/logs/error.log
# or
tail -f /var/log/nginx/error.log
```

### Creating a Custom Plugin

```bash
# Create plugin directory
cd habifarm/app/public/wp-content/plugins
mkdir habifarm-custom
cd habifarm-custom

# Create main plugin file
cat > habifarm-custom.php <<'EOF'
<?php
/**
 * Plugin Name: Habifarm Custom Features
 * Description: Custom functionality for Habifarm
 * Version: 1.0.0
 * Author: Your Name
 */

// Add your custom code here
EOF

# Activate via wp-admin or WP-CLI
wp plugin activate habifarm-custom
```

### Modifying C++ Logic

```bash
cd "Cpp Impelemtation"

# Edit header file
nano Habibit.h

# Edit implementation
nano Habibit.cpp

# Compile with debug symbols
g++ -std=c++11 -g -Wall mainFile.cpp Habibit.cpp -o habibit_debug

# Run with GDB for debugging
gdb ./habibit_debug
```

### Database Changes

```bash
# Export current database
mysqldump -u habifarm_user -p habifarm_dev > backup_$(date +%Y%m%d).sql

# Make changes via wp-admin or mysql CLI
mysql -u habifarm_user -p habifarm_dev

# Update sql dump for repository
mysqldump -u habifarm_user -p habifarm_dev > habifarm/app/sql/local.sql
```

## Testing

### Manual Testing

#### WordPress Platform

1. **Test Vendor Registration**
   ```
   - Navigate to vendor registration page
   - Fill out application form
   - Admin approves via dashboard
   - Verify vendor can access vendor panel
   ```

2. **Test Equipment Listing**
   ```
   - Log in as vendor
   - Add new equipment product
   - Set pricing and description
   - Verify appears in catalog
   ```

3. **Test Rental Flow**
   ```
   - Log in as borrower
   - Browse equipment
   - Add to cart
   - Proceed to checkout
   - Verify order creation
   ```

#### C++ Application

```bash
./habibit

# Test flow:
# 1. Create account
# 2. Sign in
# 3. Add equipment (as lender)
# 4. Logout and sign in again
# 5. Borrow equipment (as borrower)
# 6. Verify cost calculation (2.5% tax)
```

### Automated Testing

**Note:** No automated tests currently exist. Future additions recommended:

```bash
# WordPress (PHPUnit) - NOT YET IMPLEMENTED
# composer require --dev phpunit/phpunit
# ./vendor/bin/phpunit tests/

# C++ (Google Test) - NOT YET IMPLEMENTED
# Future: Unit tests for Equipment, Lender, Borrower classes

# JavaScript (Jest) - NOT YET IMPLEMENTED
# npm install --save-dev jest
# npm test
```

## Code Style

### PHP (WordPress)

Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/):

```php
// Use tabs for indentation
// Space after control structures
if ( condition ) {
    do_something();
}

// Yoda conditions for comparisons
if ( 'value' === $variable ) {
    // ...
}

// Sanitize input, escape output
$safe_value = sanitize_text_field( $_POST['user_input'] );
echo esc_html( $output );
```

### C++

```cpp
// Use camelCase for variables and functions
int myVariable;
void myFunction() { }

// Use PascalCase for classes
class MyClass { };

// Indentation: 4 spaces
void function() {
    if (condition) {
        doSomething();
    }
}

// Include guards in headers
#ifndef MYHEADER_H
#define MYHEADER_H
// ...
#endif
```

### JavaScript

```javascript
// Use camelCase for variables and functions
const myVariable = 'value';
function myFunction() { }

// Use PascalCase for classes
class MyClass { }

// Indentation: 2 spaces
function example() {
  if (condition) {
    doSomething();
  }
}
```

## Troubleshooting

### WordPress Issues

**White Screen of Death**
```bash
# Enable debug mode
# Edit wp-config.php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );

# Check error log
tail -f /var/www/habifarm-dev/wp-content/debug.log
```

**Database Connection Error**
```bash
# Verify database exists
mysql -u root -p -e "SHOW DATABASES LIKE 'habifarm%';"

# Test connection
mysql -u habifarm_user -p habifarm_dev -e "SELECT 1;"

# Check wp-config.php credentials
grep DB_ /var/www/habifarm-dev/wp-config.php
```

**Plugin Conflicts**
```bash
# Disable all plugins
wp plugin deactivate --all

# Enable one by one
wp plugin activate woocommerce
wp plugin activate dc-woocommerce-multi-vendor
# etc.
```

**Permission Issues**
```bash
# Fix ownership
sudo chown -R www-data:www-data /var/www/habifarm-dev

# Fix permissions
sudo find /var/www/habifarm-dev -type d -exec chmod 755 {} \;
sudo find /var/www/habifarm-dev -type f -exec chmod 644 {} \;
sudo chmod -R 775 /var/www/habifarm-dev/wp-content/uploads
```

### C++ Compilation Issues

**Linker Errors**
```bash
# Ensure all source files are included
g++ -std=c++11 mainFile.cpp Habibit.cpp -o habibit

# If using separate header
g++ -std=c++11 -I. mainFile.cpp Habibit.cpp -o habibit
```

**Runtime Errors**
```bash
# Add debug symbols
g++ -std=c++11 -g mainFile.cpp Habibit.cpp -o habibit

# Run with gdb
gdb ./habibit
# In gdb:
# run
# backtrace (if crash)
```

### Server Configuration Issues

**Nginx 403 Forbidden**
```bash
# Check file permissions
ls -la /var/www/habifarm-dev

# Check Nginx user
ps aux | grep nginx

# Update Nginx config user directive
sudo nano /etc/nginx/nginx.conf
# user www-data;
```

**502 Bad Gateway**
```bash
# Check PHP-FPM status
sudo systemctl status php-fpm

# Check socket path matches Nginx config
ls -l /var/run/php/

# Restart services
sudo systemctl restart php-fpm
sudo systemctl restart nginx
```

## Useful Commands

### WordPress (WP-CLI)

```bash
# Install WP-CLI
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
sudo mv wp-cli.phar /usr/local/bin/wp

# Common commands
wp plugin list                    # List plugins
wp theme list                     # List themes
wp user list                      # List users
wp db export backup.sql          # Export database
wp cache flush                   # Clear cache
wp rewrite flush                 # Flush permalinks
wp search-replace 'old' 'new'    # Search/replace in DB
```

### Database Management

```bash
# Create backup
mysqldump -u habifarm_user -p habifarm_dev > backup.sql

# Restore backup
mysql -u habifarm_user -p habifarm_dev < backup.sql

# Interactive session
mysql -u habifarm_user -p habifarm_dev

# Quick queries
mysql -u habifarm_user -p habifarm_dev -e "SELECT * FROM wp_users;"
```

### Git Workflow

```bash
# Create feature branch
git checkout -b feature/my-feature

# Make changes and commit
git add .
git commit -m "Add new feature"

# Push to remote
git push origin feature/my-feature

# Create pull request on GitHub
```

## Additional Resources

- [WordPress Developer Documentation](https://developer.wordpress.org/)
- [WooCommerce Developer Docs](https://woocommerce.github.io/code-reference/)
- [MultiVendorX Documentation](https://multivendorx.com/knowledgebase/)
- [C++ Reference](https://en.cppreference.com/)
- [MDN JavaScript Guide](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide)

## Getting Help

- Check [CONTRIBUTING.md](../CONTRIBUTING.md) for contribution guidelines
- Report issues on GitHub Issues
- Review [ARCHITECTURE.md](ARCHITECTURE.md) for system design questions
