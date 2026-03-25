# 週間習慣トラッカー

Laravel 13 の新機能を活用して構築した、日々の習慣を管理・記録する Web アプリケーションです。

## 概要

習慣を登録し、今週の達成状況を週 7 マスでチェックできます。
ダッシュボードでは達成率をリアルタイムで確認でき、メールリマインダーによる通知機能も搭載しています。

## 使用技術

| カテゴリ | 技術 |
| --- | --- |
| バックエンド | PHP 8.3 / Laravel 13 |
| フロントエンド | Livewire 4 / Flux UI / Tailwind CSS |
| データベース | MySQL 8.4 |
| 開発環境 | Laravel Sail (Docker) |
| メール | Mailpit |
| DB 管理 | phpMyAdmin |

## Laravel 13 新機能の活用箇所

| 新機能 | 使用箇所 |
| --- | --- |
| `#[Fillable]` / `#[Table]` PHP Attributes | `Habit` / `HabitLog` モデル |
| `Cache::touch()` | `DashboardController`（TTL 延長） |
| `Queue::route()` | `AppServiceProvider`（キュー設定の一元管理） |

## 機能一覧

- **習慣 CRUD** — 習慣の登録・編集・削除（`HabitManager` Livewire コンポーネント）
- **週間チェック** — 今週の達成状況を 7 マスで記録（`WeeklyTracker` Livewire コンポーネント）
- **ダッシュボード** — 達成率をキャッシュ付きで表示
- **REST API** — Sanctum 認証による習慣一覧エンドポイント
- **メール通知** — キュー経由のリマインダーメール（`SendHabitReminder` Job）
- **ゲストログイン** — アカウント登録なしで試用可能
- **2 段階認証** — TOTP ベースのセキュリティ設定

## セットアップ

### 1. リポジトリのクローン

```bash
git clone <repository-url>
cd habit-tracker
```

### 2. 環境ファイルの作成

```bash
cp .env.example .env
```

`.env` を編集し、以下の項目を設定します。

```env
APP_NAME="習慣トラッカー"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=habit_tracker
DB_USERNAME=sail
DB_PASSWORD=password

QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
```

### 3. Sail の起動

```bash
# 依存パッケージのインストール（初回のみ）
docker run --rm -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# コンテナの起動
./vendor/bin/sail up -d
```

### 4. アプリケーションの初期設定

```bash
# アプリケーションキーの生成
./vendor/bin/sail artisan key:generate

# マイグレーションの実行
./vendor/bin/sail artisan migrate

# （任意）シーダーの実行
./vendor/bin/sail artisan db:seed

# ゲストユーザーの作成
./vendor/bin/sail artisan guest:create

# フロントエンドのビルド
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

### 5. キューワーカーの起動

メール通知を使用する場合は、キューワーカーを起動してください。

```bash
./vendor/bin/sail artisan queue:work
```

## アクセス先

| サービス | URL |
| --- | --- |
| アプリケーション | http://localhost |
| Mailpit（メール確認） | http://localhost:8025 |
| phpMyAdmin | http://localhost:8888 |

## API エンドポイント

Sanctum トークン認証が必要です。

| メソッド | エンドポイント | 説明 |
| --- | --- | --- |
| `GET` | `/api/habits` | 習慣一覧の取得 |

### 認証トークンの発行例

```bash
curl -X POST http://localhost/api/tokens \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'
```

## ディレクトリ構成（主要ファイル）

```
app/
├── Http/Controllers/
│   ├── DashboardController.php   # 達成率キャッシュ
│   ├── HabitApiController.php    # REST API
│   └── GuestLoginController.php  # ゲストログイン
├── Jobs/
│   └── SendHabitReminder.php     # リマインダー Job
├── Mail/
│   └── HabitReminderMail.php     # メールクラス
└── Models/
    ├── Habit.php                  # #[Fillable] #[Table] 使用
    └── HabitLog.php               # #[Fillable] #[Table] 使用

resources/views/components/
├── ⚡habit-manager.blade.php     # 習慣 CRUD コンポーネント
└── ⚡weekly-tracker.blade.php    # 週間チェックコンポーネント
```

## テスト

```bash
./vendor/bin/sail artisan test
```

## 関連記事

本リポジトリは Zenn に公開している Laravel 記事シリーズの一部です。

- Zenn: https://zenn.dev/dainaka
