
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- --------------------------------------------------------

--
-- テーブルの構造 `areas`
--

CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `color` varchar(20) NOT NULL,
  `date` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `belongs` varchar(50) NOT NULL,
  `presentation_id` int(11) NOT NULL,
  `first` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `commentators`
--

CREATE TABLE IF NOT EXISTS `commentators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `belongs` varchar(100) NOT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `disuses`
--

CREATE TABLE IF NOT EXISTS `disuses` (
  `event_id` int(10) NOT NULL,
  `date` int(5) NOT NULL,
  PRIMARY KEY (`event_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `eachdays`
--

CREATE TABLE IF NOT EXISTS `eachdays` (
  `event_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `canvas_width` int(11) NOT NULL,
  `canvas_height` int(11) NOT NULL,
  PRIMARY KEY (`event_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `editors`
--

CREATE TABLE IF NOT EXISTS `editors` (
  `account_id` int(11) NOT NULL DEFAULT '0',
  `event_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_id`,`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short_event_name` varchar(100) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_location` varchar(100) NOT NULL,
  `event_begin_date` date NOT NULL,
  `event_begin_time` time NOT NULL,
  `event_end_date` date NOT NULL,
  `event_end_time` time NOT NULL,
  `event_webpage` varchar(100) NOT NULL,
  `unique_str` varchar(8) NOT NULL,
  `set_floormap` tinyint(1) DEFAULT '0',
  `set_topimage` tinyint(1) NOT NULL DEFAULT '0',
  `set_posterbg` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_str` (`unique_str`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `posters`
--

CREATE TABLE IF NOT EXISTS `posters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `presentation_id` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `color` varchar(10) NOT NULL,
  `area_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=311 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `presentations`
--

CREATE TABLE IF NOT EXISTS `presentations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room` varchar(10) NOT NULL,
  `session_order` int(11) NOT NULL,
  `presentation_order` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `abstract` text NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `authors_name` varchar(100) NOT NULL,
  `authors_affiliation` varchar(100) NOT NULL,
  `session_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=723 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `order` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=954 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room` varchar(50) NOT NULL,
  `order` int(50) NOT NULL,
  `category` varchar(100) NOT NULL,
  `chairperson_name` varchar(100) NOT NULL,
  `chairperson_affiliation` varchar(100) NOT NULL,
  `commentator_name` varchar(100) NOT NULL,
  `commentator_affiliation` varchar(100) NOT NULL,
  `date` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3096 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;
