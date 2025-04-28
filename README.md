#フリマアプリ 

##環境構築  

###Docerビルド  
```  
git clone github.com:coachtech-material/laravel-docker-template.git
docker-compose up -d --build  
``` 

###Laravel環境構築    
```  
docker-compose exec php bash  
composer install  
.env.example  
php artisan key:generate  
php artisan migrate  
php artisan db:seed  
```  

##使用技術  

* PHP 8.4  
* Laravel 8.4  
* MySQL 8.0  

##ER図

![er](https://github.com/user-attachments/assets/a5efe6ec-19d9-4037-88be-e85bd37a9cd2)


##URL  

* 開発環境：[http://localhost/]  
* phpMyAdmin:[http://localhost:8080]

