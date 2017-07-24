# CEO - Website

## Uses Laravel Framework
```
PHP >= 5.5.9
OpenSSL PHP Extension
PDO PHP Extension
Mbstring PHP Extension
Tokenizer PHP Extension
```
## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Config
copy .evn.example .evn
generate app key
```
php artisan key:generate
```
change .evn config
```
Databse name: ceo_website_db
virtual host [http|https]: ceo.local.vn
and run composer update
```
## project struct
```
Cms module: implement cms
Front end: app/Http
```
## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
