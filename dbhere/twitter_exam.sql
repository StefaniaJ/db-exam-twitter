-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2020 at 07:33 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitter_exam`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getCommentsForTweet` ()  NO SQL
SELECT comments.*, tweets.tweet_id, tweets.tweet_user_fk, tweets.tweet_message, tweets.tweet_image, users.user_id, users.user_profile_name, users.user_image FROM comments JOIN tweets ON tweets.tweet_id = comments.comment_tweet_fk JOIN users ON users.user_id = comments.comment_user_fk$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTweets` ()  NO SQL
SELECT tweets.tweet_id, tweets.tweet_user_fk, tweets.tweet_total_likes, tweets.tweet_total_comments, tweets.tweet_image, users.user_id, users.user_profile_name, users.user_image FROM tweets JOIN users ON tweets.tweet_user_fk = users.user_id ORDER BY tweets.tweet_id DESC LIMIT 20$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTweetsForLists` ()  NO SQL
SELECT lists.list_id, list_members.*, users.user_id, users.user_profile_name, users.user_image, tweets.tweet_id, tweets.tweet_user_fk, tweets.tweet_message, tweets.tweet_image FROM lists JOIN list_members ON lists.list_id = list_members.list_member_list_fk JOIN users ON users.user_id = list_members.list_member_user_fk JOIN tweets ON tweets.tweet_user_fk = list_members.list_member_user_fk AND list_members.list_member_list_fk$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bios`
--

CREATE TABLE `bios` (
  `bio_id` bigint(20) UNSIGNED NOT NULL,
  `bio_user_fk` bigint(20) UNSIGNED NOT NULL,
  `bio_description` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bios`
--

INSERT INTO `bios` (`bio_id`, `bio_user_fk`, `bio_description`) VALUES
(1, 3, 'I am user 3 and I am testing the database'),
(2, 5, 'I am user 5 and I am testing the database');

-- --------------------------------------------------------

--
-- Table structure for table `birthdates`
--

CREATE TABLE `birthdates` (
  `birthdate_id` bigint(20) UNSIGNED NOT NULL,
  `birthdate_user_fk` bigint(20) UNSIGNED NOT NULL,
  `birthdate_date` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `birthdates`
--

INSERT INTO `birthdates` (`birthdate_id`, `birthdate_user_fk`, `birthdate_date`) VALUES
(1, 1, '15101997'),
(2, 3, '04121992');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` bigint(20) UNSIGNED NOT NULL,
  `chat_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chat_date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`chat_id`, `chat_name`, `chat_date_created`) VALUES
(1, 'bff', '2020-12-16 10:31:11'),
(2, 'friends', '2020-12-16 10:31:11');

-- --------------------------------------------------------

--
-- Table structure for table `chat_users`
--

