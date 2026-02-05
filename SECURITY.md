# Security Policy

## Reporting a Vulnerability

The Habifarm team takes security seriously. We appreciate your efforts to responsibly disclose your findings.

### How to Report

**DO NOT** create a public GitHub issue for security vulnerabilities.

Instead, please report security issues via one of these methods:

1. **Email (Preferred):**
   - Send details to the repository maintainer
   - Use subject line: `[SECURITY] Brief description`
   - Include as much detail as possible (see below)

2. **GitHub Security Advisory:**
   - Go to the repository's Security tab
   - Click "Report a vulnerability"
   - Fill in the form with details

### What to Include in Your Report

Please provide the following information:

1. **Description** of the vulnerability
2. **Steps to reproduce** the issue
3. **Potential impact** (what an attacker could do)
4. **Affected versions** or components
5. **Proof of concept** (if available)
6. **Suggested fix** (if you have one)

**Example Report:**

```markdown
Subject: [SECURITY] SQL Injection in Equipment Search

Description:
The equipment search functionality is vulnerable to SQL injection
through the 'category' parameter.

Steps to Reproduce:
1. Navigate to /equipment/search
2. Enter the following in the search box: ' OR '1'='1
3. Observe unintended database query results

Impact:
An attacker could potentially:
- Extract sensitive database information
- Bypass authentication
- Modify or delete data

Affected Component:
File: habifarm/app/public/wp-content/plugins/custom/search.php
Line: 45

Proof of Concept:
[Include screenshot or code snippet]

Suggested Fix:
Use prepared statements or sanitize input with wpdb->prepare()
```

### Response Timeline

- **Initial Response:** Within 48 hours of report
- **Status Update:** Within 7 days
- **Fix Timeline:** Depends on severity
  - Critical: 7-14 days
  - High: 14-30 days
  - Medium: 30-60 days
  - Low: 60-90 days

### Disclosure Policy

- We will acknowledge receipt of your report
- We will provide an estimated timeline for a fix
- We will notify you when the fix is released
- We will credit you in our security advisory (unless you prefer to remain anonymous)

**Coordinated Disclosure:**
- Please allow us time to fix the issue before public disclosure
- We aim to coordinate disclosure timing with you
- Typical embargo period: 90 days from initial report

## Security Considerations

### Current Security Status

This project is in **prototype/hackathon** stage. It has known security limitations:

### Known Security Issues

#### Critical (Immediate attention needed in production)

1. **Default Database Credentials**
   - Location: `habifarm/app/public/wp-config.php`
   - Issue: Hardcoded `root:root` credentials
   - Risk: Unauthorized database access
   - Mitigation: Change before deploying to production

2. **Missing WordPress Security Keys**
   - Location: `habifarm/app/public/wp-config.php`
   - Issue: Authentication salts not configured
   - Risk: Session hijacking, authentication bypass
   - Mitigation: Generate at https://api.wordpress.org/secret-key/1.1/salt/

3. **Plain Text Password Storage (C++/JS)**
   - Location: `Cpp Impelemtation/mainFile.cpp`, `Javascript implementation/Habibit.js`
   - Issue: Passwords stored as `username:password` strings
   - Risk: Credential theft if memory/storage compromised
   - Mitigation: Reference implementation only - DO NOT use in production

#### High (Important for production deployments)

4. **No HTTPS Enforcement**
   - Location: `habifarm/conf/nginx/site.conf.hbs`
   - Issue: HTTP only, no SSL/TLS configuration
   - Risk: Man-in-the-middle attacks, credential interception
   - Mitigation: Configure SSL certificates and force HTTPS

5. **Insufficient Input Validation**
   - Location: Various (C++/JS implementations)
   - Issue: User input not validated
   - Risk: Injection attacks, buffer overflows
   - Mitigation: Add input validation and sanitization

6. **No Rate Limiting**
   - Location: Server configuration
   - Issue: No protection against brute force
   - Risk: Password cracking, DoS attacks
   - Mitigation: Implement rate limiting (fail2ban, nginx limit_req)

#### Medium

7. **Debug Mode Enabled**
   - Location: `wp-config.php` (if WP_DEBUG = true)
   - Issue: Error messages expose system information
   - Risk: Information disclosure
   - Mitigation: Disable debug mode in production

8. **File Upload Vulnerabilities**
   - Location: WordPress media uploads
   - Issue: Limited validation on file uploads
   - Risk: Malicious file uploads
   - Mitigation: Implement strict file type validation

9. **SQL Injection (Potential)**
   - Location: Custom plugin code (if any)
   - Issue: Direct SQL queries without prepared statements
   - Risk: Database compromise
   - Mitigation: Use WordPress $wpdb->prepare() for all queries

### Secure Configuration Guide

#### 1. WordPress Security Hardening

**wp-config.php:**

```php
<?php
// Change database credentials
define( 'DB_NAME', 'habifarm_prod' );
define( 'DB_USER', 'habifarm_secure_user' );
define( 'DB_PASSWORD', 'STRONG_RANDOM_PASSWORD' );
define( 'DB_HOST', 'localhost' );

// Generate unique keys from https://api.wordpress.org/secret-key/1.1/salt/
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

// Disable debug in production
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );

// Disable file editing from admin
define( 'DISALLOW_FILE_EDIT', true );

// Force SSL for admin
define( 'FORCE_SSL_ADMIN', true );

// Set auto-save interval (seconds)
define( 'AUTOSAVE_INTERVAL', 300 );

// Limit post revisions
define( 'WP_POST_REVISIONS', 5 );
```

