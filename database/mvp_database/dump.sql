CREATE DATABASE  IF NOT EXISTS `sentis` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sentis`;
-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (i686)
--
-- Host: 127.0.0.1    Database: sentis
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE feelings
(
  id INT(10) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  icon BLOB NOT NULL,
  `order` INT(11),
  description VARCHAR(500)
);
CREATE INDEX idx_feeling_name ON feelings (name);
CREATE TABLE medias
(
  id INT(11) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  type VARCHAR(45)
);
CREATE TABLE migrations
(
  migration VARCHAR(255) NOT NULL,
  batch INT(11) NOT NULL
);
CREATE TABLE post_contents
(
  post_id INT(10) UNSIGNED PRIMARY KEY NOT NULL,
  main_post_id INT(10) UNSIGNED,
  title VARCHAR(80),
  content VARCHAR(500),
  source_url VARCHAR(250),
  media_id INT(11) UNSIGNED,
  media_url VARCHAR(250),
  CONSTRAINT fk_post_content_main_post FOREIGN KEY (main_post_id) REFERENCES posts (id),
  CONSTRAINT fk_post_content_media FOREIGN KEY (media_id) REFERENCES medias (id),
  CONSTRAINT fk_post_content_post FOREIGN KEY (post_id) REFERENCES posts (id)
);
CREATE INDEX fk_post_content_main_post_idx ON post_contents (main_post_id);
CREATE INDEX fk_post_content_media_idx ON post_contents (media_id);
CREATE INDEX idx_post_content ON post_contents (content);
CREATE INDEX idx_post_title ON post_contents (title);
CREATE TABLE posts
(
  id INT(10) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  user_id INT(10) UNSIGNED NOT NULL,
  privacy_id INT(10) UNSIGNED NOT NULL,
  anonymous INT(11) DEFAULT '0' NOT NULL,
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
  post_geolocation VARCHAR(45),
  user_geolocation VARCHAR(45),
  user_ip_address VARCHAR(45) NOT NULL,
  status INT(11) DEFAULT '1' NOT NULL,
  CONSTRAINT posts_privacy_id_foreign FOREIGN KEY (privacy_id) REFERENCES privacies (id),
  CONSTRAINT posts_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id)
);
CREATE INDEX posts_privacy_id_foreign ON posts (privacy_id);
CREATE INDEX posts_user_id_foreign ON posts (user_id);
CREATE TABLE posts_tags
(
  post_id INT(10) UNSIGNED NOT NULL,
  tag_id INT(10) UNSIGNED NOT NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (post_id, tag_id),
  CONSTRAINT fk_posts_tags_post_id FOREIGN KEY (post_id) REFERENCES posts (id),
  CONSTRAINT fk_posts_tags_tag_id FOREIGN KEY (tag_id) REFERENCES tags (id)
);
CREATE INDEX fk_posts_tags_tag_id ON posts_tags (tag_id);
CREATE TABLE privacies
(
  id INT(10) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL
);
CREATE TABLE roles
(
  id INT(11) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL
);
CREATE TABLE sentis
(
  id INT(10) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  user_id INT(10) UNSIGNED,
  post_id INT(10) UNSIGNED NOT NULL,
  user_ip_address VARCHAR(45) NOT NULL,
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
  CONSTRAINT fk_sentis_post_id FOREIGN KEY (post_id) REFERENCES posts (id),
  CONSTRAINT fk_sentis_user_id FOREIGN KEY (user_id) REFERENCES users (id)
);
CREATE INDEX fk_sentis_post_id ON sentis (post_id);
CREATE INDEX fk_sentis_user_id ON sentis (user_id);
CREATE TABLE sentis_feelings
(
  sentis_id INT(10) UNSIGNED NOT NULL,
  feeling_id INT(10) UNSIGNED NOT NULL,
  value INT(11) NOT NULL,
  CONSTRAINT fk_sentis_feelings_feeling_id FOREIGN KEY (feeling_id) REFERENCES feelings (id),
  CONSTRAINT fk_sentis_feelings_sentis_id FOREIGN KEY (sentis_id) REFERENCES sentis (id)
);
CREATE INDEX fk_sentis_feelings_feeling_id_idx ON sentis_feelings (feeling_id);
CREATE INDEX fk_sentis_feelings_sentis_id_idx ON sentis_feelings (sentis_id);
CREATE TABLE sentis_tags
(
  sentis_id INT(10) UNSIGNED NOT NULL,
  tag_id INT(10) UNSIGNED NOT NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (sentis_id, tag_id),
  CONSTRAINT fk_sentis_tags_sentis_id FOREIGN KEY (sentis_id) REFERENCES sentis (id),
  CONSTRAINT fk_sentis_tags_tag_id FOREIGN KEY (tag_id) REFERENCES tags (id)
);
CREATE INDEX fk_sentis_tags_tag_id ON sentis_tags (tag_id);
CREATE TABLE tags
(
  id INT(11) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  description VARCHAR(200)
);
CREATE INDEX idx_tag_name ON tags (name);
CREATE TABLE users
(
  id INT(10) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  email VARCHAR(50) NOT NULL,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(60) NOT NULL,
  password_temp VARCHAR(60),
  code VARCHAR(60),
  active INT(11) DEFAULT '0' NOT NULL,
  created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
  updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
  remember_token VARCHAR(100),
  avatar_url VARCHAR(500),
  facebook_id VARCHAR(45),
  signed_up_by_form INT(11) DEFAULT '0' NOT NULL
);
CREATE UNIQUE INDEX email_UNIQUE ON users (email);
CREATE INDEX idx_username ON users (username);
CREATE UNIQUE INDEX username_UNIQUE ON users (username);
CREATE TABLE users_roles
(
  user_id INT(11) UNSIGNED NOT NULL,
  role_id INT(11) UNSIGNED NOT NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (user_id, role_id),
  CONSTRAINT fk_users_roles_role_id FOREIGN KEY (role_id) REFERENCES roles (id),
  CONSTRAINT fk_users_roles_user_id FOREIGN KEY (user_id) REFERENCES users (id)
);
CREATE INDEX fk_users_roles_role_id_idx ON users_roles (role_id);
CREATE TABLE topic_keywords
(
  topic_id INT(10) UNSIGNED NOT NULL,
  keyword VARCHAR(100) NOT NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (topic_id, keyword)
);
CREATE TABLE topics
(
  id INT(10) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  content VARCHAR(500) NOT NULL,
  status INT(11) DEFAULT '1' NOT NULL,
  user_id INT(11) UNSIGNED NOT NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  filter_type CHAR(1) DEFAULT 'i' NOT NULL,
  CONSTRAINT fk_topics_user_id FOREIGN KEY (user_id) REFERENCES users (id)
);
CREATE INDEX fk_topics_user_id_idx ON topics (user_id);
CREATE TABLE topics_feelings
(
  topic_id INT(10) UNSIGNED NOT NULL,
  feeling_id INT(10) UNSIGNED NOT NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (topic_id, feeling_id),
  CONSTRAINT fk_topics_feelings_feeling_id FOREIGN KEY (feeling_id) REFERENCES feelings (id),
  CONSTRAINT fk_topics_feelings_topic_id FOREIGN KEY (topic_id) REFERENCES topics (id)
);
CREATE INDEX fk_topics_feelings_feeling_id ON topics_feelings (feeling_id);
CREATE TABLE topics_posts
(
  topic_id INT(10) UNSIGNED NOT NULL,
  post_id INT(10) UNSIGNED NOT NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (topic_id, post_id),
  CONSTRAINT fk_topics_posts_post_id FOREIGN KEY (post_id) REFERENCES posts (id),
  CONSTRAINT fk_topics_posts_topic_id FOREIGN KEY (topic_id) REFERENCES topics (id)
);
CREATE INDEX fk_topics_posts_post_id ON topics_posts (post_id);
CREATE TABLE topics_tags
(
  topic_id INT(10) UNSIGNED NOT NULL,
  tag_id INT(10) UNSIGNED NOT NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (topic_id, tag_id),
  CONSTRAINT fk_topic_tags_tag_id FOREIGN KEY (tag_id) REFERENCES tags (id),
  CONSTRAINT fk_topic_tags_topic_id FOREIGN KEY (topic_id) REFERENCES topics (id)
);
CREATE INDEX fk_topic_tags_tag_id_idx ON topics_tags (tag_id);
CREATE TABLE user_follows
(
  user_id INT(10) UNSIGNED NOT NULL,
  follow_id INT(10) UNSIGNED NOT NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (user_id, follow_id),
  CONSTRAINT fk_user_follows_user_id FOREIGN KEY (user_id) REFERENCES users (id)
);
CREATE TABLE keywords
(
  topic_id INT(11),
  keyword_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  keyword VARCHAR(100) NOT NULL
);
CREATE TABLE channels
(
  id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  status VARCHAR(1) DEFAULT '1' NOT NULL,
  updated_at TIMESTAMP,
  created_at TIMESTAMP,
  name VARCHAR(100)
);
CREATE TABLE channels_topics
(
  topic_id INT(11),
  channel_id INT(11)
);