CREATE TABLE `chat_users` (
  `chat_fk` bigint(20) UNSIGNED NOT NULL,
  `chat_user_fk` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_users`
--

INSERT INTO `chat_users` (`chat_fk`, `chat_user_fk`) VALUES
(1, 1),
(1, 3),
(2, 1),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `comment_user_fk` bigint(20) UNSIGNED NOT NULL,
  `comment_tweet_fk` bigint(20) UNSIGNED NOT NULL,
  `comment_message` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `comment_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_user_fk`, `comment_tweet_fk`, `comment_message`, `comment_date_created`, `comment_active`) VALUES
(1, 1, 4, 'I like your tweet, user 2', '2020-12-16 10:39:32', 1),
(2, 3, 4, 'Thank you, user one', '2020-12-16 10:39:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `country_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`) VALUES
(1, 'Denmark'),
(2, 'Romania');

-- --------------------------------------------------------

--
-- Table structure for table `cover_images`
--

CREATE TABLE `cover_images` (
  `cover_image_id` bigint(20) UNSIGNED NOT NULL,
  `cover_image_user_fk` bigint(20) UNSIGNED NOT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cover_images`
--

INSERT INTO `cover_images` (`cover_image_id`, `cover_image_user_fk`, `cover_image`) VALUES
(1, 1, 'cover_a.jpg'),
(2, 5, 'cover_d.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `follower_user_fk` bigint(20) UNSIGNED NOT NULL,
  `followee_user_fk` bigint(20) UNSIGNED NOT NULL,
  `followee_date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`follower_user_fk`, `followee_user_fk`, `followee_date_created`) VALUES
(1, 3, '2020-12-16 10:11:17'),
(3, 1, '2020-12-16 10:21:10'),
(3, 5, '2020-12-16 10:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `hashtags`
--

CREATE TABLE `hashtags` (
  `hashtag_id` bigint(20) UNSIGNED NOT NULL,
  `hashtag_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashtag_used` mediumint(8) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hashtags`
--

INSERT INTO `hashtags` (`hashtag_id`, `hashtag_name`, `hashtag_used`) VALUES
(1, 'YES', 2),
(2, 'NO', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hashtags_tweets`
--

CREATE TABLE `hashtags_tweets` (
  `hasgtag_fk` bigint(20) UNSIGNED NOT NULL,
  `hashtag_tweet_fk` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hashtags_tweets`
--

INSERT INTO `hashtags_tweets` (`hasgtag_fk`, `hashtag_tweet_fk`) VALUES
(1, 4),
(1, 5),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `list_id` bigint(20) UNSIGNED NOT NULL,
  `list_user_fk` bigint(20) UNSIGNED NOT NULL,
  `list_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `list_private` tinyint(1) NOT NULL DEFAULT 0,
  `list_total_members` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `list_total_followers` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `list_date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`list_id`, `list_user_fk`, `list_name`, `list_private`, `list_total_members`, `list_total_followers`, `list_date_created`) VALUES
(1, 1, 'Mylist for user 1', 0, 0, 0, '2020-12-16 10:54:42'),
(2, 5, 'News list', 0, 0, 0, '2020-12-16 10:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `lists_descriptions`
--

CREATE TABLE `lists_descriptions` (
  `list_description_id` bigint(20) UNSIGNED NOT NULL,
  `list_description_list_fk` bigint(20) UNSIGNED NOT NULL,
  `list_description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lists_descriptions`
--

INSERT INTO `lists_descriptions` (`list_description_id`, `list_description_list_fk`, `list_description`) VALUES
(1, 1, 'This is my list and I am user 1'),
(2, 2, 'This is my list and I am user 2');

-- --------------------------------------------------------

--
-- Table structure for table `lists_followers`
--

CREATE TABLE `lists_followers` (
  `list_following_user_fk` bigint(20) UNSIGNED NOT NULL,
  `list_followed_fk` bigint(20) UNSIGNED NOT NULL,
  `list_follow_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lists_followers`
--

INSERT INTO `lists_followers` (`list_following_user_fk`, `list_followed_fk`, `list_follow_created`) VALUES
(3, 2, '2020-12-16 11:02:47'),
(5, 1, '2020-12-16 11:02:47');

-- --------------------------------------------------------

--
-- Table structure for table `lists_images`
--

CREATE TABLE `lists_images` (
  `list_image_id` bigint(20) UNSIGNED NOT NULL,
  `list_image_list_fk` bigint(20) UNSIGNED NOT NULL,
  `list_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lists_images`
--

INSERT INTO `lists_images` (`list_image_id`, `list_image_list_fk`, `list_image`) VALUES
(1, 1, 'list1.jpg'),
(2, 2, 'list2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `list_members`
--

CREATE TABLE `list_members` (
  `list_member_user_fk` bigint(20) UNSIGNED NOT NULL,
  `list_member_list_fk` bigint(20) UNSIGNED NOT NULL,
  `list_member_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `list_members`
--

INSERT INTO `list_members` (`list_member_user_fk`, `list_member_list_fk`, `list_member_created`) VALUES
(1, 2, '2020-12-16 11:01:11'),
(3, 1, '2020-12-16 11:00:53'),
(4, 1, '2020-12-16 11:00:53'),
(5, 2, '2020-12-16 11:01:11');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `message_user_fk` bigint(20) UNSIGNED NOT NULL,
  `message_chat_fk` bigint(20) UNSIGNED NOT NULL,
  `message_text` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `message_user_fk`, `message_chat_fk`, `message_text`) VALUES
(1, 1, 1, 'Hello from a'),
(2, 3, 1, 'hello from b'),
(3, 4, 2, 'hello from c in chat friends');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `notification_user_fk` bigint(20) UNSIGNED NOT NULL,
  `notification_owner_fk` bigint(20) UNSIGNED NOT NULL,
  `notification_message` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `notification_user_fk`, `notification_owner_fk`, `notification_message`, `notification_date_created`) VALUES
(1, 1, 3, 'Your tweet has been liked', '2020-12-16 11:11:37'),
(2, 4, 5, 'Your tweet has been liked', '2020-12-16 11:11:37');

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE `tweets` (
  `tweet_id` bigint(20) UNSIGNED NOT NULL,
  `tweet_user_fk` bigint(20) UNSIGNED NOT NULL,
  `tweet_message` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tweet_date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `tweet_active` tinyint(1) NOT NULL DEFAULT 1,
  `tweet_total_likes` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `tweet_total_comments` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `tweet_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tweets`
--

INSERT INTO `tweets` (`tweet_id`, `tweet_user_fk`, `tweet_message`, `tweet_date_created`, `tweet_active`, `tweet_total_likes`, `tweet_total_comments`, `tweet_image`) VALUES
(1, 1, 'hi from a', '2020-12-16 01:54:00', 1, 3, 0, '15fc0edbc3a3c7.png'),
(2, 1, 'hi from a again', '2020-12-16 01:54:26', 1, 1, 0, '15fb669afc77eb.png'),
(4, 3, 'hi from b', '2020-12-16 10:05:56', 1, 1, 2, '15fc0edbb2b678.png'),
(5, 5, 'hi from d', '2020-12-16 10:05:56', 1, 0, 0, '15fc0e8a0833a7.png'),
(6, 4, 'Hi from c again', '2020-12-16 10:06:13', 1, 0, 0, '15fc0f13d84acd.png'),
(7, 8, 'hi', '2020-12-18 06:30:05', 1, 0, 0, '15fca109e398ad.png'),
(8, 10, 'test', '2020-12-18 06:30:45', 1, 1, 0, '15fca109e398ad.png'),
(9, 10, 'update test', '2020-12-18 06:33:16', 1, 1, 0, '15fca109e398ad.png'),
(11, 1, 'test', '2020-12-18 07:26:47', 1, 0, 0, '15fc0eee496c6e.png'),
(12, 3, '', '2020-12-18 07:26:47', 1, 0, 0, '15fc0eef42540f.png');

-- --------------------------------------------------------

--
-- Table structure for table `tweets_likes`
--

CREATE TABLE `tweets_likes` (
  `like_tweet_fk` bigint(20) UNSIGNED NOT NULL,
  `like_user_fk` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tweets_likes`
--

INSERT INTO `tweets_likes` (`like_tweet_fk`, `like_user_fk`) VALUES
(1, 3),
(1, 4),
(2, 4),
(4, 1),
(8, 1),
(8, 8),
(8, 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_last_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_profile_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_confirm_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `user_date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `user_active` tinyint(1) NOT NULL DEFAULT 0,
  `user_verification_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_total_tweets` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `user_total_followers` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `user_total_following` mediumint(8) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_last_name`, `user_profile_name`, `user_email`, `user_password`, `user_confirm_password`, `user_phone`, `user_image`, `user_date_created`, `user_active`, `user_verification_code`, `user_total_tweets`, `user_total_followers`, `user_total_following`) VALUES
(1, 'a', 'aa', 'a aa', 'a@a.com', '123456', '123456', '545454', '15fb3a0f822945.png', '2020-12-16 01:49:30', 0, 'fdvfgf54t4r5t', 2, 1, 1),
(3, 'b', 'bb', 'b bb', 'b@b.com', '4423d', '4423d', '', '15fb3a2eb07704.png', '2020-12-16 02:09:50', 0, 'vdfgfb5656y', 1, 2, 1),
(4, 'c', 'cc', 'c cc', 'c@c.com', '12345', '12345', '565678', '15fb3a31c4639f.png', '2020-12-16 10:03:32', 0, 'gfgfgf54545', 1, 0, 0),
(5, 'd', 'dd', 'd dd', 'd@d.com', '345678', '345678', '9998887', '15fbccafd4d8b1.png', '2020-12-16 10:03:32', 0, 'jhjhj6565', 1, 0, 1),
(7, 'stefania', 'olteanu', 'stefania o', 'stefania@gmail.com', '$2y$10$VyHwWIRtuulc3XVf/KfvDuJ0KOcbRxaVXhq6vzZ27e.oOkuRPml82', '$2y$10$DEd1.UDL/25zrxQKfehSH.piVbJNtWNM8y43IcRawL6e3Bev1Tu6e', '11111111', '15fbe1d5cdbff5.png', '2020-12-18 04:57:19', 1, '6abd0e80-f794-47f7-8688-377a390310d9', 0, 0, 0),
(8, 'ana', 'crina', 'anacrina', 'ana@gmail.com', '$2y$10$bKNX3CpL05F9RQOSSMnwruDlnj1iwjXdiDOSlslsFMsVi3SaRI2UC', '$2y$10$pwtgRoCvuRDHZ.ORWkQjnevMidd6HaLkTvhoA6uHnWNg02NceDu2m', '22222222', '15fbe4b873b425.png', '2020-12-18 05:07:11', 1, 'b0143afc-cda7-4331-94b5-ee6bafcbb54a', 0, 0, 0),
(9, 'test', 'test', 'testtest', 'test@gmail.com', '$2y$10$ezljvTnPQkM5x/DhV3A/luFNHgspEZFqC1Uw5IvHllF6gLtwHze6y', '$2y$10$4fj0JJh7sizue5Fv94gVYeDRo6hG5wPPgd76elS/j20oKhnBnNYtK', '33333333', '15fbcc19c31af0.png', '2020-12-18 05:15:40', 0, '069e9062-1144-401d-b88a-f73ee3d7141c', 0, 0, 0),
(10, 'username', 'userlastname', 'userprofile', 'user@gmail.com', '$2y$10$JWJRs7vtVv6wDPGKFcNB/eVRoVUdQNn2uLu9DDoiH1s7T8hwIlTWu', '$2y$10$wXxtVc7pWdT5uH/GGvuCKOQh3.mLUZhsGACtiaxlOxXxXO1PZg.6i', '44444444', '15fbccff5cdba9.png', '2020-12-18 05:17:25', 1, '25e8260f-e44d-4074-b598-1f8f26ae617a', 0, 0, 0),
(11, 'username1', 'userlastname1', 'userprofile1', 'user1@gmail.com', '$2y$10$zvrIg8o3MBQOD58UP05S8eGETgrTum4HMBa8eRp86DREcPKXPz3GC', '$2y$10$DfA/bNKy9C5dJcLC7mfkZetzPYXJ0Rx6irghNRyggMKsG1gGKb1YO', '55555555', '15fbe4a4456d0c.png', '2020-12-18 05:19:22', 1, '0205555f-9381-433b-8c3a-fd8dca56a21e', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_countries`
--

CREATE TABLE `users_countries` (
  `country_user_fk` bigint(20) UNSIGNED NOT NULL,
  `country_fk` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_countries`
--

INSERT INTO `users_countries` (`country_user_fk`, `country_fk`) VALUES
(1, 1),
(3, 2),
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `websites`
--

CREATE TABLE `websites` (
  `website_id` bigint(20) UNSIGNED NOT NULL,
  `website_user_fk` bigint(20) UNSIGNED NOT NULL,
  `website_link` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `websites`
--

INSERT INTO `websites` (`website_id`, `website_user_fk`, `website_link`) VALUES
(1, 1, 'https://mysite.com'),
(2, 4, 'https://myportfolio.dk');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bios`
--
ALTER TABLE `bios`
  ADD PRIMARY KEY (`bio_id`),
  ADD UNIQUE KEY `bio_id` (`bio_id`),
  ADD KEY `delete_user_fk_bios` (`bio_user_fk`);

--
-- Indexes for table `birthdates`
--
ALTER TABLE `birthdates`
  ADD PRIMARY KEY (`birthdate_id`),
  ADD UNIQUE KEY `birthdate_id` (`birthdate_id`),
  ADD KEY `delete_user_fk_birthdates` (`birthdate_user_fk`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`),
  ADD UNIQUE KEY `chat_id` (`chat_id`);

--
-- Indexes for table `chat_users`
--
ALTER TABLE `chat_users`
  ADD PRIMARY KEY (`chat_fk`,`chat_user_fk`),
  ADD KEY `delete_user_fk_chats` (`chat_user_fk`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD UNIQUE KEY `comment_id` (`comment_id`),
  ADD KEY `delete_user_fk_comments` (`comment_user_fk`),
  ADD KEY `delete_tweet_fk_comments` (`comment_tweet_fk`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`),
  ADD UNIQUE KEY `country_id` (`country_id`);

--
-- Indexes for table `cover_images`
--
ALTER TABLE `cover_images`
  ADD PRIMARY KEY (`cover_image_id`),
  ADD UNIQUE KEY `cover_image_id` (`cover_image_id`),
  ADD KEY `delete_user_fk_cover_images` (`cover_image_user_fk`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`follower_user_fk`,`followee_user_fk`),
  ADD KEY `delete_user_fk_followee` (`followee_user_fk`);

--
-- Indexes for table `hashtags`
--
ALTER TABLE `hashtags`
  ADD PRIMARY KEY (`hashtag_id`),
  ADD UNIQUE KEY `hashtag_name_3` (`hashtag_name`),
  ADD UNIQUE KEY `hashtag_id` (`hashtag_id`),
  ADD KEY `hashtag_name` (`hashtag_name`);
ALTER TABLE `hashtags` ADD FULLTEXT KEY `hashtag_name_2` (`hashtag_name`);

--
-- Indexes for table `hashtags_tweets`
--
ALTER TABLE `hashtags_tweets`
  ADD PRIMARY KEY (`hasgtag_fk`,`hashtag_tweet_fk`),
  ADD KEY `delete_hashtag_fk_hashtags` (`hashtag_tweet_fk`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`list_id`),
  ADD UNIQUE KEY `list_id` (`list_id`),
  ADD KEY `delete_user_fk_lists` (`list_user_fk`);

--
-- Indexes for table `lists_descriptions`
--
ALTER TABLE `lists_descriptions`
  ADD PRIMARY KEY (`list_description_id`),
  ADD UNIQUE KEY `list_description_id` (`list_description_id`),
  ADD KEY `delete_list_fk_lists_descriptions` (`list_description_list_fk`);

--
-- Indexes for table `lists_followers`
--
ALTER TABLE `lists_followers`
  ADD PRIMARY KEY (`list_following_user_fk`,`list_followed_fk`),
  ADD KEY `delete_list_fk_list_followers` (`list_followed_fk`);

--
-- Indexes for table `lists_images`
--
ALTER TABLE `lists_images`
  ADD PRIMARY KEY (`list_image_id`),
  ADD UNIQUE KEY `list_image_id` (`list_image_id`),
  ADD KEY `delete_list_fk_lists_images` (`list_image_list_fk`);

--
-- Indexes for table `list_members`
--
ALTER TABLE `list_members`
  ADD PRIMARY KEY (`list_member_user_fk`,`list_member_list_fk`),
  ADD KEY `delete_user_list_members` (`list_member_list_fk`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD UNIQUE KEY `message_id` (`message_id`),
  ADD KEY `delete_user_fk_messages` (`message_user_fk`),
  ADD KEY `delete_chat_fk_messages` (`message_chat_fk`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD UNIQUE KEY `notification_id` (`notification_id`),
  ADD KEY `delete_user_fk_notifications` (`notification_user_fk`),
  ADD KEY `delete_user_owner_fk_notifications` (`notification_owner_fk`);

--
-- Indexes for table `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`tweet_id`),
  ADD UNIQUE KEY `tweet_id` (`tweet_id`),
  ADD KEY `delete_user_fk` (`tweet_user_fk`);

--
-- Indexes for table `tweets_likes`
--
ALTER TABLE `tweets_likes`
  ADD PRIMARY KEY (`like_tweet_fk`,`like_user_fk`),
  ADD KEY `delete_user_fk_likes` (`like_user_fk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `user_profile_name` (`user_profile_name`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_phone` (`user_phone`),
  ADD KEY `user_profile_name_2` (`user_profile_name`),
  ADD KEY `user_email_2` (`user_email`),
  ADD KEY `user_phone_2` (`user_phone`);
ALTER TABLE `users` ADD FULLTEXT KEY `user_profile_name_3` (`user_profile_name`);

--
-- Indexes for table `users_countries`
--
ALTER TABLE `users_countries`
  ADD PRIMARY KEY (`country_user_fk`,`country_fk`),
  ADD KEY `delete_country_fk_user_countries` (`country_fk`);

--
-- Indexes for table `websites`
--
ALTER TABLE `websites`
  ADD PRIMARY KEY (`website_id`),
  ADD UNIQUE KEY `website_id` (`website_id`),
  ADD KEY `delete_user_fk_websites` (`website_user_fk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bios`
--
ALTER TABLE `bios`
  MODIFY `bio_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `birthdates`
--
ALTER TABLE `birthdates`
  MODIFY `birthdate_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cover_images`
--
ALTER TABLE `cover_images`
  MODIFY `cover_image_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hashtags`
--
ALTER TABLE `hashtags`
  MODIFY `hashtag_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `list_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lists_descriptions`
--
ALTER TABLE `lists_descriptions`
  MODIFY `list_description_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lists_images`
--
ALTER TABLE `lists_images`
  MODIFY `list_image_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `tweet_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `websites`
--
ALTER TABLE `websites`
  MODIFY `website_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bios`
--
ALTER TABLE `bios`
  ADD CONSTRAINT `delete_user_fk_bios` FOREIGN KEY (`bio_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `birthdates`
--
ALTER TABLE `birthdates`
  ADD CONSTRAINT `delete_user_fk_birthdates` FOREIGN KEY (`birthdate_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `chat_users`
--
ALTER TABLE `chat_users`
  ADD CONSTRAINT `delete_chat_fk_chats` FOREIGN KEY (`chat_fk`) REFERENCES `chats` (`chat_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `delete_user_fk_chats` FOREIGN KEY (`chat_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `delete_tweet_fk_comments` FOREIGN KEY (`comment_tweet_fk`) REFERENCES `tweets` (`tweet_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `delete_user_fk_comments` FOREIGN KEY (`comment_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `cover_images`
--
ALTER TABLE `cover_images`
  ADD CONSTRAINT `delete_user_fk_cover_images` FOREIGN KEY (`cover_image_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `delete_user_fk_followee` FOREIGN KEY (`followee_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `delete_user_fk_follower` FOREIGN KEY (`follower_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `hashtags_tweets`
--
ALTER TABLE `hashtags_tweets`
  ADD CONSTRAINT `delete_hashtag_fk_hashtags` FOREIGN KEY (`hasgtag_fk`) REFERENCES `hashtags` (`hashtag_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `delete_tweet_fk_hashtags` FOREIGN KEY (`hashtag_tweet_fk`) REFERENCES `tweets` (`tweet_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `lists`
--
ALTER TABLE `lists`
  ADD CONSTRAINT `delete_user_fk_lists` FOREIGN KEY (`list_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `lists_descriptions`
--
ALTER TABLE `lists_descriptions`
  ADD CONSTRAINT `delete_list_fk_lists_descriptions` FOREIGN KEY (`list_description_list_fk`) REFERENCES `lists` (`list_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `lists_followers`
--
ALTER TABLE `lists_followers`
  ADD CONSTRAINT `delete_list_fk_list_followers` FOREIGN KEY (`list_followed_fk`) REFERENCES `lists` (`list_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `delete_user_fk_list_followers` FOREIGN KEY (`list_following_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `lists_images`
--
ALTER TABLE `lists_images`
  ADD CONSTRAINT `delete_list_fk_lists_images` FOREIGN KEY (`list_image_list_fk`) REFERENCES `lists` (`list_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `list_members`
--
ALTER TABLE `list_members`
  ADD CONSTRAINT `delete_user_fk_members` FOREIGN KEY (`list_member_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `delete_user_list_members` FOREIGN KEY (`list_member_list_fk`) REFERENCES `lists` (`list_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `delete_chat_fk_messages` FOREIGN KEY (`message_chat_fk`) REFERENCES `chats` (`chat_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `delete_user_fk_messages` FOREIGN KEY (`message_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `delete_user_fk_notifications` FOREIGN KEY (`notification_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `delete_user_owner_fk_notifications` FOREIGN KEY (`notification_owner_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tweets`
--
ALTER TABLE `tweets`
  ADD CONSTRAINT `delete_user_fk` FOREIGN KEY (`tweet_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tweets_likes`
--
ALTER TABLE `tweets_likes`
  ADD CONSTRAINT `delete_tweet_fk_likes` FOREIGN KEY (`like_tweet_fk`) REFERENCES `tweets` (`tweet_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `delete_user_fk_likes` FOREIGN KEY (`like_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users_countries`
--
ALTER TABLE `users_countries`
  ADD CONSTRAINT `delete_country_fk_user_countries` FOREIGN KEY (`country_fk`) REFERENCES `countries` (`country_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `delete_user_fk_user_countries` FOREIGN KEY (`country_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `websites`
--
ALTER TABLE `websites`
  ADD CONSTRAINT `delete_user_fk_websites` FOREIGN KEY (`website_user_fk`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
