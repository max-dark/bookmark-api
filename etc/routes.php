<?php
/**
 * @copyright Copyright (C) 2016. Max Dark maxim.dark@gmail.com
 * @license MIT; see LICENSE.txt
 */

$mount_point = '/api/v1';
$bookmark = 'bookmark';
$comment = 'comment';

$bookmark_class = BookMark\api\v1\BookmarkAction::class;
$comment_class = BookMark\api\v1\CommentAction::class;

return [
    // получить список 10 последних добавленных BookMark
    "get:{$mount_point}/{$bookmark}/last" => [
        'class' => $bookmark_class,
        'action' => 'getLast',
        'params' => [],
    ],
    // получить BookMark (с комментариями) по BookMark.url. Если такого ещё нет, не создавать.
    "get:{$mount_point}/{$bookmark}/get" => [
        'class' => $bookmark_class,
        'action' => 'getComments',
        'params' => ['url'],
    ],
    // добавить BookMark по url и получить BookMark.uid. Если уже есть BookMark с таким url,
    // не добавлять ещё один, но получить BookMark.uid
    "post:{$mount_point}/{$bookmark}/add" => [
        'class' => $bookmark_class,
        'action' => 'getUid',
        'params' => ['url'],
    ],
    // добавить Comment к BookMark (по uid) и получить Comment.uid
    "post:{$mount_point}/{$comment}/add" => [
        'class' => $comment_class,
        'action' => 'add',
        'params' => ['uid', 'text'],
    ],
    // изменить Comment.text по uid (если он добавлен с этого же IP и прошло меньше часа после добавления)
    "post:{$mount_point}/{$comment}/update" => [
        'class' => $comment_class,
        'action' => 'update',
        'params' => ['uid', 'text'],
    ],
    // удалить Comment по uid (если он добавлен с этого же IP и прошло меньше часа после добавления)
    "post:{$mount_point}/{$comment}/delete" => [
        'class' => $comment_class,
        'action' => 'remove',
        'params' => ['uid'],
    ],
];
