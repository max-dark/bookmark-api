<?php
/**
 * @copyright Copyright (C) 2016. Max Dark maxim.dark@gmail.com
 * @license MIT; see LICENSE.txt
 */

namespace BookMark\api\v1;

use useless\abstraction\Action;
use useless\abstraction\ActionTrait;
use useless\abstraction\Storage;

/**
 * Class BookmarkAction
 * @package BookMark\api\v1
 */
class BookmarkAction implements Action
{
    use ActionTrait;

    /**
     * BookmarkAction constructor.
     *
     * @param \useless\abstraction\Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->init($storage, BookmarkModel::class);
    }

    /**
     * @return array
     */
    public function getLast()
    {
        $last = [];
        $msg = 'ok';
        try {
            $last = $this
                ->storage
                ->findMany([
                    'order' => ['created_at', 'DESC'],
                    'limit' => 10
                ])
                ->asArray();
        } catch (\Exception $e) {
            $msg = $e->getMessage();
        }
        return [
            'status' => $msg,
            'last' => $last,
        ];
    }

    /**
     * @param string $url
     * @return array
     */
    public function getUid($url)
    {
        $uid = null;
        try {
            $bookmark = $this->getByUrl($url);
            if (false == $bookmark) {
                $bookmark = (new BookmarkModel())
                    ->init($url);
                $this->storage->save($bookmark);
            }
            $uid = $bookmark->getUID();
            $msg = 'ok';
        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
        }
        return [
            'status' => $msg,
            'uid' => $uid
        ];
    }

    /**
     * @param $url
     * @return array
     */
    public function getComments($url)
    {
        $status = 'Not Found';
        $list = [];
        try {
            $bookmark = $this->getByUrl($url);
            if ($bookmark) {
                $commentStorage = $this->storage->forModel(CommentModel::class);
                $commentList = $commentStorage
                    ->findMany(['bookmark_uid' => $bookmark->getUID()]);
                while ($comment = $commentList->getOne()) {
                    $fields = $comment->getFields();
                    unset($fields['bookmark_uid']);
                    $list[] = $fields;
                }
                $bookmark = $bookmark->getFields();
                $status = 'ok';
            }
        } catch (\Exception $exception) {
            $status = $exception->getMessage();
            $bookmark = null;
        }
        return [
            'status' => $status,
            'bmk' => $bookmark,
            'list' => $list
        ];
    }

    /**
     * @param $url
     * @return BookmarkModel|\useless\abstraction\Model
     */
    private function getByUrl($url)
    {
        return $this->storage->findOne(['url' => $url])->getOne();
    }
}
