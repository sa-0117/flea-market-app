#フリマアプリ 

##環境構築  

###Docerビルド  
```  
git clone git@github.com:sa-0117/flea-market-app.git
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
php artisan storage:link 
```  

##使用技術  

* PHP 8.4  
* Laravel 8.4  
* MySQL 8.0  
* mailtrap
* stripe  
    シークレットキー：sk_test_51RYBiL2QkNSkIMt8dxxYIFajzXdutNXlm5KGoctW5CrGQkbN0jU72vuY9VEc5pkV1mUGSylPUAI3mogqkbgMmLg500XnWeaWEN  
    追加をお願いします

##ER図

![er](https://github.com/user-attachments/assets/5f4bc1b0-e129-4b52-9a7b-e24d30d24e11)


##URL  

* 開発環境：http://localhost/ 
* phpMyAdmin:http://localhost:8080

##ユーザー情報  
ダミーデータのpasswordはすべて「fma25046」です。