# Temp mail

Personal temporary e-mail service. Written using own [PHP SDK](https://github.com/lopatar/PHP-SDK).
****
Currently redirects to own [RoundCube](https://roundcube.net) instance for receiving/sending mail.
**IMAP support planned soon.**

# Installation

- Clone repository
- Make your web server match all requests to index.php (in NGINX with try_files directive)
- Import DB schema
- Edit app/config.php