CREATE TABLE `user` (
  `u_id` int PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(255) UNIQUE NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL,
  `reader_rank` int DEFAULT 0,
  `writter_rank` int DEFAULT 0,
  `followers` int DEFAULT 0,
  `reader_badge` int DEFAULT 1,
  `writter_badge` int DEFAULT 1,
  `status` boolean DEFAULT true
);

CREATE TABLE `badge` (
  `b_id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `minimum_rank` int NOT NULL
);

CREATE TABLE `summery` (
  `s_id` int PRIMARY KEY AUTO_INCREMENT,
  `u_id` int,
  `s_date` date,
  `total_read` int DEFAULT 0,
  `total_write` int DEFAULT 0
);

CREATE TABLE `post` (
  `p_id` int PRIMARY KEY AUTO_INCREMENT,
  `u_id` int,
  `title` varchar(255) NOT NULL,
  `p_text` mediumtext NOT NULL,
  `p_date` date NOT NULL,
  `p_time` time NOT NULL,
  `reward` int DEFAULT 0,
  `upvote` int DEFAULT 0,
  `downvote` int DEFAULT 0,
  `comment` int DEFAULT 0,
  `status` boolean DEFAULT true
);

CREATE TABLE `comment` (
  `c_id` int PRIMARY KEY AUTO_INCREMENT,
  `p_id` int,
  `u_id` int,
  `c_text` varchar(255) NOT NULL,
  `c_date` date NOT NULL,
  `c_time` time NOT NULL,
  `status` boolean DEFAULT true
);

CREATE TABLE `vote` (
  `v_id` int PRIMARY KEY AUTO_INCREMENT,
  `p_id` int,
  `u_id` int,
  `vote` ENUM ('upvote', 'downvote', 'none') NOT NULL
);

CREATE TABLE `follow` (
  `f_id` int PRIMARY KEY AUTO_INCREMENT,
  `follower_id` int,
  `following_id` int,
  `status` boolean DEFAULT true
);

CREATE TABLE `read` (
  `r_id` int PRIMARY KEY AUTO_INCREMENT,
  `p_id` int,
  `u_id` int
);

CREATE TABLE `comment_connect` (
  `c_id` int,
  `n_id` int
);

CREATE TABLE `vote_connect` (
  `v_id` int,
  `n_id` int
);

CREATE TABLE `notification` (
  `n_id` int PRIMARY KEY AUTO_INCREMENT,
  `u_id` int,
  `Enum` ENUM ('vote', 'comment'),
  `seen` boolean DEFAULT false
);

ALTER TABLE `user` ADD FOREIGN KEY (`reader_badge`) REFERENCES `badge` (`b_id`);

ALTER TABLE `user` ADD FOREIGN KEY (`writter_badge`) REFERENCES `badge` (`b_id`);

ALTER TABLE `summery` ADD FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

ALTER TABLE `post` ADD FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

ALTER TABLE `comment` ADD FOREIGN KEY (`p_id`) REFERENCES `post` (`p_id`);

ALTER TABLE `comment` ADD FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

ALTER TABLE `vote` ADD FOREIGN KEY (`p_id`) REFERENCES `post` (`p_id`);

ALTER TABLE `vote` ADD FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

ALTER TABLE `follow` ADD FOREIGN KEY (`follower_id`) REFERENCES `user` (`u_id`);

ALTER TABLE `follow` ADD FOREIGN KEY (`following_id`) REFERENCES `user` (`u_id`);

ALTER TABLE `read` ADD FOREIGN KEY (`p_id`) REFERENCES `post` (`p_id`);

ALTER TABLE `read` ADD FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

ALTER TABLE `comment_connect` ADD FOREIGN KEY (`c_id`) REFERENCES `comment` (`c_id`);

ALTER TABLE `comment_connect` ADD FOREIGN KEY (`n_id`) REFERENCES `notification` (`n_id`);

ALTER TABLE `vote_connect` ADD FOREIGN KEY (`v_id`) REFERENCES `vote` (`v_id`);

ALTER TABLE `vote_connect` ADD FOREIGN KEY (`n_id`) REFERENCES `notification` (`n_id`);

ALTER TABLE `notification` ADD FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

CREATE UNIQUE INDEX `summery_index_0` ON `summery` (`u_id`, `s_date`);

CREATE UNIQUE INDEX `vote_index_1` ON `vote` (`p_id`, `u_id`);

CREATE UNIQUE INDEX `follow_index_2` ON `follow` (`follower_id`, `following_id`);

INSERT INTO `badge` (`name`, `minimum_rank`) VALUES ('recruit',0),('copper',100),('bronze',300),('silver',900),('gold',2000),('platinum',3500),('diamond',5000),('master',7000);
