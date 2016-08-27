**BookMark api v0**

Настройки:

MP(mount point) - базовый URL для методов API

Примеры:
* example.org/api/v0 - с указанием хоста
* /some/path/api/v0 - путь на текущем сервере

bmk - часть пути

**Описание структур**

Bookmark:
* uid: number
* url: string
* created_at: timestamp
```json
{
    "uid":1,
    "url":"http://example.org/",
    "created_at":100001
}
```
Comment:
* uid: number
* bookmark_uid: number
* created_at: timestamp
* text: string
```json
{
    "uid":1,
    "bookmark_uid":1,
    "created_at":100021,
    "text":"its test"
}
```

**Описание методов API**

получить список 10 последних добавленных BookMark

`GET MP/bookmark/last`
* status: string
* last: Bookmark[]
```json
{
    "status":"ok|error message",
    "last":[
      "bookmark list"
    ]
}
```
получить BookMark (с комментариями) по BookMark.url. Если такого ещё нет, не создавать.

`GET MP/bookmark/get/?url=http[s]://example.com/page.htm`
```json
{
  "status":"ok|error message",
  "bmk":"Bookmark|null",
  "list":[
    "Comment[]"
  ]
}
```

добавить BookMark по url и получить BookMark.uid. Если уже есть BookMark с таким url,
не добавлять ещё один, но получить BookMark.uid

`POST MP/bookmark/add`
* post-data: url=http[s]://example.com/page.htm
```json
{
  "status":"ok|error message",
  "uid":"number"
}
```
добавить Comment к BookMark (по uid) и получить Comment.uid

`POST MP/comment/add`
* post-data: uid=number&text=message
```json
{
  "status":"ok|error message",
  "uid":"number"
}
```
изменить Comment.text по uid (если он добавлен с этого же IP и прошло меньше часа после добавления)

`POST MP/comment/edit`
* post-data: uid=number&text=message
```json
{
  "status":"ok|error message"
}
```
удалить Comment по uid (если он добавлен с этого же IP и прошло меньше часа после добавления)

`POST MP/comment/delete`
* post-data: uid=number
```json
{
  "status":"ok|error message"
}
```