CREATE TABLE myref_config (
  conf_id smallint(5) unsigned NOT NULL auto_increment,
  conf_name varchar(30) NOT NULL default '',
  conf_title varchar(30) NOT NULL default '',
  conf_value text NOT NULL,
  conf_desc varchar(50) NOT NULL default '',
  conf_formtype varchar(15) NOT NULL default '',
  conf_valuetype varchar(10) NOT NULL default '',
  conf_order smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (conf_id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

INSERT INTO myref_config VALUES (1, 'version', '', '1', '', 'hidden', 'hidden', 0);
INSERT INTO myref_config VALUES (2, 'lastraz', '', '25', '', 'hidden', 'hidden', 0);
INSERT INTO myref_config VALUES (3, 'count_admin', '_MYREFERER_COUNT_ADMIN', '0', '_MYREFERER_COUNT_ADMIN_DSC', 'yesno', 'int', 0);
INSERT INTO myref_config VALUES (4, 'module_blacklist', '_MYREFERER_MODULE_BLACKLIST', 'xoopsorgnews|xoops_redirect|user|search|notifications|viewpmsg|readpmsg|myreferer|newbb|system', '_MYREFERER_MODULE_BLACKLIST_DSC', 'textarea', 'text', 2);
INSERT INTO myref_config VALUES (5, '', '_MYREFERER_KEYWORD', '', '', 'insertBreak', 'hidden', 100);
INSERT INTO myref_config VALUES (6, 'keyword_min', '_MYREFERER_KEYWORD_MIN', '3', '_MYREFERER_KEYWORD_MIN_DSC', 'text', 'int', 101);
INSERT INTO myref_config VALUES (7, 'keyword_max', '_MYREFERER_KEYWORD_MAX', '24', '_MYREFERER_KEYWORD_MAX_DSC', 'text', 'int', 102);
INSERT INTO myref_config VALUES (8, 'punctation', '_MYREFERER_PUNCTATION', '1', '_MYREFERER_PUNCTATION_DSC', 'yesno', 'int', 103);
INSERT INTO myref_config VALUES (9, 'numbers', '_MYREFERER_NUMBERS', '0', '_MYREFERER_NUMBERS_DSC', 'yesno', 'int', 104);
INSERT INTO myref_config VALUES (10, 'smallcaps', '_MYREFERER_SMALLCAPS', '1', '_MYREFERER_SMALLCAPS_DSC', 'yesno', 'int', 105);
INSERT INTO myref_config VALUES (11, 'keyword_blacklist', '_MYREFERER_KEYWORD_BLACKLIST', 'pour|avec|dans|site', '_MYREFERER_KEYWORD_BLACKLIST_DSC', 'textarea', 'text', 106);
INSERT INTO myref_config VALUES (12, 'search_blacklist', '_MYREFERER_SEARCH_BLACKLIST', '', '_MYREFERER_SEARCH_BLACKLIST_DSC', 'textarea', 'text', 107);
INSERT INTO myref_config VALUES (13, '', '_MYREFERER_REFERER', '', '', 'insertBreak', 'hidden', 200);
INSERT INTO myref_config VALUES (14, 'referer_blacklist', '_MYREFERER_REFERER_BLACKLIST', '127.0.0.1|mail|xoopsorgnews', '_MYREFERER_REFERER_BLACKLIST_DSC', 'textarea', 'text', 201);
INSERT INTO myref_config VALUES (15, '', '_MYREFERER_ROBOTS', '', '', 'insertBreak', 'hidden', 300);
INSERT INTO myref_config VALUES (16, 'new_bot_smail', '_MYREFERER_NEW_BOT_SMAIL', '0', '_MYREFERER_NEW_BOT_SMAIL_DSC', 'yesno', 'int', 301);
INSERT INTO myref_config VALUES (17, 'new_bot_mail', '_MYREFERER_NEW_BOT_MAIL', '', '_MYREFERER_NEW_BOT_MAIL_DSC', 'text', 'text', 302);
INSERT INTO myref_config VALUES (18, 'robots_blacklist', '_MYREFERER_ROBOTS_BLACKLIST', 'W3C_Validator|Lynx|libwww-perl', '_MYREFERER_ROBOTS_BLACKLIST_DSC', 'textarea', 'text', 303);
INSERT INTO myref_config VALUES (19, 'page_prohibit', '_MYREFERER_PAGE_PROHIBIT', 'modules/myReferer/norobot.html', '_MYREFERER_PAGE_PROHIBIT_DSC', 'text', 'text', 304);
INSERT INTO myref_config VALUES (20, 'robots_prohibit', '_MYREFERER_ROBOTS_PROHIBIT', '', '_MYREFERER_ROBOTS_PROHIBIT_DSC', 'textarea', 'text', 305);
INSERT INTO myref_config VALUES (21, '', '_MYREFERER_USERVISIT', '', '', 'insertBreak', 'hidden', 100);
INSERT INTO myref_config VALUES (22, 'user_visit', '_MYREFERER_USER_VISIT', '0', '_MYREFERER_USER_VISIT_DSC', 'yesno', 'int', 401);
INSERT INTO myref_config VALUES (23, 'save_group', '_MYREFERER_SAVE_GROUP', 'a:2:{i:0;s:1:"2";i:1;s:1:"4";}', '_MYREFERER_SAVE_GROUP_DSC', 'select', 'array', 402);
INSERT INTO myref_config VALUES (24, '', '_MYREFERER_STATS', '', '', 'insertBreak', 'hidden', 400);
INSERT INTO myref_config VALUES (25, 'myref_pages_stats', '_MYREFERER_STATS_PAGES', '100', '_MYREFERER_STATS_PAGES_DSC', 'select', 'int', 500);
INSERT INTO myref_config VALUES (26, 'myref_query_stats', '_MYREFERER_STATS_QUERY', '100', '_MYREFERER_STATS_QUERY_DSC', 'select', 'int', 500);
INSERT INTO myref_config VALUES (27, 'myref_query_pages_stats', '_MYREFERER_STATS_QUERY_PAGES', '100', '_MYREFERER_STATS_QUERY_PAGES_DSC', 'select', 'int', 500);
INSERT INTO myref_config VALUES (28, 'myref_referer_stats', '_MYREFERER_STATS_REFERER', '100', '_MYREFERER_STATS_REFERER_DSC', 'select', 'int', 500);
INSERT INTO myref_config VALUES (29, 'myref_referer_pages_stats', '_MYREFERER_STATS_REFERER_PAGES', '100', '_MYREFERER_STATS_REFERER_PAGES_DSC', 'select', 'int', 500);
INSERT INTO myref_config VALUES (30, 'myref_robots_stats', '_MYREFERER_STATS_ROBOTS', '100', '_MYREFERER_STATS_ROBOTS_DSC', 'select', 'int', 500);
INSERT INTO myref_config VALUES (31, 'myref_robots_pages_stats', '_MYREFERER_STATS_ROBOTS_PAGES', '100', '_MYREFERER_STATS_ROBOTS_PAGES_DSC', 'select', 'int', 500);
INSERT INTO myref_config VALUES (32, 'myref_users_stats', '_MYREFERER_STATS_USERS', '100', '_MYREFERER_STATS_USERS_DSC', 'select', 'int', 500);
INSERT INTO myref_config VALUES (33, 'myref_users_pages_stats', '_MYREFERER_STATS_USERS_PAGES', '100', '_MYREFERER_STATS_USERS_PAGES_DSC', 'select', 'int', 500);

CREATE TABLE myref_pages (
  id int(8) NOT NULL auto_increment,
  page text NOT NULL,
  visit int(8) NOT NULL default '0',
  visit_tmp int(8) NOT NULL default '0',
  startdate int(11) NOT NULL default '0',
  date int(11) NOT NULL default '0',
  hide tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_pages_stats (
  id int(8) NOT NULL auto_increment,
  year int(4) NOT NULL default '0',
  week int(2) NOT NULL default '0',
  pagesid int(8) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_query (
  id int(8) NOT NULL auto_increment,
  query varchar(255) NOT NULL default '',
  keyword tinyint(2) NOT NULL default '0',
  page varchar(255) NOT NULL default '',
  visit int(8) NOT NULL default '0',
  visit_tmp int(8) NOT NULL default '0',
  startdate int(11) NOT NULL default '0',
  date int(11) NOT NULL default '0',
  hide tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_query_pages (
  id int(11) NOT NULL auto_increment,
  queryid int(8) NOT NULL default '0',
  pagesid int(8) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  visit_tmp int(8) NOT NULL default '0',
  startdate int(11) NOT NULL default '0',
  date int(11) NOT NULL default '0',
  hide tinyint(2) NOT NULL default '0',
  tracker tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_query_pages_stats (
  id int(11) NOT NULL auto_increment,
  year int(4) NOT NULL default '0',
  week int(2) NOT NULL default '0',
  queryid int(8) NOT NULL default '0',
  pagesid int(8) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_query_stats (
  id int(8) NOT NULL auto_increment,
  year int(4) NOT NULL default '0',
  week int(2) NOT NULL default '0',
  queryid int(8) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_referer (
  id int(8) NOT NULL auto_increment,
  engine tinyint(2) NOT NULL default '0',
  referer varchar(255) NOT NULL default '',
  ref_url varchar(255) NOT NULL default '',
  page varchar(255) NOT NULL default '',
  visit int(8) NOT NULL default '0',
  visit_tmp int(8) NOT NULL default '0',
  startdate int(11) NOT NULL default '0',
  date int(11) NOT NULL default '0',
  hide tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_referer_pages (
  id int(11) NOT NULL auto_increment,
  refererid int(8) NOT NULL default '0',
  pagesid int(8) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  visit_tmp int(8) NOT NULL default '0',
  startdate int(11) NOT NULL default '0',
  date int(11) NOT NULL default '0',
  hide tinyint(2) NOT NULL default '0',
  tracker tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_referer_pages_stats (
  id int(11) NOT NULL auto_increment,
  year int(4) NOT NULL default '0',
  week int(2) NOT NULL default '0',
  refererid int(8) NOT NULL default '0',
  pagesid int(8) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_referer_stats (
  id int(8) NOT NULL auto_increment,
  year int(4) NOT NULL default '0',
  week int(2) NOT NULL default '0',
  refererid int(8) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_robots (
  id int(8) NOT NULL auto_increment,
  robots varchar(255) NOT NULL default '',
  ref_url varchar(255) NOT NULL default '',
  page varchar(255) NOT NULL default '',
  visit int(8) NOT NULL default '0',
  visit_tmp int(8) NOT NULL default '0',
  startdate int(11) NOT NULL default '0',
  date int(11) NOT NULL default '0',
  hide tinyint(2) NOT NULL default '0',
  tracker tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_robots_pages (
  id int(11) NOT NULL auto_increment,
  robotsid int(8) NOT NULL default '0',
  pagesid int(8) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  visit_tmp int(8) NOT NULL default '0',
  startdate int(11) NOT NULL default '0',
  date int(11) NOT NULL default '0',
  hide tinyint(2) NOT NULL default '0',
  tracker tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_robots_pages_stats (
  id int(11) NOT NULL auto_increment,
  year int(4) NOT NULL default '0',
  week int(2) NOT NULL default '0',
  robotsid int(8) NOT NULL default '0',
  pagesid int(8) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_robots_stats (
  id int(8) NOT NULL auto_increment,
  year int(4) NOT NULL default '0',
  week int(2) NOT NULL default '0',
  robotsid int(8) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_users (
  id int(8) NOT NULL auto_increment,
  user int(16) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  visit_tmp int(8) NOT NULL default '0',
  startdate int(11) NOT NULL default '0',
  date int(11) NOT NULL default '0',
  hide tinyint(2) NOT NULL default '0',
  tracker tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_users_pages (
  id int(11) NOT NULL auto_increment,
  usersid int(8) NOT NULL default '0',
  pagesid int(8) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  visit_tmp int(8) NOT NULL default '0',
  startdate int(11) NOT NULL default '0',
  date int(11) NOT NULL default '0',
  hide tinyint(2) NOT NULL default '0',
  tracker tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_users_pages_stats (
  id int(11) NOT NULL auto_increment,
  year int(4) NOT NULL default '0',
  week int(2) NOT NULL default '0',
  usersid int(8) NOT NULL default '0',
  pagesid int(8) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';

CREATE TABLE myref_users_stats (
  id int(8) NOT NULL auto_increment,
  year int(4) NOT NULL default '0',
  week int(2) NOT NULL default '0',
  usersid int(8) NOT NULL default '0',
  visit int(8) NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='myReferer - solo (http://www.wolfpackclan.com)';