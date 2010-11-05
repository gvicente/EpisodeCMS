-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 19 2010 г., 06:19
-- Версия сервера: 5.1.41
-- Версия PHP: 5.3.2-1ubuntu4.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `episode`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '',
  `slug` varchar(255) DEFAULT '',
  `category_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `category_id`) VALUES
(1, 'Video', 'video', 0),
(2, 'Music', 'music', 0),
(3, 'my new', 'my-new', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `post_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `comments`
--


-- --------------------------------------------------------

--
-- Структура таблицы `galleries`
--

CREATE TABLE IF NOT EXISTS `galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) DEFAULT '',
  `title` varchar(255) DEFAULT '',
  `slug` varchar(255) DEFAULT '',
  `description` text,
  `info` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `galleries`
--

INSERT INTO `galleries` (`id`, `photo`, `title`, `slug`, `description`, `info`) VALUES
(1, '/public/37c4369f55752e513248a49925eaa661.jpg', 'fds fd', 'fds-fd', '<p>fdsfds</p>', '<p>fdsfds</p>'),
(2, '', 'das', 'das', '<p>hgf</p>', '<p>hgfhgf</p>'),
(3, '', 'das', 'das', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `mokas`
--

CREATE TABLE IF NOT EXISTS `mokas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lix` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `mokas`
--


-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(255) DEFAULT '',
  `object` varchar(255) DEFAULT '',
  `text` varchar(255) DEFAULT '',
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `notifications`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '',
  `slug` varchar(255) DEFAULT '',
  `content` text,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `draft` tinyint(1) DEFAULT '0',
  `parent_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `created`, `modified`, `draft`, `parent_id`) VALUES
(2, 'About', 'about', '<p>CakePHP is the best <strong>framework</strong> I have ever seen. But there is no good CMS. Let''s change it!</p>\r\n<p>Main module information stored in module''s config file: database  structure, admin menu links, routes, etc. Learn how it''s done in /modules/core/core.yml and /modules/blog/blog.yml.</p>\r\n<p>Code style and architecture are similar to <a href="http://cakephp.org/" target="_blank">CakePHP</a>.</p>\r\n<ul>\r\n<li>/modules/module-name/module-name.yml is main module file with configuration and description.</li>\r\n<li>/modules/module-name/public/icon.png is module icon in dashboard.</li>\r\n<li>/modules/module-name/public/ for css, images and javascript</li>\r\n<li>/modules/module-name/controller_name_controller.php for controller class</li>\r\n<li>/modules/module-name/components/component_name.php for component class</li>\r\n<li>/modules/module-name/models/model_name.php for model class</li>\r\n<li>/modules/module-name/views/controller_name/view_name.ctp for view</li>\r\n<li>/modules/module-name/views/helpers/helper_name.php for helper class</li>\r\n<li>/modules/module-name/views/elements/element_name.ctp for element<br /> <br /> </li>\r\n<li>/themes/theme-name/page.ctp for main theme''s layout</li>\r\n<li>/themes/theme-name/style.css for theme''s stylesheet</li>\r\n<li>/themes/theme-name/screenshot.png for theme''s screenshot</li>\r\n<li>/themes/theme-name/theme.yml for theme''s configuration<br /> <br /> </li>\r\n<li>/vendors/ for CakePHP, CakePHP configurations, libraries, etc.</li>\r\n<li>/public/ for uploads</li>\r\n<li>/tmp/ for cache and temp</li>\r\n</ul>', '2010-08-16 16:56:11', '2010-09-19 05:34:32', 0, 0),
(3, 'Blah', 'test', '<p>I am testing this <strong>CMS....</strong></p>\r\n<p>&nbsp;</p>', '2010-09-15 14:02:59', '2010-09-15 14:02:59', 0, 0),
(5, 'dsfsd', 'dsfsd', '<p>fsdfsfsdfsdfsdsd</p>', '2010-09-18 04:30:06', '2010-09-18 04:30:06', 0, 0),
(6, 'fdsfsdfsdfds', 'fdsfsdfsdfds', '<p>fsdfsdfsdfsdsd</p>', '2010-09-18 04:30:15', '2010-09-18 04:30:15', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `page_categories`
--

CREATE TABLE IF NOT EXISTS `page_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT '0',
  `category_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `page_categories`
--


-- --------------------------------------------------------

--
-- Структура таблицы `page_tags`
--

CREATE TABLE IF NOT EXISTS `page_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT '0',
  `tag_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `page_tags`
--

INSERT INTO `page_tags` (`id`, `page_id`, `tag_id`) VALUES
(2, 1, 2),
(8, 2, 4),
(6, 7, 4),
(7, 7, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `portfolios`
--

CREATE TABLE IF NOT EXISTS `portfolios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thumb` varchar(255) DEFAULT '',
  `title` varchar(255) DEFAULT '',
  `slug` varchar(255) DEFAULT '',
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `portfolios`
--

INSERT INTO `portfolios` (`id`, `thumb`, `title`, `slug`, `content`) VALUES
(1, '/public/80a5f17763e2e7818d94ba7c0687f751.jpg', 'Test', 'test', '<p>nejaky textik, this is my super uper reference</p>');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) DEFAULT '',
  `title` varchar(255) DEFAULT '',
  `slug` varchar(255) DEFAULT '',
  `content` text,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `publish_start` datetime DEFAULT '0000-00-00 00:00:00',
  `publish_end` datetime DEFAULT '0000-00-00 00:00:00',
  `draft` tinyint(1) DEFAULT '0',
  `parent_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `photo`, `title`, `slug`, `content`, `created`, `modified`, `publish_start`, `publish_end`, `draft`, `parent_id`) VALUES
(1, '', 'My dear friends', 'my-dear-friends', '<p>Congratulations!</p>\r\n<p>You just installed <a href="http://razbakov.com/episode/">EpisodeCMS</a>. Enjoy it!</p>', '2010-08-09 13:21:26', '2010-09-15 19:29:05', NULL, NULL, 0, 0),
(2, '', 'New one', 'new-one', '<p>Just testing</p>', '2010-09-14 17:24:55', '2010-09-19 04:33:33', NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `post_categories`
--

CREATE TABLE IF NOT EXISTS `post_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT '0',
  `category_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `post_categories`
--


-- --------------------------------------------------------

--
-- Структура таблицы `post_tags`
--

CREATE TABLE IF NOT EXISTS `post_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT '0',
  `tag_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=124 ;

--
-- Дамп данных таблицы `post_tags`
--

INSERT INTO `post_tags` (`id`, `post_id`, `tag_id`) VALUES
(111, 3, 20);

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '',
  `slug` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`id`, `title`, `slug`) VALUES
(4, 'fun', 'fun'),
(3, 'sad', 'sad'),
(5, 'real', '');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT '',
  `password` varchar(255) DEFAULT '',
  `photo` varchar(255) DEFAULT '',
  `email` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `photo`, `email`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '/public/4225b634c70ba1372a67f9005e0a1de7.jpg', 'razbakov.aleksey@gmail.com');