**File Permissions:**

```bash
# WordPress root
find /var/www/habifarm -type d -exec chmod 755 {} \;
find /var/www/habifarm -type f -exec chmod 644 {} \;

# wp-config.php
chmod 600 /var/www/habifarm/wp-config.php

# Uploads directory (writable)
chmod 755 /var/www/habifarm/wp-content/uploads

# .htaccess (if using Apache)
chmod 644 /var/www/habifarm/.htaccess
```

#### 2. Web Server Security

**Nginx Configuration:**

```nginx
server {
    listen 80;
    server_name habifarm.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name habifarm.com;
    
    # SSL Configuration
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;
    
    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' https:;" always;
    
    # Hide Nginx version
    server_tokens off;
    
    # Rate limiting
    limit_req_zone $binary_remote_addr zone=login:10m rate=5r/m;
    
    location /wp-login.php {
        limit_req zone=login burst=5 nodelay;
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php-fpm.sock;
    }
    
    # Block access to sensitive files
    location ~ /\.(?!well-known) {
        deny all;
    }
    
    location ~ /wp-config.php {
        deny all;
    }
    
    # Rest of configuration...
}
```

#### 3. Database Security

```bash
# Create dedicated database user with limited privileges
mysql -u root -p

CREATE USER 'habifarm_user'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD';
GRANT SELECT, INSERT, UPDATE, DELETE ON habifarm_db.* TO 'habifarm_user'@'localhost';
FLUSH PRIVILEGES;

# Remove root access from network
DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');
FLUSH PRIVILEGES;

# Regular backups
mysqldump -u habifarm_user -p habifarm_db > backup_$(date +%Y%m%d).sql
```

#### 4. WordPress Plugins Security

```bash
# Keep all plugins updated
wp plugin update --all

# Remove unused plugins
wp plugin list --status=inactive
wp plugin delete <plugin-name>

# Use security plugins
wp plugin install wordfence --activate
# OR
wp plugin install sucuri-scanner --activate
```

### Security Checklist for Production

- [ ] Change default database credentials
- [ ] Generate and set WordPress security keys
- [ ] Disable WordPress debug mode
- [ ] Configure SSL/TLS certificates
- [ ] Enable HTTPS enforcement
- [ ] Set proper file permissions
- [ ] Disable file editing from admin panel
- [ ] Implement rate limiting
- [ ] Configure security headers
- [ ] Hide web server version
- [ ] Set up Web Application Firewall (WAF)
- [ ] Enable automated backups
- [ ] Configure monitoring and alerts
- [ ] Implement intrusion detection
- [ ] Regular security updates
- [ ] Use strong passwords (minimum 16 characters)
- [ ] Enable two-factor authentication
- [ ] Restrict admin access by IP (if possible)
- [ ] Regular security audits

### Development vs Production

| Feature | Development | Production |
|---------|-------------|------------|
| WP_DEBUG | true | false |
| DB Password | simple | strong, random |
| HTTPS | optional | required |
| File Permissions | relaxed | strict |
| Error Display | verbose | hidden |
| Rate Limiting | disabled | enabled |
| Security Headers | optional | required |

### Tools and Resources

**Security Scanning:**
- [WPScan](https://wpscan.com/) - WordPress security scanner
- [Sucuri SiteCheck](https://sitecheck.sucuri.net/) - Website malware scanner
- [Security Headers](https://securityheaders.com/) - Check HTTP headers

**WordPress Security Plugins:**
- Wordfence Security
- Sucuri Security
- iThemes Security
- All In One WP Security & Firewall

**General Security:**
- [OWASP Top 10](https://owasp.org/www-project-top-ten/) - Common web vulnerabilities
- [WordPress Security Codex](https://wordpress.org/support/article/hardening-wordpress/)
- [WooCommerce Security](https://woocommerce.com/posts/woocommerce-security/)

## Vulnerability Handling Process

### For Reporters

1. **Submit** vulnerability report (private)
2. **Receive** acknowledgment (48 hours)
3. **Collaborate** with maintainers on fix
4. **Verify** fix in patch/update
5. **Receive** credit in security advisory

### For Maintainers

1. **Acknowledge** report receipt
2. **Assess** severity and impact
3. **Develop** fix in private branch
4. **Test** fix thoroughly
5. **Coordinate** disclosure with reporter
6. **Release** patch/update
7. **Publish** security advisory
8. **Credit** reporter (if desired)

## Security Updates

Security updates will be announced via:
- GitHub Security Advisories
- Repository README
- Release notes

Subscribe to repository notifications to stay informed.

## Contact

For security concerns not suitable for public GitHub issues, contact the repository maintainer directly through GitHub.

## Acknowledgments

We thank the following individuals for responsibly disclosing security issues:

- [List will be populated as issues are reported and fixed]

---

**Last Updated:** 2026-02-05  
**Version:** 1.0
