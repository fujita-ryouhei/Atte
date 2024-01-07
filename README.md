# Atte
勤怠管理アプリ
![Alt text](image.png)
## 作成した目的
勤怠管理を円滑に、かつ正確に行うため。

## アプリケーションURL
35.75.29.180

## 機能一覧
- 会員登録
- ログイン
- 勤務開始・終了ボタン
- 休憩開始・終了ボタン
- 日付別勤怠管理
- ユーザー一覧勤怠管理

## 使用技術(実行環境)
- Laravel 8.83.27
- PHP 7.4.9
- mysql 8.0.26

## テーブル設計
![Alt text](image-1.png)

## ER図
<img src="index.drawio.png">

# 環境構築
$ git clone git@github.com:fujita-ryouhei/Atte.git
<p> githubでリモートリポジトリを作成した後、クローンしたリポジトリに移動して</p>
$git remote set-url origin 作成したリポジトリのurl<br>
$git remote -v<br>
最後のコマンドで、変更先の url が表示されれば成功。<br><br>
$ git add .<br>
$ git commit -m "リモートリポジトリの変更"<br>
$ git push origin main<br>
上記のコマンドで、現在のローカルリポジトリのデータをリモートリポジトリに反映させます。<br><br>

続いてDockerの設定を行なっていきます。以下のコマンドを入力してください。<br>
$ docker-compose up -d --build<br>
実行が終わったら、「Docker Desktop for Mac」を確認して、コンテナが作成されていれば成功です。<br><br>

次にdocker-composeコマンドで PHPコンテナ内にログインしましょう。<br>
docker-compose exec php bash <br>
ログインができたら、composerコマンドを使って必要なパッケージをインストールします。<br>
composer install<br><br>

最後に、データベースに接続するために.envファイルを作成します。<br>
.envファイルは、.env.exampleファイルをコピーして作成しましょう。<br>
$ cp .env.example .env<br>
作成出来たら、.envファイルを以下のように編集します。<br><br>
.envファイル<br><br>
// 前略<br><br>
DB_CONNECTION=mysql<br>
DB_HOST=mysql<br>
DB_PORT=3306<br>
DB_DATABASE=laravel_db<br>
DB_USERNAME=laravel_user<br>
DB_PASSWORD=laravel_pass<br><br>
// 後略<br><br>

以下のアドレスに入るとデータベースが存在しているか確認ができます。

http://localhost:8080/<br>

以上で環境構築は完了です。<br><br>

## ディレクトリ構成

![Alt text](image-2.png)