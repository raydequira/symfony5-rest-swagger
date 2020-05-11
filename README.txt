#requirements
1.You must have php installed. If none, you can download https://www.apachefriends.org/index.html which simply install all you need in developing php app
2.Please download symfony cli at https://symfony.com/download
3.Please download https://code.google.com/archive/p/openssl-for-windows/downloads
update .env for your database credentials and load db.sql

lib installed
composer require friendsofsymfony/rest-bundle
composer require sensio/framework-extra-bundle
composer require jms/serializer-bundle
composer require symfony/validator
composer require symfony/form
composer require symfony/orm-pack
composer require lexik/jwt-authentication-bundle

Note:
JWT Pass Pharse Private Pem: rayroland

{
	"firstname": "Ray",
	"username": "admin",
	"password": "master@pi",
	"email": "admin@test.com"
}

#run the app
symfony server:start