Простой REST Bookmarks на PHP
===

Установка
---
* Клонируем репозиторий
```
git clone https://bitbucket.org/max_dark/bookmark-api.git dir_name
```
* Устанавливаем зависимости
```
cd dir_name
composer install
```
Где `dir_name` - имя создаваемой директории
* Создаем таблицы

Можно использовать импрот в phpMyAdmin - файл `doc/init_db.sql`
либо выполнить запросы к БД
```sql
CREATE TABLE `bm_bookmarks` (
  `uid`        INT  NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `created_at` INT  NOT NULL,
  `url`        TEXT NOT NULL
) DEFAULT CHARSET = utf8;

CREATE TABLE `bm_comments` (
  `uid`          INT  NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `bookmark_uid` INT  NOT NULL REFERENCES `bm_bookmarks` (`uid`),
  `created_at`   INT  NOT NULL,
  `ip`           TEXT NOT NULL,
  `text`         TEXT NOT NULL
) DEFAULT CHARSET = utf8;
```
Где `bm_` - изменяемый префикс таблиц

Настройка
---
* БД: В файле `etc/db.php` установить правильные `user`, `password`, `dbname` и установить префикс(если его меняли)
* Маршруты: В файле `etc/routes.php` при необходимости поменять `mount_point`

Запуск локального сервера
---
Перейти в поддиректорию `web/` и запустить встоенный в `php` сервер:
```
php -S localhost:8080
```
Тестовый клиент станет доступен по адресу [http://localhost:8080/client/](http://localhost:8080/client/)

Дополнительная информация и описание API
---
смотрите в директории `doc/`