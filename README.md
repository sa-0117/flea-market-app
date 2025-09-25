# フリマアプリ 

## 環境構築  

### Docerビルド  
```  
git clone git@github.com:sa-0117/flea-market-app.git
docker-compose up -d --build  
``` 

### Laravel環境構築    
```  
docker-compose exec php bash  
composer install  
.env.example  
php artisan key:generate  
php artisan migrate  
php artisan db:seed 
php artisan storage:link 
```  

## 使用技術  

* PHP 8.4  
* Laravel 8.4  
* MySQL 8.0  
* mailtrap
* stripe

## メール認証について

mailtrapを使用しています。以下のリンクより会員登録をお願いします。

https://mailtrap.io/

メールボックスのIntegrationのCode Samples「PHP:Laravel 7.x and 8.x」を選択し、MAIL_MAILERからMAIL_ENCRYPTIONまでの項目をコピーして.envファイルにペーストしてください。

MAIL_FROM_ADDRESSについては任意のメールアドレスを入力してください。

## Stripeについて

コンビニ払いとカード支払いがありますが、決済画面にてコンビニ払いを選択するとレシートを印刷する画面に遷移します。そのためカード支払いを成功させた場合に意図する画面遷移が行える想定にしています。

また、StripeのAPIキーは以下のように設定をお願いいたします。
``` 
STRIPE_KEY="パブリックキー"
STRIPE_SECRET="シークレットキー"
``` 

公式ドキュメント:https://docs.stripe.com/payments/checkout?locale=ja-JP

## ER図

![er](https://github.com/user-attachments/assets/5f4bc1b0-e129-4b52-9a7b-e24d30d24e11)

## ダミーデータ
* name: ユーザー1(CO01～CO05の商品データを出品しているユーザー)

  email: user1@example.com

  password: password

* name: ユーザー2(CO06～CO10の商品データを出品しているユーザー)

  email: user2@example.com

  password: password

* name: ユーザー3(紐づけなしのユーザー)

  email: user3@example.com

  password: password
  

## テストアカウント
* name: テストユーザー1

　email: testuser1@example.com

　password: password

* name: テストユーザー2

　email: testuser2@example.com

　password: password

### PHPUnitを利用したテストについて
``` 
docker-compose exec mysql bash
mysql -u root -p
create database demo_test;

docker-compose exec php bash
php artisan migrate:fresh --env=testing
./vendor/bin/phpunit
```
※mysql rootのパスワードは「root」で入力ください。

※.env.testingにもStripeのAPIキーの設定をお願いします。

### 補足
要件ID：FN009 入力情報保持機能

上記要件を満たすため、取引チャット画面にFigmaデザインとは異なる仕様の「下書き保存」ボタンを設けています。

## URL  

* 開発環境：http://localhost/ 
* phpMyAdmin:http://localhost:8080

