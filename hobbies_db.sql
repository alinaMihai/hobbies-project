-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 30, 2014 at 12:51 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `actors`
--

CREATE TABLE IF NOT EXISTS `actors` (
  `#A` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `BirthYear` date DEFAULT NULL,
  `Nationality` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`#A`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `#B` int(11) NOT NULL AUTO_INCREMENT,
  `BookName` varchar(255) NOT NULL,
  `BookType` int(11) NOT NULL,
  `Author` varchar(255) DEFAULT NULL,
  `Year` year(4) DEFAULT NULL,
  `CoverPicture` varchar(255) DEFAULT NULL,
  `noPages` int(11) DEFAULT NULL,
  `Description` mediumtext,
  PRIMARY KEY (`#B`),
  UNIQUE KEY `BookName` (`BookName`),
  KEY `fk_BOOKS_BOOK_TYPE1_idx` (`BookType`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`#B`, `BookName`, `BookType`, `Author`, `Year`, `CoverPicture`, `noPages`, `Description`) VALUES
(1, 'A New Earth: Awakening to Your Life''s Purpose', 2, 'Eckhart Tolle', 2005, 'A-New-Earth-Cover.jpg', 336, 'A New Earth: Awakening to Your Life’s Purpose is a self-help book by Eckhart Tolle. First published in 2005, it sold 5 million copies in North America by 2009. In 2008 it was selected for Oprah''s Book Club and featured in a series of 10 weekly webinars with Tolle and Oprah Winfrey'),
(2, 'The Power of Now: A Guide to Spiritual Enlightenment', 1, 'Eckhart Tolle', 1997, 'Power of Now.jpg', 236, 'The book is intended to be a self-help guide for day-to-day living and stresses the importance of living in the present moment and avoiding thoughts of the past or future.'),
(3, 'Stillness Speaks', 1, 'Eckhart Tolle', 2003, 'Stillness_Speaks_Tolle_F.jpg', 144, 'n Stillness Speaks, Eckhart Tolle illuminates the fundamental elements of his teaching,\r\naddressing the needs of the modern seeker by drawing from all spiritual traditions. At the core of the book is what the author calls "the state of presence," a living in the "now" that is both intensely inspirational and practical. '),
(4, 'The Fault in Our Stars', 3, 'John Green', 2012, 'The_Fault_in_Our_Stars.jpg', 313, 'The Fault in Our Stars is the sixth novel by author John Green, published in January 2012. The story is narrated by a sixteen-year-old cancer patient named Hazel Grace Lancaster, who is forced by her parents to attend a support group, where she subsequently meets and falls in love with the seventeen-year-old Augustus Waters, an ex-basketball player and amputee.\r\nThe title is inspired from Act 1, Scene 2 of Shakespeare''s play Julius Caesar, in which the nobleman Cassius says to Brutus: "The fault, dear Brutus, is not in our stars, / But in ourselves, that we are underlings."'),
(15, 'tw1 some long text', 4, NULL, NULL, '5712_200810261502091.jpg', NULL, NULL),
(22, 'k', 4, NULL, NULL, '4e40d5050fdfe.jpg', NULL, NULL),
(30, 'dajlja', 4, NULL, NULL, '5712_200810261502091.jpg', NULL, NULL),
(32, 'a test again', 4, NULL, NULL, 'I breathe, I smile, I simply follow my heart.jpg', NULL, NULL),
(39, 'a test', 4, NULL, NULL, '', NULL, NULL),
(40, 'something to delete', 4, NULL, NULL, '', NULL, NULL),
(41, 'another book to undo', 4, NULL, NULL, '', NULL, NULL),
(42, 'a book to delete test', 4, NULL, NULL, '', NULL, NULL),
(43, 'test', 4, NULL, NULL, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `books_wishlist`
--

CREATE TABLE IF NOT EXISTS `books_wishlist` (
  `#BW` int(11) NOT NULL AUTO_INCREMENT,
  `Book` int(11) NOT NULL,
  `User` int(11) NOT NULL,
  `Priority` int(11) NOT NULL DEFAULT '1',
  `Comment` mediumtext,
  `deleted_book` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`#BW`),
  KEY `fk_BOOKS_WISHLIST_BOOKS1_idx` (`Book`),
  KEY `fk_BOOKS_WISHLIST_USERS1_idx` (`User`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `books_wishlist`
--

INSERT INTO `books_wishlist` (`#BW`, `Book`, `User`, `Priority`, `Comment`, `deleted_book`) VALUES
(5, 32, 7, 3, 'I love this', 1);

-- --------------------------------------------------------

--
-- Table structure for table `book_type`
--

CREATE TABLE IF NOT EXISTS `book_type` (
  `#BT` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(45) NOT NULL,
  PRIMARY KEY (`#BT`),
  UNIQUE KEY `Type_UNIQUE` (`Type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `book_type`
--

INSERT INTO `book_type` (`#BT`, `Type`) VALUES
(2, 'self-help'),
(1, 'spirituality'),
(4, 'uncategorized'),
(3, 'Young adult novel');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `#C` int(11) NOT NULL AUTO_INCREMENT,
  `Content` mediumtext NOT NULL,
  `Rating` int(11) DEFAULT NULL,
  `FilmPostId` int(11) NOT NULL,
  `User` int(11) NOT NULL,
  `BookPostId` int(11) NOT NULL,
  PRIMARY KEY (`#C`),
  KEY `fk_COMMENTS_USERS1_idx` (`User`),
  KEY `fk_COMMENTS_BOOKS1_idx` (`BookPostId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE IF NOT EXISTS `films` (
  `#F` int(11) NOT NULL AUTO_INCREMENT,
  `InfoFilm` int(11) NOT NULL,
  PRIMARY KEY (`#F`),
  UNIQUE KEY `InfoFilm_UNIQUE` (`InfoFilm`),
  KEY `fk_FILMS_FILM_INFO1_idx` (`InfoFilm`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `films`
--

INSERT INTO `films` (`#F`, `InfoFilm`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `film_actors`
--

CREATE TABLE IF NOT EXISTS `film_actors` (
  `#FA` int(11) NOT NULL AUTO_INCREMENT,
  `Actor` int(11) NOT NULL,
  `Film` int(11) NOT NULL,
  PRIMARY KEY (`#FA`),
  UNIQUE KEY `Film_Actor` (`Actor`,`Film`),
  KEY `fk_FILM_ACTORS_FILMS1_idx` (`Film`),
  KEY `fk_FILM_ACTORS_ACTORS1_idx` (`Actor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `film_info`
--

CREATE TABLE IF NOT EXISTS `film_info` (
  `#FI` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `FilmType` int(11) NOT NULL,
  `TrailerURL` varchar(255) NOT NULL,
  PRIMARY KEY (`#FI`),
  KEY `fk_FILM_INFO_FILM_TYPE1_idx` (`FilmType`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `film_info`
--

INSERT INTO `film_info` (`#FI`, `Name`, `FilmType`, `TrailerURL`) VALUES
(1, 'Rurouni Kenshin ', 1, 'https://www.youtube.com/watch?v=bubPqc3I8xM'),
(2, 'How to train your dragon 2', 2, 'https://www.youtube.com/results?search_query=how+to+train+your+dragon+2+trailer'),
(3, 'Hunters', 1, 'https://www.youtube.com/watch?v=nDd_I481ShA');

-- --------------------------------------------------------

--
-- Table structure for table `film_info_directors`
--

CREATE TABLE IF NOT EXISTS `film_info_directors` (
  `#FID` int(11) NOT NULL AUTO_INCREMENT,
  `FilmInfo` int(11) NOT NULL,
  `DirectorName` varchar(255) NOT NULL,
  PRIMARY KEY (`#FID`),
  UNIQUE KEY `Film_Director` (`DirectorName`),
  KEY `fk_FILM_INFO_DIRECTORS_FILM_INFO1_idx` (`FilmInfo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `film_lines`
--

CREATE TABLE IF NOT EXISTS `film_lines` (
  `#FL` int(11) NOT NULL AUTO_INCREMENT,
  `Character` varchar(45) NOT NULL,
  `Actor` varchar(45) NOT NULL,
  `Minut` varchar(45) NOT NULL,
  `Content` longtext NOT NULL,
  PRIMARY KEY (`#FL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `film_type`
--

CREATE TABLE IF NOT EXISTS `film_type` (
  `#FT` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(45) NOT NULL,
  PRIMARY KEY (`#FT`),
  UNIQUE KEY `Type_UNIQUE` (`Type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `film_type`
--

INSERT INTO `film_type` (`#FT`, `Type`) VALUES
(2, 'animatie'),
(1, 'anime');

-- --------------------------------------------------------

--
-- Table structure for table `film_wishlist`
--

CREATE TABLE IF NOT EXISTS `film_wishlist` (
  `#FW` int(11) NOT NULL AUTO_INCREMENT,
  `User` int(11) NOT NULL,
  `Film` int(11) NOT NULL,
  `Priority` int(11) DEFAULT NULL,
  `Comments` mediumtext,
  `Image` varchar(50) NOT NULL,
  PRIMARY KEY (`#FW`),
  UNIQUE KEY `User_Film` (`User`,`Film`),
  KEY `fk_FILM_WISHLIST_USERS1_idx` (`User`),
  KEY `fk_FILM_WISHLIST_FILMS1_idx` (`Film`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `#I` int(11) NOT NULL AUTO_INCREMENT,
  `Link` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`#I`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`#I`, `Link`) VALUES
(1, 'A-New-Earth-Cover.jpg'),
(2, 'how_to_train_your_dragon_2.jpg'),
(3, 'kenshin.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `personal_notes`
--

CREATE TABLE IF NOT EXISTS `personal_notes` (
  `#PN` int(11) NOT NULL AUTO_INCREMENT,
  `OnPage` int(11) NOT NULL,
  `Content` longtext NOT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`#PN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions-film-types`
--

CREATE TABLE IF NOT EXISTS `questions-film-types` (
  `#QFT` int(11) NOT NULL AUTO_INCREMENT,
  `Question` varchar(255) NOT NULL,
  `FilmType` int(11) NOT NULL,
  PRIMARY KEY (`#QFT`),
  KEY `fk_QUESTIONS-FILM-TYPES_FILM_TYPE1_idx` (`FilmType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions_book_type`
--

CREATE TABLE IF NOT EXISTS `questions_book_type` (
  `#QBT` int(11) NOT NULL AUTO_INCREMENT,
  `Question` varchar(255) NOT NULL,
  `BookType` int(11) NOT NULL,
  `Topic` varchar(255) NOT NULL,
  PRIMARY KEY (`#QBT`,`Question`),
  KEY `fk_QUESTIONS_BOOK_TYPE_BOOK_TYPE1_idx` (`BookType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE IF NOT EXISTS `quotes` (
  `#Q` int(11) NOT NULL AUTO_INCREMENT,
  `Page` int(11) NOT NULL,
  `Content` longtext NOT NULL,
  `Character` varchar(255) NOT NULL,
  PRIMARY KEY (`#Q`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
  `#S` int(11) NOT NULL,
  `SongName` varchar(255) NOT NULL,
  `Link` varchar(255) DEFAULT NULL,
  `Singer_Band` varchar(45) NOT NULL,
  `Year` date DEFAULT NULL,
  `Album` varchar(255) DEFAULT NULL,
  `SongType` int(11) NOT NULL,
  PRIMARY KEY (`#S`),
  UNIQUE KEY `fk_SONGS_SONG_TYPE1_idx` (`SongType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `song_type`
--

CREATE TABLE IF NOT EXISTS `song_type` (
  `#ST` int(11) NOT NULL AUTO_INCREMENT,
  `SongType` varchar(45) NOT NULL,
  PRIMARY KEY (`#ST`),
  UNIQUE KEY `SongType_UNIQUE` (`SongType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `#U` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `User_Info` int(11) DEFAULT NULL,
  PRIMARY KEY (`#U`),
  UNIQUE KEY `Username_UNIQUE` (`Username`),
  KEY `fk_USERS_USER_INFO1_idx` (`User_Info`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`#U`, `Username`, `Password`, `User_Info`) VALUES
(7, 'alina', '$2y$10$Nzg0YmFhM2M5YjlmYWMxNOghfl/k3nX4x5JPCcVJ534YQJ4DrOXPm', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_books`
--

CREATE TABLE IF NOT EXISTS `users_books` (
  `#UB` int(11) NOT NULL AUTO_INCREMENT,
  `Book` int(11) NOT NULL,
  `User` int(11) NOT NULL,
  `Review` mediumtext,
  `Read` tinyint(1) DEFAULT NULL,
  `Rating` int(1) DEFAULT NULL,
  `URL` varchar(255) DEFAULT NULL,
  `ReadingNow` tinyint(1) DEFAULT NULL,
  `deleted_book` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`#UB`),
  UNIQUE KEY `User_Book` (`Book`,`User`),
  UNIQUE KEY `URL_UNIQUE` (`URL`),
  KEY `fk_USERS_BOOKS_BOOKS1_idx` (`Book`),
  KEY `fk_USERS_BOOKS_USERS1_idx` (`User`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users_books`
--

INSERT INTO `users_books` (`#UB`, `Book`, `User`, `Review`, `Read`, `Rating`, `URL`, `ReadingNow`, `deleted_book`) VALUES
(1, 1, 7, 'It was a really inspiring book', 1, 5, 'A New Earth.pdf', NULL, 0),
(3, 2, 7, 'A really good book.The book is intended to be a self-help guide for day-to-day living and stresses the importance of living in the present moment and avoiding thoughts of the past or future.', 1, 5, 'Practicing the Power of Now.pdf', NULL, 0),
(4, 3, 7, 'A very good book', 1, 4, 'Stillness Speaks.pdf', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_books_images`
--

CREATE TABLE IF NOT EXISTS `users_books_images` (
  `#UI` int(11) NOT NULL AUTO_INCREMENT,
  `Image` int(11) NOT NULL,
  `UserBook` int(11) NOT NULL,
  PRIMARY KEY (`#UI`),
  UNIQUE KEY `UB_Image` (`Image`,`UserBook`),
  KEY `fk_USERS_BOOKS_IMAGES_IMAGES1_idx` (`Image`),
  KEY `fk_USERS_BOOKS_IMAGES_USERS_BOOKS1_idx` (`UserBook`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_books_personal_notes`
--

CREATE TABLE IF NOT EXISTS `users_books_personal_notes` (
  `#UBPN` int(11) NOT NULL AUTO_INCREMENT,
  `UserBook` int(11) NOT NULL,
  `PersonalNote` int(11) NOT NULL,
  PRIMARY KEY (`#UBPN`),
  UNIQUE KEY `UB_PN` (`UserBook`,`PersonalNote`),
  KEY `fk_USERS_BOOKS_PERSONAL_NOTES_USERS_BOOKS1_idx` (`UserBook`),
  KEY `fk_USERS_BOOKS_PERSONAL_NOTES_PERSONAL_NOTES1_idx` (`PersonalNote`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_books_questions_bt`
--

CREATE TABLE IF NOT EXISTS `users_books_questions_bt` (
  `#UBQBT` int(11) NOT NULL AUTO_INCREMENT,
  `Answer` mediumtext NOT NULL,
  `UserBook` int(11) NOT NULL,
  `QuestionBT` int(11) NOT NULL,
  PRIMARY KEY (`#UBQBT`),
  UNIQUE KEY `QBT_UB` (`UserBook`,`QuestionBT`),
  KEY `fk_USERS_BOOKS_QUESTIONS_BT_USERS_BOOKS1_idx` (`UserBook`),
  KEY `fk_USERS_BOOKS_QUESTIONS_BT_QUESTIONS_BOOK_TYPE1_idx` (`QuestionBT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_books_quotes`
--

CREATE TABLE IF NOT EXISTS `users_books_quotes` (
  `#UQ` int(11) NOT NULL AUTO_INCREMENT,
  `Quote` int(11) NOT NULL,
  `UserBook` int(11) NOT NULL,
  PRIMARY KEY (`#UQ`),
  UNIQUE KEY `UB_Quote` (`Quote`,`UserBook`),
  KEY `fk_USERS_BOOKS_QUOTES_QUOTES1_idx` (`Quote`),
  KEY `fk_USERS_BOOKS_QUOTES_USERS_BOOKS1_idx` (`UserBook`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_books_songs`
--

CREATE TABLE IF NOT EXISTS `users_books_songs` (
  `#UBS` int(11) NOT NULL AUTO_INCREMENT,
  `UserBook` int(11) NOT NULL,
  `Song` int(11) NOT NULL,
  PRIMARY KEY (`#UBS`),
  UNIQUE KEY `UB_Song` (`Song`,`UserBook`),
  KEY `fk_USERS_BOOKS_SONGS_USERS_BOOKS1_idx` (`UserBook`),
  KEY `fk_USERS_BOOKS_SONGS_SONGS1_idx` (`Song`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_films`
--

CREATE TABLE IF NOT EXISTS `users_films` (
  `#UF` int(11) NOT NULL AUTO_INCREMENT,
  `User` int(11) NOT NULL,
  `Film` int(11) NOT NULL,
  `Review` mediumtext NOT NULL,
  `Rating` int(2) NOT NULL DEFAULT '0',
  `Watched` tinyint(1) NOT NULL,
  PRIMARY KEY (`#UF`),
  UNIQUE KEY `User_Film` (`User`,`Film`),
  KEY `fk_USERS_FILMS_FILMS1_idx` (`Film`),
  KEY `fk_USERS_FILMS_USERS1_idx` (`User`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users_films`
--

INSERT INTO `users_films` (`#UF`, `User`, `Film`, `Review`, `Rating`, `Watched`) VALUES
(1, 7, 1, 'It was a great anime about Samurais and things like Chi flows and Feng Shui.', 0, 0),
(2, 7, 2, 'It was nice to see a sequel for how to train your dragon, though it was not quite as amazing like the first one. ', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_films_lines`
--

CREATE TABLE IF NOT EXISTS `users_films_lines` (
  `#UFQ` int(11) NOT NULL AUTO_INCREMENT,
  `UserFilm` int(11) NOT NULL,
  `FilmLines` int(11) NOT NULL,
  PRIMARY KEY (`#UFQ`),
  UNIQUE KEY `UserFilm_Lines` (`UserFilm`,`FilmLines`),
  KEY `fk_USERS_FILMS_LINES_FILM_LINES1_idx` (`FilmLines`),
  KEY `fk_USERS_FILMS_LINES_USERS_FILMS1_idx` (`UserFilm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_films_songs`
--

CREATE TABLE IF NOT EXISTS `users_films_songs` (
  `#UFS` int(11) NOT NULL AUTO_INCREMENT,
  `UserFilm` int(11) NOT NULL,
  `Song` int(11) NOT NULL,
  PRIMARY KEY (`#UFS`),
  UNIQUE KEY `UserFilm_Song` (`UserFilm`,`Song`),
  KEY `fk_USERS_FILMS_SONGS_USERS_FILMS1_idx` (`UserFilm`),
  KEY `fk_USERS_FILMS_SONGS_SONGS1_idx` (`Song`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_film_images`
--

CREATE TABLE IF NOT EXISTS `user_film_images` (
  `#UFI` int(11) NOT NULL AUTO_INCREMENT,
  `image` int(11) NOT NULL,
  `UserFilm` int(11) NOT NULL,
  PRIMARY KEY (`#UFI`),
  UNIQUE KEY `UF_Image` (`image`,`UserFilm`),
  KEY `fk_USER_FILM_IMAGES_USERS_FILMS1_idx` (`UserFilm`),
  KEY `fk_USER_FILM_IMAGES_IMAGES1_idx` (`image`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_film_images`
--

INSERT INTO `user_film_images` (`#UFI`, `image`, `UserFilm`) VALUES
(2, 2, 2),
(1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_film_questions_ft`
--

CREATE TABLE IF NOT EXISTS `user_film_questions_ft` (
  `#UFQ` int(11) NOT NULL AUTO_INCREMENT,
  `UserFilm` int(11) NOT NULL,
  `QFT` int(11) NOT NULL,
  `Answer` mediumtext NOT NULL,
  PRIMARY KEY (`#UFQ`),
  KEY `fk_USER_FILM_QUESTIONS_FT_QUESTIONS-FILM-TYPES1_idx` (`QFT`),
  KEY `fk_USER_FILM_QUESTIONS_FT_USERS_FILMS1_idx` (`UserFilm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `#UI` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `Age` int(11) DEFAULT NULL,
  `Sex` varchar(2) NOT NULL,
  `ProfilePhoto` varchar(500) DEFAULT NULL,
  `EmailAddress` varchar(45) NOT NULL,
  PRIMARY KEY (`#UI`),
  UNIQUE KEY `EmailAddress_UNIQUE` (`EmailAddress`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`#UI`, `FirstName`, `LastName`, `Age`, `Sex`, `ProfilePhoto`, `EmailAddress`) VALUES
(1, 'Alina', 'Mihai', 24, 'F', 'rurouni-kenshin.jpg', 'alina@home.com');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_BOOKS_BOOK_TYPE1` FOREIGN KEY (`BookType`) REFERENCES `book_type` (`#BT`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `books_wishlist`
--
ALTER TABLE `books_wishlist`
  ADD CONSTRAINT `fk_BOOKS_WISHLIST_BOOKS1` FOREIGN KEY (`Book`) REFERENCES `books` (`#B`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_BOOKS_WISHLIST_USERS1` FOREIGN KEY (`User`) REFERENCES `users` (`#U`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_COMMENTS_BOOKS1` FOREIGN KEY (`BookPostId`) REFERENCES `books` (`#B`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_COMMENTS_USERS1` FOREIGN KEY (`User`) REFERENCES `users` (`#U`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `films`
--
ALTER TABLE `films`
  ADD CONSTRAINT `fk_FILMS_FILM_INFO1` FOREIGN KEY (`InfoFilm`) REFERENCES `film_info` (`#FI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `film_actors`
--
ALTER TABLE `film_actors`
  ADD CONSTRAINT `fk_FILM_ACTORS_ACTORS1` FOREIGN KEY (`Actor`) REFERENCES `actors` (`#A`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_FILM_ACTORS_FILMS1` FOREIGN KEY (`Film`) REFERENCES `films` (`#F`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `film_info`
--
ALTER TABLE `film_info`
  ADD CONSTRAINT `fk_FILM_INFO_FILM_TYPE1` FOREIGN KEY (`FilmType`) REFERENCES `film_type` (`#FT`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `film_info_directors`
--
ALTER TABLE `film_info_directors`
  ADD CONSTRAINT `fk_FILM_INFO_DIRECTORS_FILM_INFO1` FOREIGN KEY (`FilmInfo`) REFERENCES `film_info` (`#FI`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `film_wishlist`
--
ALTER TABLE `film_wishlist`
  ADD CONSTRAINT `fk_FILM_WISHLIST_FILMS1` FOREIGN KEY (`Film`) REFERENCES `films` (`#F`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_FILM_WISHLIST_USERS1` FOREIGN KEY (`User`) REFERENCES `users` (`#U`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `questions-film-types`
--
ALTER TABLE `questions-film-types`
  ADD CONSTRAINT `fk_QUESTIONS-FILM-TYPES_FILM_TYPE1` FOREIGN KEY (`FilmType`) REFERENCES `film_type` (`#FT`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `questions_book_type`
--
ALTER TABLE `questions_book_type`
  ADD CONSTRAINT `fk_QUESTIONS_BOOK_TYPE_BOOK_TYPE1` FOREIGN KEY (`BookType`) REFERENCES `book_type` (`#BT`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `fk_SONGS_SONG_TYPE1` FOREIGN KEY (`SongType`) REFERENCES `song_type` (`#ST`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_USERS_USER_INFO1` FOREIGN KEY (`User_Info`) REFERENCES `user_info` (`#UI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_books`
--
ALTER TABLE `users_books`
  ADD CONSTRAINT `fk_USERS_BOOKS_BOOKS1` FOREIGN KEY (`Book`) REFERENCES `books` (`#B`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USERS_BOOKS_USERS1` FOREIGN KEY (`User`) REFERENCES `users` (`#U`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_books_images`
--
ALTER TABLE `users_books_images`
  ADD CONSTRAINT `fk_USERS_BOOKS_IMAGES_IMAGES1` FOREIGN KEY (`Image`) REFERENCES `images` (`#I`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USERS_BOOKS_IMAGES_USERS_BOOKS1` FOREIGN KEY (`UserBook`) REFERENCES `users_books` (`#UB`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_books_personal_notes`
--
ALTER TABLE `users_books_personal_notes`
  ADD CONSTRAINT `fk_USERS_BOOKS_PERSONAL_NOTES_PERSONAL_NOTES1` FOREIGN KEY (`PersonalNote`) REFERENCES `personal_notes` (`#PN`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USERS_BOOKS_PERSONAL_NOTES_USERS_BOOKS1` FOREIGN KEY (`UserBook`) REFERENCES `users_books` (`#UB`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_books_questions_bt`
--
ALTER TABLE `users_books_questions_bt`
  ADD CONSTRAINT `fk_USERS_BOOKS_QUESTIONS_BT_QUESTIONS_BOOK_TYPE1` FOREIGN KEY (`QuestionBT`) REFERENCES `questions_book_type` (`#QBT`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USERS_BOOKS_QUESTIONS_BT_USERS_BOOKS1` FOREIGN KEY (`UserBook`) REFERENCES `users_books` (`#UB`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_books_quotes`
--
ALTER TABLE `users_books_quotes`
  ADD CONSTRAINT `fk_USERS_BOOKS_QUOTES_QUOTES1` FOREIGN KEY (`Quote`) REFERENCES `quotes` (`#Q`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USERS_BOOKS_QUOTES_USERS_BOOKS1` FOREIGN KEY (`UserBook`) REFERENCES `users_books` (`#UB`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_books_songs`
--
ALTER TABLE `users_books_songs`
  ADD CONSTRAINT `fk_USERS_BOOKS_SONGS_SONGS1` FOREIGN KEY (`Song`) REFERENCES `songs` (`#S`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USERS_BOOKS_SONGS_USERS_BOOKS1` FOREIGN KEY (`UserBook`) REFERENCES `users_books` (`#UB`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_films`
--
ALTER TABLE `users_films`
  ADD CONSTRAINT `fk_USERS_FILMS_FILMS1` FOREIGN KEY (`Film`) REFERENCES `films` (`#F`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USERS_FILMS_USERS1` FOREIGN KEY (`User`) REFERENCES `users` (`#U`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_films_lines`
--
ALTER TABLE `users_films_lines`
  ADD CONSTRAINT `fk_USERS_FILMS_LINES_FILM_LINES1` FOREIGN KEY (`FilmLines`) REFERENCES `film_lines` (`#FL`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USERS_FILMS_LINES_USERS_FILMS1` FOREIGN KEY (`UserFilm`) REFERENCES `users_films` (`#UF`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_films_songs`
--
ALTER TABLE `users_films_songs`
  ADD CONSTRAINT `fk_USERS_FILMS_SONGS_SONGS1` FOREIGN KEY (`Song`) REFERENCES `songs` (`#S`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USERS_FILMS_SONGS_USERS_FILMS1` FOREIGN KEY (`UserFilm`) REFERENCES `users_films` (`#UF`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_film_images`
--
ALTER TABLE `user_film_images`
  ADD CONSTRAINT `fk_USER_FILM_IMAGES_IMAGES1` FOREIGN KEY (`image`) REFERENCES `images` (`#I`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USER_FILM_IMAGES_USERS_FILMS1` FOREIGN KEY (`UserFilm`) REFERENCES `users_films` (`#UF`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_film_questions_ft`
--
ALTER TABLE `user_film_questions_ft`
  ADD CONSTRAINT `fk_USER_FILM_QUESTIONS_FT_QUESTIONS-FILM-TYPES1` FOREIGN KEY (`QFT`) REFERENCES `questions-film-types` (`#QFT`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_USER_FILM_QUESTIONS_FT_USERS_FILMS1` FOREIGN KEY (`UserFilm`) REFERENCES `users_films` (`#UF`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
