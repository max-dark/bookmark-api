DROP TABLE IF EXISTS `bm_bookmarks`;
DROP TABLE IF EXISTS `bm_comments`;

CREATE TABLE `bm_bookmarks` (
  `uid`        INT  NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `created_at` INT  NOT NULL,
  `url`        TEXT NOT NULL
)
  DEFAULT CHARSET = utf8;

CREATE TABLE `bm_comments` (
  `uid`          INT  NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `bookmark_uid` INT  NOT NULL REFERENCES `bm_bookmarks` (`uid`),
  `created_at`   INT  NOT NULL,
  `ip`           TEXT NOT NULL,
  `text`         TEXT NOT NULL
)
  DEFAULT CHARSET = utf8;
