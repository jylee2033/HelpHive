DROP DATABASE `group38`;
CREATE DATABASE `group38`;
USE `group38`;

/*--------------------------------------------*//*--------------------------------------------*/
/*--------------------------------------------*//*--------------------------------------------*/

CREATE TABLE skills
(
	`id` int NOT NULL PRIMARY KEY,
    `skill` varchar(30) NOT NULL
);

CREATE TABLE users
(
    `id` int NOT NULL PRIMARY KEY,
    `name` varchar(50) NOT NULL,
    `email` varchar(50) NOT NULL,
    `username` varchar(30) NOT NULL,
    `password` varchar(30) NOT NULL,
    `skill_1` int,
    `skill_2` int, 
    `skill_3` int,
    FOREIGN KEY (`skill_1`) REFERENCES skills(`id`),
    FOREIGN KEY (`skill_2`) REFERENCES skills(`id`),
    FOREIGN KEY (`skill_3`) REFERENCES skills(`id`)
);

CREATE TABLE categories 
(
    `id` int NOT NULL PRIMARY KEY,
    `name` varchar(50) NOT NULL
);

CREATE TABLE gigs
(
    `id` int NOT NULL PRIMARY KEY auto_increment,
    `title` varchar(80) NOT NULL,
    `description` varchar(500) NOT NULL,
    `category_id` int NOT NULL,
    `price` float NOT NULL,
    `user_id` int NOT NULL,
    FOREIGN KEY (`category_id`) REFERENCES categories(id),
    FOREIGN KEY (`user_id`) REFERENCES users(id)
);

CREATE TABLE order_status
(
    `id` int NOT NULL PRIMARY KEY,
    `description` varchar(50) NOT NULL
);

CREATE TABLE orders
(
    `id` int NOT NULL PRIMARY KEY,
    `requirements` varchar(500),
    `buyer` int NOT NULL,
    `gig` int NOT NULL,
    `status` int NOT NULL,
    FOREIGN KEY (`buyer`) REFERENCES users(`id`),
    FOREIGN KEY  (`gig`) REFERENCES gigs(`id`) ON DELETE cascade,
    FOREIGN KEY  (`status`) REFERENCES order_status(`id`)
);

CREATE TABLE place
(
    `id` int NOT NULL PRIMARY KEY,
    `name` varchar(15)
);

/*--------------------------------------------*//*--------------------------------------------*/
/*--------------------------------------------*//*--------------------------------------------*/

INSERT INTO skills
VALUES 
(1, 'Cooking'),
(2, 'Interior Design'),
(3, 'Host MC'),
(4, 'Counselling'),
(5, 'Translating')
;

INSERT INTO users
VALUES
(1, 'Peter Lee'    , 'peter123@gmail.com', 'peter354', '354', 1, 2, NULL),
(2, 'Hanra Jeong'  , 'hanra123@gmail.com', 'hanra354', '354', 2, 5, NULL),
(3, 'Julia Lee'    , 'julia123@gmail.com', 'julia354', '354', 1, 2, NULL),
(4, 'JangHyeon Lee', 'jang123@gmail.com' , 'jang354' , '354', 3, 5, NULL),
(5, 'Jooyoung Lee' , 'joo123@gmail.com'  , 'joo354'  , '354', 3, 4, 5),
(6, 'I am a newbie', 'new123@gmail.com'  , 'new354'  , '354', NULL, NULL, NULL)
;

INSERT INTO categories 
VALUES 
(1, 'Lesson'),
(2, 'Home'),
(3, 'Event'),
(4, 'Health'),
(5, 'Business')
;

INSERT INTO gigs
VALUES
(1, 'Make any kimchi', 'I will teach you how to make any home-made kimchi.', 1, 30, 1),
(2, 'A good design makes a good house', 'I will create one-and-only blueprint of your dream house.', 2, 1000, 2),
(3, 'The host you needed', 'I will be your host in any language.', 3, 100, 4),
(4, 'Living is mentality', 'I will be your counsellor for your current issues.', 4, 500, 3),
(5, 'Your business starts here', 'In any language, I can create a good business proposal.', 5, 2000, 5),
(6, 'How to be a good cook', 'I will teach you the basics of being a good cook.', 1, 50, 3),
(7, 'Make your garden alive', 'I will design the structures eco-friendly way.', 2, 300, 1),
(8, 'MC for any program', 'The bilingual MC you needed for your program.', 3, 200, 4),
(9, 'The healing therapy', 'Clear your mind away with a chat.', 4, 75, 5),
(10, 'Translate in ENG or KR', 'I can translate your documents in ENG or KR', 5, 100, 2)
;

INSERT INTO order_status 
VALUES
(1, 'In Progress'),
(2, 'Delivered'),
(3, 'In Revision'),
(4, 'Completed'),
(5, 'Cancelled')
;

INSERT INTO orders
VALUES
(1, "I want learn how to make water kimchi", 2, 1, 1),
(2, "Please re-design my basement", 5, 2, 3),
(3, "Host a birthday party in Korean", 2, 3, 1),
(4, "I need counselling in education", 1, 4, 4),
(5, "Construct a start-up proposal for government funding", 3, 5, 4),
(6, "Need a lesson to make based kimchi", 4, 1, 1),
(7, "Need a re-design of my roof", 4, 2, 5),
(8, "Need an MC for a program", 5, 3, 1),
(9, "Need to talk about my personal issues", 1, 4, 1),
(10, "Teach me how to make kimchi", 3, 1, 4),
(11, "Teach me how to make kimchi", 5, 1, 4),
(12, "Please re-design my basement", 3, 2, 3),
(13, "Construct a start-up proposal for government funding", 5, 5, 4),
(14, "Need to talk about my personal issues", 5, 4, 4),
(15, "Need a lesson to be a good book", 5, 6, 4),
(16, "Please re-design my garden", 5, 7, 4),
(17, "Need a MC for a program", 5, 8, 4),
(18, "Need a healing", 5, 9, 4),
(19, "Please translate this doc in ENG", 5, 10, 4)
;

INSERT INTO place
VALUES
(1, "Burnaby"),
(2, "Surrey"),
(3, "Vancouver"),
(4, "Richmond"),
(5, "Abbotsford")
;