# THIS REPOSITORY IS ARCHIVED! 

This repository was archived, because it was written in PHP 7.4 using my old SDK. I am going to replace it with a mail manager, managing temp & permanent e-mail addresses! That repository is going to be private.
 
# Temp mail

Personal temporary e-mail service. Written using own [PHP SDK](https://github.com/lopatar/PHP-SDK).
****
Currently redirects to own [RoundCube](https://roundcube.net) instance for receiving/sending mail.

# Requirements

- Debian 11
- PHP 8.1
- MySQL/MariDB server
- Web server
- useradd, deluser & cron packages

# Installation

- Clone repository
- Make your web server match all requests to index.php (in NGINX with try_files directive)
- Import DB schema
- Edit app/config.php
- Install cron job

# Cron jobs

You should set up a cron job that invokes the app/cron/sys_accounts.php file using the PHP interpreter.

Such as:

```
* * * * * /usr/bin/php8.1 /var/www/html/temp-mail/app/cron/sys_accounts.php >/dev/null 2>&1
```
