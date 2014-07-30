-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2012 at 03:51 AM
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
-- Table structure for table `attributes`
--

CREATE TABLE IF NOT EXISTS `attributes` (
  `id` int(11) NOT NULL auto_increment,
  `npo_id` int(11) NOT NULL,
  `type` enum('Event','News','Activity') NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `thumb_name` varchar(255) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_donate` enum('Yes','No') NOT NULL default 'Yes',
  `status` enum('Inactive','Active','Deleted') NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_messages`
--

CREATE TABLE IF NOT EXISTS `attribute_messages` (
  `id` int(11) NOT NULL auto_increment,
  `attribute_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Inactive','Active','Deleted') NOT NULL default 'Active',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE IF NOT EXISTS `donations` (
  `id` int(11) NOT NULL auto_increment,
  `amount` varchar(255) NOT NULL,
  `npo_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `attribute_id` int(11) default NULL,
  `status` enum('Success','Failed') NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE IF NOT EXISTS `fees` (
  `id` int(11) NOT NULL auto_increment,
  `amount` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instant_payment_notifications`
--

CREATE TABLE IF NOT EXISTS `instant_payment_notifications` (
  `id` char(36) NOT NULL,
  `npo_id` int(11) NOT NULL,
  `notify_version` varchar(64) default NULL COMMENT 'IPN Version Number',
  `verify_sign` varchar(127) default NULL COMMENT 'Encrypted string used to verify the authenticityof the tansaction',
  `test_ipn` int(11) default NULL,
  `address_city` varchar(40) default NULL COMMENT 'City of customers address',
  `address_country` varchar(64) default NULL COMMENT 'Country of customers address',
  `address_country_code` varchar(2) default NULL COMMENT 'Two character ISO 3166 country code',
  `address_name` varchar(128) default NULL COMMENT 'Name used with address (included when customer provides a Gift address)',
  `address_state` varchar(40) default NULL COMMENT 'State of customer address',
  `address_status` varchar(20) default NULL COMMENT 'confirmed/unconfirmed',
  `address_street` varchar(200) default NULL COMMENT 'Customer''s street address',
  `address_zip` varchar(20) default NULL COMMENT 'Zip code of customer''s address',
  `first_name` varchar(64) default NULL COMMENT 'Customer''s first name',
  `last_name` varchar(64) default NULL COMMENT 'Customer''s last name',
  `payer_business_name` varchar(127) default NULL COMMENT 'Customer''s company name, if customer represents a business',
  `payer_email` varchar(127) default NULL COMMENT 'Customer''s primary email address. Use this email to provide any credits',
  `payer_id` varchar(13) default NULL COMMENT 'Unique customer ID.',
  `payer_status` varchar(20) default NULL COMMENT 'verified/unverified',
  `contact_phone` varchar(20) default NULL COMMENT 'Customer''s telephone number.',
  `residence_country` varchar(2) default NULL COMMENT 'Two-Character ISO 3166 country code',
  `business` varchar(127) default NULL COMMENT 'Email address or account ID of the payment recipient (that is, the merchant). Equivalent to the values of receiver_email (If payment is sent to primary account) and business set in the Website Payment HTML.',
  `item_name` varchar(127) default NULL COMMENT 'Item name as passed by you, the merchant. Or, if not passed by you, as entered by your customer. If this is a shopping cart transaction, Paypal will append the number of the item (e.g., item_name_1,item_name_2, and so forth).',
  `item_number` varchar(127) default NULL COMMENT 'Pass-through variable for you to track purchases. It will get passed back to you at the completion of the payment. If omitted, no variable will be passed back to you.',
  `quantity` varchar(127) default NULL COMMENT 'Quantity as entered by your customer or as passed by you, the merchant. If this is a shopping cart transaction, PayPal appends the number of the item (e.g., quantity1,quantity2).',
  `receiver_email` varchar(127) default NULL COMMENT 'Primary email address of the payment recipient (that is, the merchant). If the payment is sent to a non-primary email address on your PayPal account, the receiver_email is still your primary email.',
  `receiver_id` varchar(13) default NULL COMMENT 'Unique account ID of the payment recipient (i.e., the merchant). This is the same as the recipients referral ID.',
  `custom` varchar(255) default NULL COMMENT 'Custom value as passed by you, the merchant. These are pass-through variables that are never presented to your customer.',
  `invoice` varchar(127) default NULL COMMENT 'Pass through variable you can use to identify your invoice number for this purchase. If omitted, no variable is passed back.',
  `memo` varchar(255) default NULL COMMENT 'Memo as entered by your customer in PayPal Website Payments note field.',
  `option_name1` varchar(64) default NULL COMMENT 'Option name 1 as requested by you',
  `option_name2` varchar(64) default NULL COMMENT 'Option 2 name as requested by you',
  `option_selection1` varchar(200) default NULL COMMENT 'Option 1 choice as entered by your customer',
  `option_selection2` varchar(200) default NULL COMMENT 'Option 2 choice as entered by your customer',
  `tax` decimal(10,2) default NULL COMMENT 'Amount of tax charged on payment',
  `auth_id` varchar(19) default NULL COMMENT 'Authorization identification number',
  `auth_exp` varchar(28) default NULL COMMENT 'Authorization expiration date and time, in the following format: HH:MM:SS DD Mmm YY, YYYY PST',
  `auth_amount` int(11) default NULL COMMENT 'Authorization amount',
  `auth_status` varchar(20) default NULL COMMENT 'Status of authorization',
  `num_cart_items` int(11) default NULL COMMENT 'If this is a PayPal shopping cart transaction, number of items in the cart',
  `parent_txn_id` varchar(19) default NULL COMMENT 'In the case of a refund, reversal, or cancelled reversal, this variable contains the txn_id of the original transaction, while txn_id contains a new ID for the new transaction.',
  `payment_date` varchar(28) default NULL COMMENT 'Time/date stamp generated by PayPal, in the following format: HH:MM:SS DD Mmm YY, YYYY PST',
  `payment_status` varchar(20) default NULL COMMENT 'Payment status of the payment',
  `payment_type` varchar(10) default NULL COMMENT 'echeck/instant',
  `pending_reason` varchar(20) default NULL COMMENT 'This variable is only set if payment_status=pending',
  `reason_code` varchar(20) default NULL COMMENT 'This variable is only set if payment_status=reversed',
  `remaining_settle` int(11) default NULL COMMENT 'Remaining amount that can be captured with Authorization and Capture',
  `shipping_method` varchar(64) default NULL COMMENT 'The name of a shipping method from the shipping calculations section of the merchants account profile. The buyer selected the named shipping method for this transaction',
  `shipping` decimal(10,2) default NULL COMMENT 'Shipping charges associated with this transaction. Format unsigned, no currency symbol, two decimal places',
  `transaction_entity` varchar(20) default NULL COMMENT 'Authorization and capture transaction entity',
  `txn_id` varchar(19) default '' COMMENT 'A unique transaction ID generated by PayPal',
  `txn_type` varchar(20) default NULL COMMENT 'cart/express_checkout/send-money/virtual-terminal/web-accept',
  `exchange_rate` decimal(10,2) default NULL COMMENT 'Exchange rate used if a currency conversion occured',
  `mc_currency` varchar(3) default NULL COMMENT 'Three character country code. For payment IPN notifications, this is the currency of the payment, for non-payment subscription IPN notifications, this is the currency of the subscription.',
  `mc_fee` decimal(10,2) default NULL COMMENT 'Transaction fee associated with the payment, mc_gross minus mc_fee equals the amount deposited into the receiver_email account. Equivalent to payment_fee for USD payments. If this amount is negative, it signifies a refund or reversal, and either ofthose p',
  `mc_gross` decimal(10,2) default NULL COMMENT 'Full amount of the customer''s payment',
  `mc_handling` decimal(10,2) default NULL COMMENT 'Total handling charge associated with the transaction',
  `mc_shipping` decimal(10,2) default NULL COMMENT 'Total shipping amount associated with the transaction',
  `payment_fee` decimal(10,2) default NULL COMMENT 'USD transaction fee associated with the payment',
  `payment_gross` decimal(10,2) default NULL COMMENT 'Full USD amount of the customers payment transaction, before payment_fee is subtracted',
  `settle_amount` decimal(10,2) default NULL COMMENT 'Amount that is deposited into the account''s primary balance after a currency conversion',
  `settle_currency` varchar(3) default NULL COMMENT 'Currency of settle amount. Three digit currency code',
  `auction_buyer_id` varchar(64) default NULL COMMENT 'The customer''s auction ID.',
  `auction_closing_date` varchar(28) default NULL COMMENT 'The auction''s close date. In the format: HH:MM:SS DD Mmm YY, YYYY PSD',
  `auction_multi_item` int(11) default NULL COMMENT 'The number of items purchased in multi-item auction payments',
  `for_auction` varchar(10) default NULL COMMENT 'This is an auction payment - payments made using Pay for eBay Items or Smart Logos - as well as send money/money request payments with the type eBay items or Auction Goods(non-eBay)',
  `subscr_date` varchar(28) default NULL COMMENT 'Start date or cancellation date depending on whether txn_type is subcr_signup or subscr_cancel',
  `subscr_effective` varchar(28) default NULL COMMENT 'Date when a subscription modification becomes effective',
  `period1` varchar(10) default NULL COMMENT '(Optional) Trial subscription interval in days, weeks, months, years (example a 4 day interval is 4 D',
  `period2` varchar(10) default NULL COMMENT '(Optional) Trial period',
  `period3` varchar(10) default NULL COMMENT 'Regular subscription interval in days, weeks, months, years',
  `amount1` decimal(10,2) default NULL COMMENT 'Amount of payment for Trial period 1 for USD',
  `amount2` decimal(10,2) default NULL COMMENT 'Amount of payment for Trial period 2 for USD',
  `amount3` decimal(10,2) default NULL COMMENT 'Amount of payment for regular subscription  period 1 for USD',
  `mc_amount1` decimal(10,2) default NULL COMMENT 'Amount of payment for trial period 1 regardless of currency',
  `mc_amount2` decimal(10,2) default NULL COMMENT 'Amount of payment for trial period 2 regardless of currency',
  `mc_amount3` decimal(10,2) default NULL COMMENT 'Amount of payment for regular subscription period regardless of currency',
  `recurring` varchar(1) default NULL COMMENT 'Indicates whether rate recurs (1 is yes, blank is no)',
  `reattempt` varchar(1) default NULL COMMENT 'Indicates whether reattempts should occur on payment failure (1 is yes, blank is no)',
  `retry_at` varchar(28) default NULL COMMENT 'Date PayPal will retry a failed subscription payment',
  `recur_times` int(11) default NULL COMMENT 'The number of payment installations that will occur at the regular rate',
  `username` varchar(64) default NULL COMMENT '(Optional) Username generated by PayPal and given to subscriber to access the subscription',
  `password` varchar(24) default NULL COMMENT '(Optional) Password generated by PayPal and given to subscriber to access the subscription (Encrypted)',
  `subscr_id` varchar(19) default NULL COMMENT 'ID generated by PayPal for the subscriber',
  `case_id` varchar(28) default NULL COMMENT 'Case identification number',
  `case_type` varchar(28) default NULL COMMENT 'complaint/chargeback',
  `case_creation_date` varchar(28) default NULL COMMENT 'Date/Time the case was registered',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL auto_increment,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('Inactive','Active','Deleted') NOT NULL default 'Active',
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL auto_increment,
  `sender_id` int(11) NOT NULL,
  `reciever_id` int(11) NOT NULL,
  `read` enum('Yes','No') NOT NULL default 'No',
  `sender` enum('Admin','NPO') NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `admin_deleted` enum('Yes','No') NOT NULL default 'No',
  `npo_deleted` enum('Yes','No') NOT NULL default 'No',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `npos`
--

CREATE TABLE IF NOT EXISTS `npos` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `taxid` varchar(255) NOT NULL,
  `corporate_name` varchar(255) NOT NULL,
  `corporate_address` text NOT NULL,
  `status` enum('Inactive','Active','Deleted') NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `npo_contents`
--

CREATE TABLE IF NOT EXISTS `npo_contents` (
  `id` int(11) NOT NULL auto_increment,
  `npo_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `window_title` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `first_title` varchar(255) NOT NULL,
  `first_desc` text NOT NULL,
  `second_title` varchar(255) NOT NULL,
  `second_desc` text NOT NULL,
  `third_title` varchar(255) NOT NULL,
  `third_desc` text NOT NULL,
  `fourth_title` varchar(255) NOT NULL,
  `fourth_desc` text NOT NULL,
  `fifth_title` varchar(255) NOT NULL,
  `fifth_desc` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `npo_members`
--

CREATE TABLE IF NOT EXISTS `npo_members` (
  `id` int(11) NOT NULL auto_increment,
  `npo_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `status` enum('Active','Inactive','Deleted') NOT NULL default 'Active',
  `seen` enum('Yes','No') NOT NULL default 'No',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `npo_templates`
--

CREATE TABLE IF NOT EXISTS `npo_templates` (
  `id` int(11) NOT NULL auto_increment,
  `npo_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `template_theme_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `npo_template_sections`
--

CREATE TABLE IF NOT EXISTS `npo_template_sections` (
  `id` int(11) NOT NULL auto_increment,
  `npo_id` int(11) NOT NULL,
  `template_section_id` int(11) NOT NULL,
  `status` enum('Inactive','Active','Deleted') NOT NULL default 'Active',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paypal_items`
--

CREATE TABLE IF NOT EXISTS `paypal_items` (
  `id` varchar(36) NOT NULL,
  `instant_payment_notification_id` varchar(36) NOT NULL,
  `item_name` varchar(127) default NULL,
  `item_number` varchar(127) default NULL,
  `quantity` varchar(127) default NULL,
  `mc_gross` float(10,2) default NULL,
  `mc_shipping` float(10,2) default NULL,
  `mc_handling` float(10,2) default NULL,
  `tax` float(10,2) default NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL auto_increment,
  `attribute_id` int(11) NOT NULL,
  `npo_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `status` enum('Inactive','Active','Deleted') NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE IF NOT EXISTS `subscribers` (
  `id` int(11) NOT NULL auto_increment,
  `email_id` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
