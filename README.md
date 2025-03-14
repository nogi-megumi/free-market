# coachtechフリマ

## 環境構築
### Dockerビルド
- git clone git@github.com:nogi-megumi/free-market.git
- docker compose up -d —build

### Laravel環境構築
    Dockerビルド
      1. git clone git@github.com:nogi-megumi/free-market.git
      2. DockerDesktopアプリを立ち上げる
      3. docker compose up -d —build

    laravel環境構築  
      1. docker-compose exec php bash
      2. composer install
      3. cp .env.example .env
      4. .envに以下の環境変数を変更

          APP_NAME=coachtechフリマ
          DB_CONNECTION=mysql
          DB_HOST=mysql
          DB_DATABASE=laravel_db
          DB_USERNAME=laravel_user
          DB_PASSWORD=laravel_pass
          
          MAIL_FROM_ADDRESS=test@example.com
          
      5. stripe(https://stripe.com/jp)にてアカウントを作成し、キーを取得する
      6. キーを.envに追加する

             STRIPE_KEY=　公開キー
             STRIPE_SECRET=　シークレットキー

      7. アプリケーションキーの作成 php artisan key:generate
      8. マイグレーションの実行 php artisan migrate
      9. シーディングの実行 php artisan db:seed
      10.シンボリックリンクを作成 php artisan storage:link

## PHPUnitテスト
    テスト用データベースの作成
    　1. docker-compose exec mysql bash
      2. mysql -u root -p
      　パスワードはrootを入力
    　3.create database demo_test;
     
    env.testingの作成
    　1. docker-compose exec php bash
      2. cp .env .env.testing
      4. .env.testingに以下の環境変数を変更

          APP_ENV=test
          APP_KEY=
          
          DB_DATABASE=demo_test
          DB_USERNAME=root
          DB_PASSWORD=root

    　5. テスト用のアプリケーションキーを作成 php artisan key:generate --env=testing
      6. php artisan config:clear
      7. php artisan migrate --env=testing
      8. テスト実行 vendor/bin/phpunit

## 使用技術（実行環境）
- php8.1.31
- Laravel8.83.29
- mysql8.0.26
- nginx1.21.1
- mailhog1.0.1
- stripe
## ER図
![free-market drawio](https://github.com/user-attachments/assets/b12e7892-c2ee-4cea-afac-a83008d2db8e)

## URL
- 開発環境：http://localhost/
