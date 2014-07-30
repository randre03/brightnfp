-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2012 at 03:48 AM
-- Server version: 5.0.95
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_churchesnpo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Inactive','Active','Deleted') NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `status`, `created`, `modified`) VALUES
(1, 'admin', '123456', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `status` enum('Inactive','Active','Deleted') NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `status`, `created`, `modified`) VALUES
(1, 'template1', 'Active', '2011-12-02 12:41:44', '2011-12-02 12:41:44'),
(2, 'template2', 'Active', '2011-12-02 12:41:44', '2011-12-02 12:41:44'),
(3, 'template3', 'Active', '2011-12-02 12:41:44', '2011-12-02 12:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `template_sections`
--

CREATE TABLE IF NOT EXISTS `template_sections` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `status` enum('Inactive','Active','Deleted') NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `template_sections`
--

INSERT INTO `template_sections` (`id`, `name`, `status`, `created`, `modified`) VALUES
(1, 'Home', 'Active', '2011-11-16 00:00:00', '2011-11-16 00:00:00'),
(2, 'About us', 'Active', '2011-11-18 11:18:17', '2011-11-16 00:00:00'),
(3, 'Contact us', 'Active', '2011-08-26 12:30:49', '2011-08-26 12:30:49'),
(4, 'Web Store', 'Active', '2011-08-26 12:30:49', '2011-08-26 12:30:49'),
(5, 'Product and Services', 'Active', '2011-08-26 12:30:49', '2011-08-26 12:30:49'),
(6, 'Calender', 'Active', '2011-08-26 12:30:49', '2011-08-26 12:30:49'),
(7, 'Testimonial', 'Active', '2011-08-26 12:30:49', '2011-08-26 12:30:49'),
(8, 'Blog', 'Active', '2011-08-26 12:30:49', '2011-08-26 12:30:49'),
(9, 'Photogallery ', 'Active', '2011-08-26 12:30:49', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `template_themes`
--

CREATE TABLE IF NOT EXISTS `template_themes` (
  `id` int(11) NOT NULL auto_increment,
  `template_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `html` text NOT NULL,
  `event_html` text NOT NULL,
  `news_html` text NOT NULL,
  `layout_name` varchar(255) NOT NULL,
  `status` enum('Inactive','Active','Deleted') NOT NULL default 'Active',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `template_themes`
--

INSERT INTO `template_themes` (`id`, `template_id`, `name`, `image`, `html`, `event_html`, `news_html`, `layout_name`, `status`, `created`, `modified`) VALUES
(1, 1, 'theme1', 'theme1.jpg', '    <!-- Single Post-->\r\n     <div class="post">\r\n    	<h1 class="post_title">{title1}</h1>\r\n        <p class="post_content"><img src="{source}">{desc1}</p>\r\n<span class="readmore"></span>\r\n     </div>\r\n    <!-- Single Post End -->\r\n     \r\n     <div class="post">\r\n    	<h1 class="post_title">{title2}</h1>\r\n        <p class="post_content">{desc2}</p>\r\n       <span class="readmore"></span>\r\n     </div>\r\n     \r\n     <div class="post">\r\n    	<h1 class="post_title">{title3}</h1>\r\n        <p class="post_content">{desc3}</p>\r\n        <span class="readmore"></span>\r\n     </div>', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/events/eventdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/news/newsdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', 'template1', 'Active', '2011-10-24 10:44:17', '2011-10-31 16:53:12'),
(2, 1, 'theme2', 'theme2.jpg', '    <!-- Single Post-->\r\n     <div class="post">\r\n    	<h1 class="post_title">{title1}</h1>\r\n        <p class="post_content"><img src="{source}">{desc1}</p>\r\n<span class="readmore"></span>\r\n     </div>\r\n    <!-- Single Post End -->\r\n     \r\n     <div class="post">\r\n    	<h1 class="post_title">{title2}</h1>\r\n        <p class="post_content">{desc2}</p>\r\n       <span class="readmore"></span>\r\n     </div>\r\n     \r\n     <div class="post">\r\n    	<h1 class="post_title">{title3}</h1>\r\n        <p class="post_content">{desc3}</p>\r\n        <span class="readmore"></span>\r\n     </div>', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}</p>\r\n       <span class="readmore"></span>\r\n     </div>', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/news/newsdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', 'template1', 'Active', '2011-10-17 00:00:00', '2011-10-31 16:53:08'),
(3, 1, 'theme3', 'theme3.jpg', '    <!-- Single Post-->\r\n     <div class="post">\r\n    	<h1 class="post_title">{title1}</h1>\r\n        <p class="post_content"><img src="{source}">{desc1}</p>\r\n<span class="readmore"></span>\r\n     </div>\r\n    <!-- Single Post End -->\r\n     \r\n     <div class="post">\r\n    	<h1 class="post_title">{title2}</h1>\r\n        <p class="post_content">{desc2}</p>\r\n       <span class="readmore"></span>\r\n     </div>\r\n     \r\n     <div class="post">\r\n    	<h1 class="post_title">{title3}</h1>\r\n        <p class="post_content">{desc3}</p>\r\n        <span class="readmore"></span>\r\n     </div>', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}</p>\r\n       <span class="readmore"></span>\r\n     </div>', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/news/newsdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', 'template1', 'Active', '2011-10-21 15:15:25', '2011-12-19 11:47:06'),
(4, 2, 'theme1', 'theme1.jpg', '        <!-- Post start-->\r\n        <div class="post">\r\n        <h1>{title2}</h1>\r\n        {desc2}\r\n        </div>\r\n        <!--post End --> \r\n        <div class="post">\r\n        <h1>{title3}</h1>\r\n        {desc3}\r\n        </div>\r\n        <div class="post">\r\n        <h1>{title4}</h1>        \r\n        {desc4}\r\n        </div>\r\n        <div class="post">\r\n        <h1>{title5}</h1>\r\n        {desc5}\r\n        </div> ', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/events/eventdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/news/newsdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', 'template2', 'Active', '2011-10-21 15:15:25', '2011-10-21 15:15:25'),
(5, 2, 'theme2', 'theme2.jpg', '        <!-- Post start-->\r\n        <div class="post">\r\n        <h1>{title2}</h1>\r\n        {desc2}\r\n        </div>\r\n        <!--post End --> \r\n        <div class="post">\r\n        <h1>{title3}</h1>\r\n        {desc3}\r\n        </div>\r\n        <div class="post">\r\n        <h1>{title4}</h1>        \r\n        {desc4}\r\n        </div>\r\n        <div class="post">\r\n        <h1>{title5}</h1>\r\n        {desc5}\r\n        </div> ', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/events/eventdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/news/newsdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', 'template2', 'Active', '2011-10-21 15:15:25', '2011-10-21 15:15:25'),
(6, 2, 'theme3', 'theme3.jpg', '        <!-- Post start-->\r\n        <div class="post">\r\n        <h1>{title2}</h1>\r\n        {desc2}\r\n        </div>\r\n        <!--post End --> \r\n        <div class="post">\r\n        <h1>{title3}</h1>\r\n        {desc3}\r\n        </div>\r\n        <div class="post">\r\n        <h1>{title4}</h1>        \r\n        {desc4}\r\n        </div>\r\n        <div class="post">\r\n        <h1>{title5}</h1>\r\n        {desc5}\r\n        </div> ', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/events/eventdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/news/newsdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', 'template2', 'Active', '2011-10-21 15:15:25', '2011-10-21 15:15:25'),
(7, 3, 'theme1', 'theme1.jpg', '        <!-- Post start-->\r\n        <div class="post">\r\n        <h1>{title2}</h1>\r\n        {desc2}\r\n        </div>\r\n        <!--post End --> \r\n        <div class="post">\r\n        <h1>{title3}</h1>\r\n         {desc3}\r\n        </div>\r\n        <div class="post">\r\n        <h1>{title4}</h1>\r\n         {desc4}\r\n        </div>\r\n        <div class="post">\r\n        <h1>{title5}</h1>\r\n        {desc5}\r\n        </div> ', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/events/eventdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/news/newsdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', 'template3', 'Active', '2011-10-21 15:15:25', '2011-10-21 15:15:25'),
(8, 3, 'theme2', 'theme2.jpg', '        <!-- Post start-->\r\n        <div class="post">\r\n        <h1>{title2}</h1>\r\n        {desc2}\r\n        </div>\r\n        <!--post End --> \r\n        <div class="post">\r\n        <h1>{title3}</h1>\r\n         {desc3}\r\n        </div>\r\n        <div class="post">\r\n        <h1>{title4}</h1>\r\n         {desc4}\r\n        </div>\r\n        <div class="post">\r\n        <h1>{title5}</h1>\r\n        {desc5}\r\n        </div> ', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/events/eventdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/news/newsdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', 'template3', 'Active', '2011-10-21 15:15:25', '2011-10-21 15:15:25'),
(9, 3, 'theme3', 'theme3.jpg', '        <!-- Post start-->\r\n        <div class="post">\r\n        <h1>{title2}</h1>\r\n        {desc2}\r\n        </div>\r\n        <!--post End --> \r\n        <div class="post">\r\n        <h1>{title3}</h1>\r\n         {desc3}\r\n        </div>\r\n        <div class="post">\r\n        <h1>{title4}</h1>\r\n         {desc4}\r\n        </div>\r\n        <div class="post">\r\n        <h1>{title5}</h1>\r\n        {desc5}\r\n        </div> ', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/events/eventdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', '<div class="post">\r\n    	<h1 class="post_title">{title}</h1>\r\n        <p class="post_content"><img src="{source}">{desc}<div class="right_buttons">\r\n                                      <div class="margin_lft"><a class="button_link" href="/news/newsdetail/{npo_id}/{event_id}">View</a>&nbsp;{paypal_btn}</div>                      </div></p>\r\n       <span class="readmore"></span>\r\n     </div>', 'template3', 'Active', '2011-10-21 15:15:25', '2011-10-21 15:15:25');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
