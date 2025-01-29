# coachtechフリマ

## 環境構築
### Dockerビルド
- git clone git@github.com:
- docker compose up -d —build

### Laravel環境構築
Dockerビルド
1. git clone git@github.com:nogi-megumi/free-market.git
2. DockerDesktopアプリを立ち上げる
3. docker compose up -d —build

laravel環境構築  
1. docker-compose exec php bash
2. composer install
3. .env.exampleファイルから.envを作成し、環境変数を変更
4. .envに以下の環境変数を追加

　DB_CONNECTION=mysql
　DB_HOST=mysql
　DB_PORT=3306
　DB_DATABASE=laravel_db
　DB_USERNAME=laravel_user
　DB_PASSWORD=laravel_pass

  MAIL_MAILER=smtp
  MAIL_HOST=mailhog
  MAIL_PORT=1025
  MAIL_FROM_ADDRESS=test@example.com

5. stripeにてアカウントを作成し、キーを取得する
6. キーを.envに追加する

   STRIPE_KEY=　公開キー
   STRIPE_SECRET=　シークレットキー

7. アプリケーションキーの作成 php artisan key:generate
8. マイグレーションの実行 php artisan migrate
9. シーディングの実行 php artisan db:seed

## 使用技術（実行環境）
- php
- Laravel
- mysql
- nginx
- mailhog
- stripe
## ER図

## URL
- 開発環境：http://localhost/
