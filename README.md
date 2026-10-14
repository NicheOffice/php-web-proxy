PHP Online Web Proxy
====================

![](https://cdn.nicheoffice.web.tr/image/1172169776_.jpg)

Online web proxy hide you from the Internet. You don’t need install any plugin or software. You can surf the Internet with anonymity.

Features
--------

*   You can translate easily your language.
4 Working Modes

*   No encoding of any sort. People can link to proxy pages directly
*   Base64 encoding only, people can hotlink to your proxy
*   Unique to the IP address that generated it. A person that generated that URL, can bookmark it and visit it and any point
*   Unique to that session and IP address – URL no longer valid anywhere when that browser session that generated it ends

*   Blocks requests to local files, localhost and private networks by default.

Requirements
------------

*   PHP 8.2 or newer (tested on 8.2 and 8.5)
*   cURL extension

Installation
------------

The `vendor/` directory is included, so you can upload the files to your web server as they are.

1. Set a unique `app_key` in `config.php`.
2. Optionally adjust `url_mode`, the site name and the plugin list in `config.php`.
3. Edit `language.php` to translate the interface or write your Terms of Service.

To reinstall or update dependencies with [Composer](https://getcomposer.org/):

    composer install

The upstream [php-proxy](https://github.com/Athlon1600/php-proxy) library is no longer maintained.
Fixes for PHP 8.2+ are kept in `patches/php-proxy-php8.patch` and are applied automatically by
`cweagans/composer-patches` during `composer install`.

Upgrading from the previous version
-----------------------------------

*   PHP 8.2 or newer is now required.
*   The site-specific video plugins (YouTube, DailyMotion, Twitter, ...) were removed. They targeted
    page layouts those sites no longer use, and the upstream project dropped them as well.
    If a `custom_config.php` still lists them they are skipped and a message is written to the error log.
*   `website-url` is no longer needed in `config.php`; links are now relative.

Preview
-------

![](https://cdn.nicheoffice.web.tr/image/1583667250_.png)
