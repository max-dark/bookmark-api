<?php
/**
 * @copyright Copyright (C) 2016. Max Dark maxim.dark@gmail.com
 * @license MIT; see LICENSE.txt
 */

namespace BookMark\api\v1;

use useless\abstraction\Model;

/**
 * Class BookmarkModel
 * @package BookMark\api\v1
 */
class BookmarkModel implements Model
{
    /** @var int $uid */
    private $uid = 0;
    /** @var int $created_at */
    private $created_at = 0;
    /** @var string $url */
    private $url = '';

    /**
     * @return array
     */
    public function getFields()
    {
        return [
            'uid' => $this->uid,
            'created_at' => $this->created_at,
            'url' => $this->url,
        ];
    }

    /**
     * @return string
     */
    public static function name()
    {
        return 'bookmarks';
    }

    /**
     * @return int
     */
    public function getUID()
    {
        return $this->uid;
    }

    /**
     * @param string $url
     * @return BookmarkModel
     */
    public function init($url)
    {
        $this->url = $url;
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
    public function createdAt()
    {
        return $this->created_at;
    }
}
