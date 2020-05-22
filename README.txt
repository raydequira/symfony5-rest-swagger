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
  "firstName": "Ray",
  "lastName": "Roland",
  "email": "rayroland@test.com",
  "username": "rayroland",
  "password": "mypassword",
  "number": "971504781234"
}

#load db.sql to your mysql.

#configure .env for your database config

#run the app
symfony server:start

#open your xampp and run the mysql database.

ACCESS via POSTman
http://127.0.0.1:8000

or ACCESS via SWAGGER
http://127.0.0.1:8000/swagger-editor-master/index.html (use public/swagger.json)

This is going to be your starting point for every API project the you will have if you want to use Symfony5 with JWT token
