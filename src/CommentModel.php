<?php
/**
 * @copyright Copyright (C) 2016. Max Dark maxim.dark@gmail.com
 * @license MIT; see LICENSE.txt
 */

namespace BookMark\api\v1;

use useless\abstraction\Model;

/**
 * Class CommentModel
 * @package BookMark\api\v1
 */
class CommentModel implements Model
{
    private $uid = 0;
    private $bookmark_uid = 0;
    private $created_at = 0;
    private $ip = '';
    private $text = '';

    /**
     * @inheritdoc
     */
    public function getFields()
    {
        return [
            'uid' => $this->uid,
            'bookmark_uid' => $this->bookmark_uid,
            'created_at' => $this->created_at,
            'ip' => $this->ip,
            'text' => $this->text,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function name()
    {
        return 'comments';
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @param int $bmId
     * @param string $ip
     * @param string $text
     *
     * @return CommentModel
     */
    public function init($bmId, $ip, $text)
    {
        $this->bookmark_uid = $bmId;
        $this->ip = $ip;
        $this->text = $text;
        $this->created_at = time();
        return $this;
    }

    /**
     * @param int $value
     * @return void
     */
    public function setUID($value)
    {
        $this->uid = $value;
    }

    /**
     * @return int
     */
    public function getUID()
    {
        return $this->uid;
    }

    /**
     * @return int
     */
    public function createdAt()
    {
        return $this->created_at;
    }
}
