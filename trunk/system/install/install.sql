SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `voting`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(255) character set latin1 NOT NULL default '21232f297a57a5a743894a0e4a801fc3' COMMENT 'Stores the md5 hash of the username.',
  `password` varchar(255) character set latin1 NOT NULL default '21232f297a57a5a743894a0e4a801fc3' COMMENT 'Stores the md5 hash of the password.'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Stores the md5 hashes of the username and password.';

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('21232f297a57a5a743894a0e4a801fc3', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL auto_increment COMMENT 'ID of question.',
  `show` tinyint(1) NOT NULL default '1' COMMENT 'Visibility of question.',
  `question` text COMMENT 'Stores the question of a poll.',
  `a1` text,
  `a2` text,
  `a3` text,
  `a4` text,
  `a5` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Stores the ID, question, answers and state of visibility.' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `show`, `question`, `a1`, `a2`, `a3`, `a4`, `a5`) VALUES
(1, 1, '[Example] QUESTION', '[Example] ANSWER1', '[Example] ANSWER2', '[Example] ANSWER3', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Stores the ID of the question which the results correspond to.',
  `a1` int(11) default NULL,
  `a2` int(11) default NULL,
  `a3` int(11) default NULL,
  `a4` int(11) default NULL,
  `a5` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Stores the ID and number of votes for different answers.';

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `a1`, `a2`, `a3`, `a4`, `a5`) VALUES
(1, 0, 0, 0, 0, 0);
