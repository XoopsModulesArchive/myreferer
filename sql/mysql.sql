CREATE TABLE myreferer_config (
    conf_id        SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    conf_name      VARCHAR(30)          NOT NULL DEFAULT '',
    conf_title     VARCHAR(30)          NOT NULL DEFAULT '',
    conf_value     TEXT                 NOT NULL,
    conf_desc      VARCHAR(50)          NOT NULL DEFAULT '',
    conf_formtype  VARCHAR(15)          NOT NULL DEFAULT '',
    conf_valuetype VARCHAR(10)          NOT NULL DEFAULT '',
    conf_order     SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (conf_id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

INSERT INTO myreferer_config
VALUES (1, 'version', '', '1', '', 'hidden', 'hidden', 0);
INSERT INTO myreferer_config
VALUES (2, 'lastraz', '', '25', '', 'hidden', 'hidden', 0);
INSERT INTO myreferer_config
VALUES (3, 'count_admin', '_MYREFERER_COUNT_ADMIN', '0', '_MYREFERER_COUNT_ADMIN_DSC', 'yesno', 'int', 0);
INSERT INTO myreferer_config
VALUES (4, 'module_blacklist', '_MYREFERER_MODULE_BLACKLIST', 'xoopsorgnews|xoops_redirect|user|search|notifications|viewpmsg|readpmsg|myreferer|newbb|system', '_MYREFERER_MODULE_BLACKLIST_DSC', 'textarea', 'text', 2);
INSERT INTO myreferer_config
VALUES (5, '', '_MYREFERER_KEYWORD', '', '', 'insertBreak', 'hidden', 100);
INSERT INTO myreferer_config
VALUES (6, 'keyword_min', '_MYREFERER_KEYWORD_MIN', '3', '_MYREFERER_KEYWORD_MIN_DSC', 'text', 'int', 101);
INSERT INTO myreferer_config
VALUES (7, 'keyword_max', '_MYREFERER_KEYWORD_MAX', '24', '_MYREFERER_KEYWORD_MAX_DSC', 'text', 'int', 102);
INSERT INTO myreferer_config
VALUES (8, 'punctation', '_MYREFERER_PUNCTATION', '1', '_MYREFERER_PUNCTATION_DSC', 'yesno', 'int', 103);
INSERT INTO myreferer_config
VALUES (9, 'numbers', '_MYREFERER_NUMBERS', '0', '_MYREFERER_NUMBERS_DSC', 'yesno', 'int', 104);
INSERT INTO myreferer_config
VALUES (10, 'smallcaps', '_MYREFERER_SMALLCAPS', '1', '_MYREFERER_SMALLCAPS_DSC', 'yesno', 'int', 105);
INSERT INTO myreferer_config
VALUES (11, 'keyword_blacklist', '_MYREFERER_KEYWORD_BLACKLIST', 'pour|avec|dans|site', '_MYREFERER_KEYWORD_BLACKLIST_DSC', 'textarea', 'text', 106);
INSERT INTO myreferer_config
VALUES (12, 'search_blacklist', '_MYREFERER_SEARCH_BLACKLIST', '', '_MYREFERER_SEARCH_BLACKLIST_DSC', 'textarea', 'text', 107);
INSERT INTO myreferer_config
VALUES (13, '', '_MYREFERER_REFERER', '', '', 'insertBreak', 'hidden', 200);
INSERT INTO myreferer_config
VALUES (14, 'referer_blacklist', '_MYREFERER_REFERER_BLACKLIST', '127.0.0.1|mail|xoopsorgnews', '_MYREFERER_REFERER_BLACKLIST_DSC', 'textarea', 'text', 201);
INSERT INTO myreferer_config
VALUES (15, '', '_MYREFERER_ROBOTS', '', '', 'insertBreak', 'hidden', 300);
INSERT INTO myreferer_config
VALUES (16, 'new_bot_smail', '_MYREFERER_NEW_BOT_SMAIL', '0', '_MYREFERER_NEW_BOT_SMAIL_DSC', 'yesno', 'int', 301);
INSERT INTO myreferer_config
VALUES (17, 'new_bot_mail', '_MYREFERER_NEW_BOT_MAIL', '', '_MYREFERER_NEW_BOT_MAIL_DSC', 'text', 'text', 302);
INSERT INTO myreferer_config
VALUES (18, 'robots_blacklist', '_MYREFERER_ROBOTS_BLACKLIST', 'W3C_Validator|Lynx|libwww-perl', '_MYREFERER_ROBOTS_BLACKLIST_DSC', 'textarea', 'text', 303);
INSERT INTO myreferer_config
VALUES (19, 'page_prohibit', '_MYREFERER_PAGE_PROHIBIT', 'modules/myreferer/norobot.html', '_MYREFERER_PAGE_PROHIBIT_DSC', 'text', 'text', 304);
INSERT INTO myreferer_config
VALUES (20, 'robots_prohibit', '_MYREFERER_ROBOTS_PROHIBIT', '', '_MYREFERER_ROBOTS_PROHIBIT_DSC', 'textarea', 'text', 305);
INSERT INTO myreferer_config
VALUES (21, '', '_MYREFERER_USERVISIT', '', '', 'insertBreak', 'hidden', 100);
INSERT INTO myreferer_config
VALUES (22, 'user_visit', '_MYREFERER_USER_VISIT', '0', '_MYREFERER_USER_VISIT_DSC', 'yesno', 'int', 401);
INSERT INTO myreferer_config
VALUES (23, 'save_group', '_MYREFERER_SAVE_GROUP', 'a:2:{i:0;s:1:"2";i:1;s:1:"4";}', '_MYREFERER_SAVE_GROUP_DSC', 'select', 'array', 402);
INSERT INTO myreferer_config
VALUES (24, '', '_MYREFERER_STATS', '', '', 'insertBreak', 'hidden', 400);
INSERT INTO myreferer_config
VALUES (25, 'myreferer_pages_stats', '_MYREFERER_STATS_PAGES', '100', '_MYREFERER_STATS_PAGES_DSC', 'select', 'int', 500);
INSERT INTO myreferer_config
VALUES (26, 'myreferer_query_stats', '_MYREFERER_STATS_QUERY', '100', '_MYREFERER_STATS_QUERY_DSC', 'select', 'int', 500);
INSERT INTO myreferer_config
VALUES (27, 'myreferer_query_pages_stats', '_MYREFERER_STATS_QUERY_PAGES', '100', '_MYREFERER_STATS_QUERY_PAGES_DSC', 'select', 'int', 500);
INSERT INTO myreferer_config
VALUES (28, 'myreferer_referer_stats', '_MYREFERER_STATS_REFERER', '100', '_MYREFERER_STATS_REFERER_DSC', 'select', 'int', 500);
INSERT INTO myreferer_config
VALUES (29, 'myreferer_referer_pages_stats', '_MYREFERER_STATS_REFERER_PAGES', '100', '_MYREFERER_STATS_REFERER_PAGES_DSC', 'select', 'int', 500);
INSERT INTO myreferer_config
VALUES (30, 'myreferer_robots_stats', '_MYREFERER_STATS_ROBOTS', '100', '_MYREFERER_STATS_ROBOTS_DSC', 'select', 'int', 500);
INSERT INTO myreferer_config
VALUES (31, 'myreferer_robots_pages_stats', '_MYREFERER_STATS_ROBOTS_PAGES', '100', '_MYREFERER_STATS_ROBOTS_PAGES_DSC', 'select', 'int', 500);
INSERT INTO myreferer_config
VALUES (32, 'myreferer_users_stats', '_MYREFERER_STATS_USERS', '100', '_MYREFERER_STATS_USERS_DSC', 'select', 'int', 500);
INSERT INTO myreferer_config
VALUES (33, 'myreferer_users_pages_stats', '_MYREFERER_STATS_USERS_PAGES', '100', '_MYREFERER_STATS_USERS_PAGES_DSC', 'select', 'int', 500);

CREATE TABLE myreferer_pages (
    id        INT(8)     NOT NULL AUTO_INCREMENT,
    page      TEXT       NOT NULL,
    visit     INT(8)     NOT NULL DEFAULT '0',
    visit_tmp INT(8)     NOT NULL DEFAULT '0',
    startdate INT(11)    NOT NULL DEFAULT '0',
    date      INT(11)    NOT NULL DEFAULT '0',
    hide      TINYINT(2) NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_pages_stats (
    id      INT(8) NOT NULL AUTO_INCREMENT,
    year    INT(4) NOT NULL DEFAULT '0',
    week    INT(2) NOT NULL DEFAULT '0',
    pagesid INT(8) NOT NULL DEFAULT '0',
    visit   INT(8) NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_query (
    id        INT(8)       NOT NULL AUTO_INCREMENT,
    query     VARCHAR(255) NOT NULL DEFAULT '',
    keyword   TINYINT(2)   NOT NULL DEFAULT '0',
    page      VARCHAR(255) NOT NULL DEFAULT '',
    visit     INT(8)       NOT NULL DEFAULT '0',
    visit_tmp INT(8)       NOT NULL DEFAULT '0',
    startdate INT(11)      NOT NULL DEFAULT '0',
    date      INT(11)      NOT NULL DEFAULT '0',
    hide      TINYINT(2)   NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_query_pages (
    id        INT(11)    NOT NULL AUTO_INCREMENT,
    queryid   INT(8)     NOT NULL DEFAULT '0',
    pagesid   INT(8)     NOT NULL DEFAULT '0',
    visit     INT(8)     NOT NULL DEFAULT '0',
    visit_tmp INT(8)     NOT NULL DEFAULT '0',
    startdate INT(11)    NOT NULL DEFAULT '0',
    date      INT(11)    NOT NULL DEFAULT '0',
    hide      TINYINT(2) NOT NULL DEFAULT '0',
    tracker   TINYINT(2) NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_query_pages_stats (
    id      INT(11) NOT NULL AUTO_INCREMENT,
    year    INT(4)  NOT NULL DEFAULT '0',
    week    INT(2)  NOT NULL DEFAULT '0',
    queryid INT(8)  NOT NULL DEFAULT '0',
    pagesid INT(8)  NOT NULL DEFAULT '0',
    visit   INT(8)  NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_query_stats (
    id      INT(8) NOT NULL AUTO_INCREMENT,
    year    INT(4) NOT NULL DEFAULT '0',
    week    INT(2) NOT NULL DEFAULT '0',
    queryid INT(8) NOT NULL DEFAULT '0',
    visit   INT(8) NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_referer (
    id        INT(8)       NOT NULL AUTO_INCREMENT,
    engine    TINYINT(2)   NOT NULL DEFAULT '0',
    referer   VARCHAR(255) NOT NULL DEFAULT '',
    ref_url   VARCHAR(255) NOT NULL DEFAULT '',
    page      VARCHAR(255) NOT NULL DEFAULT '',
    visit     INT(8)       NOT NULL DEFAULT '0',
    visit_tmp INT(8)       NOT NULL DEFAULT '0',
    startdate INT(11)      NOT NULL DEFAULT '0',
    date      INT(11)      NOT NULL DEFAULT '0',
    hide      TINYINT(2)   NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_referer_pages (
    id        INT(11)    NOT NULL AUTO_INCREMENT,
    refererid INT(8)     NOT NULL DEFAULT '0',
    pagesid   INT(8)     NOT NULL DEFAULT '0',
    visit     INT(8)     NOT NULL DEFAULT '0',
    visit_tmp INT(8)     NOT NULL DEFAULT '0',
    startdate INT(11)    NOT NULL DEFAULT '0',
    date      INT(11)    NOT NULL DEFAULT '0',
    hide      TINYINT(2) NOT NULL DEFAULT '0',
    tracker   TINYINT(2) NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_referer_pages_stats (
    id        INT(11) NOT NULL AUTO_INCREMENT,
    year      INT(4)  NOT NULL DEFAULT '0',
    week      INT(2)  NOT NULL DEFAULT '0',
    refererid INT(8)  NOT NULL DEFAULT '0',
    pagesid   INT(8)  NOT NULL DEFAULT '0',
    visit     INT(8)  NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_referer_stats (
    id        INT(8) NOT NULL AUTO_INCREMENT,
    year      INT(4) NOT NULL DEFAULT '0',
    week      INT(2) NOT NULL DEFAULT '0',
    refererid INT(8) NOT NULL DEFAULT '0',
    visit     INT(8) NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_robots (
    id        INT(8)       NOT NULL AUTO_INCREMENT,
    robots    VARCHAR(255) NOT NULL DEFAULT '',
    ref_url   VARCHAR(255) NOT NULL DEFAULT '',
    page      VARCHAR(255) NOT NULL DEFAULT '',
    visit     INT(8)       NOT NULL DEFAULT '0',
    visit_tmp INT(8)       NOT NULL DEFAULT '0',
    startdate INT(11)      NOT NULL DEFAULT '0',
    date      INT(11)      NOT NULL DEFAULT '0',
    hide      TINYINT(2)   NOT NULL DEFAULT '0',
    tracker   TINYINT(2)   NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_robots_pages (
    id        INT(11)    NOT NULL AUTO_INCREMENT,
    robotsid  INT(8)     NOT NULL DEFAULT '0',
    pagesid   INT(8)     NOT NULL DEFAULT '0',
    visit     INT(8)     NOT NULL DEFAULT '0',
    visit_tmp INT(8)     NOT NULL DEFAULT '0',
    startdate INT(11)    NOT NULL DEFAULT '0',
    date      INT(11)    NOT NULL DEFAULT '0',
    hide      TINYINT(2) NOT NULL DEFAULT '0',
    tracker   TINYINT(2) NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_robots_pages_stats (
    id       INT(11) NOT NULL AUTO_INCREMENT,
    year     INT(4)  NOT NULL DEFAULT '0',
    week     INT(2)  NOT NULL DEFAULT '0',
    robotsid INT(8)  NOT NULL DEFAULT '0',
    pagesid  INT(8)  NOT NULL DEFAULT '0',
    visit    INT(8)  NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_robots_stats (
    id       INT(8) NOT NULL AUTO_INCREMENT,
    year     INT(4) NOT NULL DEFAULT '0',
    week     INT(2) NOT NULL DEFAULT '0',
    robotsid INT(8) NOT NULL DEFAULT '0',
    visit    INT(8) NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_users (
    id        INT(8)     NOT NULL AUTO_INCREMENT,
    user      INT(16)    NOT NULL DEFAULT '0',
    visit     INT(8)     NOT NULL DEFAULT '0',
    visit_tmp INT(8)     NOT NULL DEFAULT '0',
    startdate INT(11)    NOT NULL DEFAULT '0',
    date      INT(11)    NOT NULL DEFAULT '0',
    hide      TINYINT(2) NOT NULL DEFAULT '0',
    tracker   TINYINT(2) NOT NULL DEFAULT '1',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_users_pages (
    id        INT(11)    NOT NULL AUTO_INCREMENT,
    usersid   INT(8)     NOT NULL DEFAULT '0',
    pagesid   INT(8)     NOT NULL DEFAULT '0',
    visit     INT(8)     NOT NULL DEFAULT '0',
    visit_tmp INT(8)     NOT NULL DEFAULT '0',
    startdate INT(11)    NOT NULL DEFAULT '0',
    date      INT(11)    NOT NULL DEFAULT '0',
    hide      TINYINT(2) NOT NULL DEFAULT '0',
    tracker   TINYINT(2) NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_users_pages_stats (
    id      INT(11) NOT NULL AUTO_INCREMENT,
    year    INT(4)  NOT NULL DEFAULT '0',
    week    INT(2)  NOT NULL DEFAULT '0',
    usersid INT(8)  NOT NULL DEFAULT '0',
    pagesid INT(8)  NOT NULL DEFAULT '0',
    visit   INT(8)  NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myreferer_users_stats (
    id      INT(8) NOT NULL AUTO_INCREMENT,
    year    INT(4) NOT NULL DEFAULT '0',
    week    INT(2) NOT NULL DEFAULT '0',
    usersid INT(8) NOT NULL DEFAULT '0',
    visit   INT(8) NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) COMMENT ='myReferer - solo (http://www.wolfpackclan.com)';
