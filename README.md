# DockerでLaravel 11のローカル開発環境を構築する

このガイドでは、Dockerを使用してLaravel 11のローカル開発環境を構築する手順を説明します。phpMyAdminも含めて、MySQLとNginxもセットアップします。

## 環境構築

### プロジェクトをクローンする

まず、リポジトリをクローンしてプロジェクトのディレクトリに移動します。

```bash
$ git clone <your-repo-url>
$ cd <your-project-directory>
```

### docker-compose.ymlファイルを作成して編集する

```bash
$ touch docker-compose.yml
```

`docker-compose.yml`の内容は以下の通りです。

```yaml
version: '3'
services:
  app:
    container_name: app_laravel  
    build: ./docker/php
    volumes:
      - .:/var/www
  nginx:
    image: nginx 
    container_name: nginx
    ports:
      - 8000:80 
    volumes:
      - .:/var/www
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    working_dir: /var/www
    depends_on:
      - app
  db:
    image: mysql:8.0.36
    container_name: db
    environment: 
      MYSQL_ROOT_PASSWORD: password
      MYSQL_DATABASE: database 
    command: mysqld --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci
    volumes:  
      - ./docker/db/data:/var/lib/mysql
      - ./docker/db/my.cnf:/etc/mysql/conf.d/my.cnf 
      - ./docker/db/sql:/docker-entrypoint-initdb.d
    ports:
      - 3306:3306
  # phpMyAdmin
  phpmyadmin:
    container_name: test_phpmyadmin
    image: phpmyadmin
    environment:
    - PMA_USER=root
    - PMA_PASSWORD=password
    ports:
    - 8080:80
```

### `docker` ディレクトリを作成する

プロジェクトのルートディレクトリに`docker`ディレクトリを作成し、必要なサブディレクトリを作成します。

```bash
$ mkdir -p docker/php docker/nginx docker/db
```

### `php` 直下に Dockerfile と php.ini を作成して編集する

`docker/php`ディレクトリに移動して、`Dockerfile`と`php.ini`を作成します。

```bash
$ cd docker/php
$ touch Dockerfile php.ini
```

`Dockerfile`の内容は以下の通りです。

```dockerfile
FROM php:8.3-fpm

RUN apt-get update \
  && apt-get install -y zlib1g-dev mariadb-client vim libzip-dev \
  && docker-php-ext-install zip pdo_mysql

#Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

ENV COMPOSER_HOME /composer

ENV PATH $PATH:/composer/vendor/bin

WORKDIR /var/www

RUN composer global require "laravel/installer"
```

`php.ini`の内容は以下の通りです。

```ini
[mysqld]
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci
default_authentication_plugin=mysql_native_password

[client]
default-character-set=utf8mb4
```

### `nginx` 直下に default.conf を作成して編集する

```bash
$ cd ../nginx
$ touch default.conf
```

`default.conf`の内容は以下の通りです。

```nginx
server {
  listen 80;
  root /var/www/public;
  index index.php;
  location / {
    try_files $uri $uri/ /index.php?$query_string;
  }
  location ~ \.php$ {
    try_files $uri =404;
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    fastcgi_pass app:9000; 
    fastcgi_index index.php;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    fastcgi_param PATH_INFO $fastcgi_path_info;
  }
}
```

### Docker を起動してコンテナを作る

```bash
$ cd ../..
$ docker-compose up -d
```

### コンテナにログインする

```bash
$ docker-compose exec app bash
```

### Laravelをインストールする

```bash
# コンテナ内で
composer install
```

### .env 設定をする

プロジェクトの`.env`ファイルを編集します。

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=password
```

### マイグレーションを実行する

```bash
php artisan migrate
```

### ブラウザでLaravelの表示を確認する

- http://localhost:8000/ にアクセスし、Laravelの画面が表示されればOK
- http://localhost:8080/ にアクセスし、phpMyAdminが見れればOK

### 権限エラーが出た場合

```bash
# コンテナ内で
chown -R www-data:www-data ./storage ./bootstrap/cache
```

### .env と .env.example の環境設定をする

```bash
# .env.example を .env にコピー
cp .env.example .env
# キージェネレートする
php artisan key:generate
```

### コンテナからログアウト

```bash
exit
```

Laravel 11のローカル開発環境がDockerでセットアップされました。
```

