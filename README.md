# coachtechフリマ

## 環境構築
### Dockerビルド
- git clone git@github.com:
- docker compose up -d —build

### Laravel環境構築
- docker-compose exec php bash
-  composer install
- .env.exampleファイルから.envを作成し、環境変数を変更
- .envに以下の環境変数を追加
- APP_NAME=coachtechフリマ
- DB_CONNECTION=mysql
- DB_HOST=mysql
- DB_PORT=3306
- DB_DATABASE=laravel_db
- DB_USERNAME=laravel_user
- DB_PASSWORD=laravel_pass
- MAIL_MAILER=smtp
- MAIL_HOST=mailhog
- MAIL_PORT=1025
- MAIL_FROM_ADDRESS=test@example.com

- stripeにてアカウントを作成し、キーを取得する。
- 取得したキーを.envに追加する。
- STRIPE_KEY=　公開キー
- STRIPE_SECRET=　シークレットキー
- アプリケーションキーの作成　php artisan key:gengerate
- マイグレーションの実行　php artisan migrate
- シーディングの実行　php artisan db:seed

## 使用技術（実行環境）
- php
- Laravel
- mysql
- nginx
- mailhog
## ER図

## URL
- 開発環境：http://localhost/
