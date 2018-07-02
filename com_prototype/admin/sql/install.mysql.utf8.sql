CREATE TABLE IF NOT EXISTS `#__prototype_items` (
	`id`              INT(11)          NOT NULL AUTO_INCREMENT,
	`title`           VARCHAR(255)     NOT NULL DEFAULT '',
	`html`            LONGTEXT         NOT NULL DEFAULT '',
	`images`          MEDIUMTEXT       NOT NULL DEFAULT '',
	`state`           TINYINT(3)       NOT NULL DEFAULT '0',
	`catid`           INT(11)          NOT NULL DEFAULT '0',
	`created`         DATETIME         NOT NULL DEFAULT '0000-00-00 00:00:00',
	`created_by`      INT(11)          NOT NULL DEFAULT '0',
	`publish_down`    DATETIME         NOT NULL DEFAULT '0000-00-00 00:00:00',
	`placemark_id`    INT(11)          NOT NULL DEFAULT '0',
	`balloon_layout`  TEXT             NOT NULL DEFAULT '',
	`listitem_layout` TEXT             NOT NULL DEFAULT '',
	`map`             TEXT             NOT NULL DEFAULT '',
	`latitude`        DOUBLE(20, 6),
	`longitude`       DOUBLE(20, 6),
	`attribs`         TEXT             NOT NULL DEFAULT '',
	`access`          INT(10)          NOT NULL DEFAULT '0',
	`hits`            INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`region`          CHAR(7)          NOT NULL DEFAULT '*',
	`tags_search`     MEDIUMTEXT       NOT NULL DEFAULT '',
	`tags_map`        MEDIUMTEXT       NOT NULL DEFAULT '',
	`extra`           LONGTEXT         NOT NULL DEFAULT '',
	UNIQUE KEY `id` (`id`)
)
	ENGINE = MyISAM
	DEFAULT CHARSET = utf8
	AUTO_INCREMENT = 0;

CREATE TABLE IF NOT EXISTS `#__prototype_categories` (
	`id`              INT(11)      NOT NULL AUTO_INCREMENT,
	`title`           VARCHAR(255) NOT NULL DEFAULT '',
	`parent_id`       INT(11)      NOT NULL DEFAULT '0',
	`lft`             INT(11)      NOT NULL DEFAULT '0',
	`rgt`             INT(11)      NOT NULL DEFAULT '0',
	`level`           INT(10)      NOT NULL DEFAULT '0',
	`path`            VARCHAR(400) NOT NULL DEFAULT '',
	`alias`           VARCHAR(400) NOT NULL DEFAULT '',
	`attribs`         TEXT         NOT NULL DEFAULT '',
	`fields`          LONGTEXT     NOT NULL DEFAULT '',
	`filters`         LONGTEXT     NOT NULL DEFAULT '',
	`placemark_id`    INT(11)      NOT NULL DEFAULT '0',
	`balloon_layout`  TEXT         NOT NULL DEFAULT '',
	`listitem_layout` TEXT         NOT NULL DEFAULT '',
	`icon`            TEXT         NOT NULL DEFAULT '',
	`state`           TINYINT(3)   NOT NULL DEFAULT '0',
	`front_created`   TINYINT(3)   NOT NULL DEFAULT '0',
	`metakey`         MEDIUMTEXT   NOT NULL DEFAULT '',
	`metadesc`        MEDIUMTEXT   NOT NULL DEFAULT '',
	`access`          INT(10)      NOT NULL DEFAULT '0',
	`metadata`        MEDIUMTEXT   NOT NULL DEFAULT '',
	`tags_search`     MEDIUMTEXT   NOT NULL DEFAULT '',
	`tags_map`        MEDIUMTEXT   NOT NULL DEFAULT '',
	`items_tags`      MEDIUMTEXT   NOT NULL DEFAULT '',
	UNIQUE KEY `id` (`id`)
)
	ENGINE = MyISAM
	DEFAULT CHARSET = utf8
	AUTO_INCREMENT = 0;

CREATE TABLE IF NOT EXISTS `#__prototype_placemarks` (
	`id`     INT(11)      NOT NULL AUTO_INCREMENT,
	`title`  VARCHAR(255) NOT NULL DEFAULT '',
	`images` LONGTEXT     NOT NULL DEFAULT '',
	`layout` TEXT         NOT NULL DEFAULT '',
	`state`  TINYINT(3)   NOT NULL DEFAULT '0',
	`access` INT(10)      NOT NULL DEFAULT '0',
	UNIQUE KEY `id` (`id`)
)
	ENGINE = MyISAM
	DEFAULT CHARSET = utf8
	AUTO_INCREMENT = 0;