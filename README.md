# Temp mail

Personal temporary e-mail service. Written using own [PHP SDK](https://github.com/lopatar/PHP-SDK).
****
Currently redirects to own [RoundCube](https://roundcube.net) instance for receiving/sending mail.
**IMAP support planned soon.**

# Requirements
- PHP 8.1
- MySQL/MariDB server
- Web server
- useradd, deluser & cron packages

# Installation

- Clone repository
- Make your web server matches all requests to index.php (in NGINX with try_files directive)
- Import DB schema
- Edit app/config.php
- Install cron job

# Cron jobs

You should set up a cron job that invokes the app/cron/sys_accounts.php file using the PHP interpreter.

Such as:
```
* * * * * /usr/bin/php8.1 /var/www/html/temp-mail/app/cron/sys_accounts.php >/dev/null 2>&1
```