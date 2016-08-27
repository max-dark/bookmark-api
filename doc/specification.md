**Создать простой REST Bookmarks на PHP**

Необходимо написать простой сервис закладок позволяет добавлять URL и оставлять к ним комментарии.

**Сущности**

Это не таблицы в базе данных, а то, что должен получать клиент API. Как хранить - решите сами.
BookMark: uid, created_at, url, comments
Comment: uid, created_at, ip, text

**API**

* получить список 10 последних добавленных BookMark
* получить BookMark (с комментариями) по BookMark.url. Если такого ещё нет, не создавать.
* добавить BookMark по url и получить BookMark.uid. Если уже есть BookMark с таким url, не добавлять ещё один, но получить BookMark.uid.
* добавить Comment к BookMark (по uid) и получить Comment.uid
* изменить Comment.text по uid (если он добавлен с этого же IP и прошло меньше часа после добавления)
* удалить Comment по uid (если он добавлен с этого же IP и прошло меньше часа после добавления)

Формат API и передачи данных выберите сами, учитывая требования:
запросы к системе будут из javascript в браузере (например, виджет на сайтах или расширение браузера).
авторизации нет - все отправляют анонимно

**Технические вопросы**

Допустимые языки: PHP, любой фреймворк или без фреймворка.
Делаем как можно проще, но код должен быть production-ready:
обязательно readme для js-программиста, как ему пользоваться API
код после вас будет дорабатывать другой программист маньяк, с которым вы не хотите портить отношения