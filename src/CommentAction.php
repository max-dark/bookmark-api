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
 * Class CommentAction
 * @package BookMark\api\v1
 */
class CommentAction implements Action
{
    use ActionTrait;

    /**
     * CommentAction constructor.
     *
     * @param \useless\abstraction\Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->init($storage, CommentModel::class);
    }

    /**
     * Add comment to BookMark by BookMark.uid
     *
     * @param int $uid
     * @param string $text
     * @return array
     */
    public function add($uid, $text)
    {
        $msg = 'bookmark not found';
        $cid = null;
        try {
            $bookmarks = $this->storage->forModel(BookmarkModel::class);
            $bookmark = $bookmarks->findOne(['uid' => $uid])->getOne();
            if ($bookmark) {
                $comment = (new CommentModel())
                    ->init($uid, filter_input(INPUT_SERVER, 'REMOTE_ADDR'), $text);
                if ($this->storage->save($comment)) {
                    $msg = 'ok';
                    $cid = $comment->getUID();
                }
            }
        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
        }
        return [
            'status' => $msg,
            'uid' => $cid
        ];
    }

    /**
     * Update comment by Comment.uid
     *
     * @param int $uid
     * @param string $text
     * @return array
     */
    public function update($uid, $text)
    {
        $msg = 'Not found';
        try {
            /** @var CommentModel $comment */
            $comment = $this->findOne($uid);
            if ($comment) {
                $comment->setText($text);
                $this->storage->save($comment);
                $msg = 'ok';
            }
        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
        }
        return [
            'status' => $msg,
        ];
    }

    /**
     * Remove comment by Comment.uid
     *
     * @param int $uid
     * @return array
     */
    public function remove($uid)
    {
        $status = 'Not Found';
        try {
            $comment = $this->findOne($uid);
            if ($comment) {
                $this->storage->remove($comment);
                $status = 'ok';
            }
        } catch (\Exception $exception) {
            $status = $exception->getMessage();
        }
        return [
            'status' => $status,
        ];
    }

    /**
     * @param int $uid
     * @return \useless\abstraction\Model|false
     */
    private function findOne($uid)
    {
        $comment = $this
            ->storage
            ->findOne([
                'uid' => $uid,
                'ip' => filter_input(INPUT_SERVER, 'REMOTE_ADDR')
            ])
            ->getOne();
        $isOk = $comment && ($comment->createdAt() >= (time() - 3600));
        return $isOk ? $comment : false;
    }
}
