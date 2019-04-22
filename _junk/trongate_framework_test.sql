-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 22, 2019 at 10:49 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trongate_framework_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_created` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `target_table` varchar(125) NOT NULL,
  `update_id` int(11) NOT NULL,
  `code` varchar(6) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `date_created`, `user_id`, `target_table`, `update_id`, `code`) VALUES
(1, 'Here is a comment.', 1555431108, 88, 'donors', 4, 'zrAxwK'),
(2, 'Second coment.', 1555431114, 88, 'donors', 4, 'PuJz69'),
(3, 'Third comment.', 1555431121, 88, 'donors', 4, 'rmvvdG');

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

DROP TABLE IF EXISTS `donors`;
CREATE TABLE `donors` (
  `id` int(11) NOT NULL,
  `url_string` varchar(255) DEFAULT NULL,
  `first_name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `introduction` text NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `date_of_birth` int(11) NOT NULL,
  `next_appointment` int(11) NOT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`id`, `url_string`, `first_name`, `email`, `introduction`, `price`, `date_of_birth`, `next_appointment`, `active`) VALUES
(1, 'asdfasdf', 'David', 'david@bla.com', 'Here we go.', '88.00', 1598345434, 1698345434, 0),
(2, 'asdfasdfsdf', 'Second Item', 'info@something.com', 'Here is an introduction.', '88.00', 1534234435, 1634234435, 1),
(3, '', 'asdfasdfsd', 'dadsf@asdf.com', 'asdfasdf', '88.00', 0, 0, 0),
(4, NULL, 'Roger', 'info@shabola.com', 'All we hear is radio gaga', '22.00', 1555201293, 1555201293, 1),
(5, NULL, 'DCasdfadsf', 'david.webguy@gmail.com', 'asdfasdf', '23.00', 1555201498, 1555201498, 1),
(6, NULL, 'asdfasdf', 'info@shabola.com', 'asdfasdf', '23.00', 1555202014, 1555202014, 1),
(7, NULL, 'asdfasdfasdfdadsf x', 'david.webguy@gmail.com', 'This is a much bigger introduction.\r\nNew line here.\r\n\r\n\r\n\r\n\r\n\r\nSix lines down.\r\n\r\nAnd now, some Lorem....\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. In dolorum, quae ratione sint consequuntur aliquam maiores excepturi similique provident, nemo doloribus veritatis earum laboriosam assumenda voluptatum, tempora minus fugit asperiores. Lorem ipsum dolor sit amet, consectetur adipisicing elit. In dolorum, quae ratione sint consequuntur aliquam maiores excepturi similique provident, nemo doloribus veritatis earum laboriosam assumenda voluptatum, tempora minus fugit asperiores.Lorem ipsum dolor sit amet, consectetur adipisicing elit. In dolorum, quae ratione sint consequuntur aliquam maiores excepturi similique provident, nemo doloribus veritatis earum laboriosam assumenda voluptatum, tempora minus fugit asperiores.Lorem ipsum dolor sit amet, consectetur adipisicing elit. In dolorum, quae ratione sint consequuntur aliquam maiores excepturi similique provident, nemo doloribus veritatis earum laboriosam assumenda voluptatum, tempora minus fugit asperiores.', '88.00', 1555286939, 1555286939, 1),
(8, NULL, 'asdfasdfd', 'david.webguy@gmail.com', 'asdfdf', '3.00', 1555211412, 1555211412, 1),
(9, NULL, 'asdfasdfasdf', 'asdfasdf@asdfasdf.com', 'asdfasdf', '23.00', 1555624982, 1555624982, 1),
(10, NULL, 'Here we go', 'info@shabola.com', 'Here we go', '889.00', 1555698375, 1555698375, 1);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `username` varchar(85) NOT NULL,
  `first_name` varchar(85) NOT NULL,
  `last_name` varchar(85) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `first_name`, `last_name`) VALUES
(1, 'Davcon', 'David', 'Connelly'),
(2, 'JohnnyBGoode', 'Chuck', 'Berry');

-- --------------------------------------------------------

--
-- Table structure for table `query_mem`
--

DROP TABLE IF EXISTS `query_mem`;
CREATE TABLE `query_mem` (
  `id` int(11) NOT NULL,
  `query` text,
  `date_created` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `query_mem`
--

INSERT INTO `query_mem` (`id`, `query`, `date_created`) VALUES
(51, 'inserted WyKJFTfTKGjxvw7Oy9IN_eJbeqmxFOrylXrTLtApy1ICUTuHDPoim3GbyGT8zQTk', 1555670048),
(52, 'inserted P3LoMn7SGv8HsO07kQJjGgp-d31VANiyUP5np4-kgKzvUs67686QG1fPn5tLDFfI', 1555670084),
(53, 'inserted 1b33_fDsIzTHed6lH3GkkVPVEJe448XgPD8aJi2bcWyph_WRxv7Sf2AvypPhgctv', 1555670137),
(54, 'inserted zhHCIHPL7RbrcFEorcl-Acj5IsyBNFIS6EJiYB-wc3CVhLQAIxteLwpG8Fv3vPzH', 1555670199),
(55, 'inserted MwaRlTbgo8zJVgr1HAhNiocNEvmoa-qXpCY-7e-9_MYWc2hocdOW8LxZCc36CVbI', 1555670240),
(56, 'inserted m6QxCuh3QPUjbOCRQXWugxCC3ursA04iUH_xCLuHxSrwvCixkkeH07cX6Lg14J7B', 1555670258),
(57, 'inserted cTzkct-KezKf4gt9DTwEpgIF1uC120NpdeJN4nv3tis_C8jNqBLyl8h3xXouIri8', 1555670283),
(58, 'inserted qSqQO1tDVW5OWmCDY7NhTwGBv2D2qlH0hciGXTTxTxNS3rOVBVNTsGtZ8LNv5Fac', 1555670286),
(59, 'inserted vaNbWBSNga8WdoVxQYwivq3Px9Z_SrsSkvNlR6o-oAOaRLOVRH2cMCEeH2polqf5', 1555670341),
(60, 'inserted xdBzttIyhZJ8gTLCjmB4d9LWDGLINtIzu8ooeTgK0HDQxpASp86Ba3bUDphHyqRr', 1555670344),
(61, 'inserted Q4p-QhsmNCr8h3RsrzB_nHkqAQsqRlDCWK_LhXoCbIzSAcFVo77MJI7s5oXCk-pd', 1555670441),
(62, 'inserted ec_WLKcjhgDLoYo-7BLrg4LsgwImpCc7jtI0MwpXa3P9UgMkvCLkjYuroXqDLNoM', 1555670444),
(63, 'inserted ZFFNvKVdBDGVHkVOC3gs3_rBLCxzFvBm89_uMVWa0TyHf1ayMZ75yRLPtmUukFZi', 1555670453),
(64, 'inserted ql2GQLlFc6OucfWncUTFbOsoly5PVMquRiN-qQkDJ1eIcnul7LKVpjZ3XPyviwF6', 1555670456),
(65, 'inserted l968Mi-fFumrqQjQBF34RvGEw4opV6QP948IdQvOjMFtEYvEM1EMnT2z06WKIaPO', 1555670522),
(66, 'inserted N1u-Qlu3mGk9CJayn2GCVNxjnKfuqVSTOQm8jC4ZRhF04sYHo-tgpRg8gpySptsm', 1555670526),
(67, 'inserted NTsjcTVzSt7GEnqPdqQuZXlFqXjl4GrhJR2WX1Lmfrt8Lil2pxQxCtEOb-FRsCHm', 1555670529),
(68, 'inserted MbKOh9JDBlwPJhezmSxhNVXHZePGsFpArpEYuOAUie9_hJkQoXJhn22zm5pKsd_R', 1555670530),
(69, 'inserted 0gIXZDlmhKxy5s9vTeKCm2H2vCBN4tuw3_pqy-B5GIsjxMLVSHzxWHOb-RwCl9Jz', 1555670542),
(70, 'inserted s9ZlmfhPFX1Gs69bGh9oi27loSM62sbDZM7mL9ByLaofrRGYr-GeX2qiK1LyrJgh', 1555670545),
(71, 'inserted rgjqGMZRDBM1ZAe05QjFdAKmXzej0kHPYZllfT1R9zEIXu3i2BDaNxtKfzyi_CG5', 1555670547),
(72, 'inserted PaUwooJww8bh__xPH1Sdu0Ph9arQ-ysphSGLlYEF9EH7yp9iuW0DIqLNJdzq4NMt', 1555670565),
(73, 'inserted 4KnjkHf4xVKM4UBsxgrNpjR06SRe4BWneD7inIQ84eGIvd-RWB38ABOcVsIOtB_d', 1555670567),
(74, 'inserted NA_H2tE-R5hdjkWFktC61udFb-GXpMImK6WiD7j3Ja9hKFLvelwRrowPh_zZ35rp', 1555670571),
(75, 'inserted gN62r-lXk6ZquPbqCheIjq-1Ir-eenxplNxLI7M_HxWHkLMkBEbLxF4LUk3gcQo3', 1555670573),
(76, 'inserted -0_wHcEpOEz-1XpK-L2wyQrppGWzbtIoLOjEewhff70b4ZSYQysISmC4F1WwqE3d', 1555670620),
(77, 'inserted pOEy3Gz0s6CE6fd11I29BYgKm3De5vJyZy-ehACPQLSXZGNgzwjCo5OmYX1A3efw', 1555670623),
(78, 'inserted wzcEgC3n_RXo8kwNy62oIhxIaX6ff7GqBWB6cjfmYDP4YuCv-0l3aJDQL3isrJUH', 1555670626),
(79, 'inserted vtHHmZ30hiiQGDqYM3wKbKgNeET8OvDktn5Ev1Va5dlwCJBM2yhnswL2xoEHJ8mh', 1555670629),
(80, 'inserted k8d8BNF_Va1dkiyEYPk5kVE9kT93djKY7WPw0OghxhFLwbwKYgGwWisAASrNtNKh', 1555670633),
(81, 'inserted gKSxvY-JZqgvICyJIZ6FazyN0O2PU8WM_goU0pREan3wxcHLIOJCbkHGz26_jBJi', 1555670634),
(82, 'inserted ZHw296WqgpABA3v6yqaEmtzD27DyN9W2pQfuDTPGqanI71ycWsjcwpSKNIkKW6E3', 1555670656),
(83, 'inserted YfUiQ0Sj3H4T5EulCGFDe-ZrAJ0QWgaK4AWi7tbk4i0qgMM5dkiSbnfXHv8grdhh', 1555670660),
(84, 'inserted g5Qbeurrkwcoiu3P3KXVWRBHmZtQ9AqdeiuUHPuE8qLUtanyngcUJ0YGb96weRz7', 1555670786),
(85, 'inserted PPX1J2jZ1lvkJT_zdpe-nGUNfBNOe8aPqcheTlBtu9vmBhGpfr9MuJnoo5O9-IU1', 1555670788),
(86, 'inserted X8eajLKQqkr8d1Hl4V_LejXmpUYgDw2MjyucHKWaVeK67E3hvNxrdLPM6yehERix', 1555684731),
(87, 'inserted TNJpwkrBDUmtZ3BsvzKBsl9CnWyCKJdVzz5_wgxSW_J5sAwM-H3EUEHceLGHerp1', 1555684752),
(88, 'inserted hu84xiLt4OXDTIaDF5DJuV2qNUoplWO5huGu5grP0nzUQYE3JFMJuqhorXMyrs8N', 1555684759),
(89, 'inserted jw0RMmYhjkHe6UapU6SLsLvciXWHTAP1Z8v1VXtV6-xCdVXkdTKdx8hdzoUimodG', 1555684828),
(90, 'inserted klD0jWm0Dv0_bDd3sQCxkoOEkQveqnKI08RPZYgqKFN0hn7MARaVfGkU0m6P4Jqp', 1555684841),
(91, 'inserted QSfPbXU-6CkCRXJTIl-unJFMaqkn7-qlrsdB8d6maUg3NKbsO9fiWb4QnlOXWVy8', 1555684933),
(92, 'inserted Si93GqW8Qhmt9velN5xYJkc5VwOKkfN7VacWCQJ3DSi1ARPRa0-z0YQz3DP8Ovod', 1555685000),
(93, 'inserted rDQDjuOX7lvIbUyTQb3cmHHVwkLlaAPZFL9Ud7dGbbFb_p_XJk-cBDPvIDsXyb0U', 1555685034),
(94, 'inserted Iycf9d4WXwvAdM0hcKFKCqF2R0VwA_GJDOAvLdNnTCCMXnEu76OGNavdZmTZZeDI', 1555685396),
(95, 'inserted ZiK4b_Vt76QYXCjWh6A6FVeDSr8yzBVPNYCBtX-yd7bfaeG1IwFEJ2m6WRMznXHp', 1555685402),
(96, 'inserted YUO5CUfNwM7YSLlbbt10KIsMqYmbHSf2nUdhGsMeqEp5Bj1dSWaXdSsj5aKSZMm8', 1555685428),
(97, 'inserted kPbDh4t_aj3Csu98ER3dFlt82h66eJw1pQKgGGMSyFFBbu04UFgDyEshBlav8Pnl', 1555685474),
(98, 'inserted Tnbdyd2L4sShsScliOrc14kbGZyHMjZJzjVXTx5vOGE1MjyR9DKb7GCxXBGPFFcH', 1555685499),
(99, 'inserted N1gqteSwaiedWuB3kqSAphcPqqyW72f8JhaeAqBAX_2Qi2dQwBEaZf-Larf8qO0Y', 1555685522),
(100, 'inserted pzlKn4vvsH12H0ir0NLUH2D6sNTKQmkAKDNz4mV_xKloVxZOtZ6haYyOflnPcdZP', 1555685563),
(101, 'inserted vI4rNwOTYmMXwpaJQv24ptKfCcozSXiqiGGP46mk2_C2KHFQtpNWmhMLtfiRrFTB', 1555685574),
(102, 'inserted i-7iXt66al880wMFpSm_Iphu1adLUBmRsynyLbD7fGSjPuUzzvXGhj5BlYYOrlLH', 1555685649),
(103, 'inserted kyE6zfFptC57Z6BD90F8JhMcPSW-Jy0NQYBs2DjRs7flXVYvygQFBLBcXG4BHeU4', 1555685665),
(104, 'inserted k0SCD50YbsXNR0BFHdQB5yzWK0xDMOHy7BQs9OkjTBJXPcaN9JNQ6NcRNiegdxLC', 1555685686),
(105, 'inserted --5S0QuwL9V4slSgh6Z4WWLr11BIGWRycSYSS8jRruyu2rju_B_ws7bY6tKXDGXJ', 1555685701),
(106, 'inserted 1fNobzr9q7xloJOODYDG207N1D3ZO7BQFM7WJPTRggmN66MUL4dmhtbtAxIDBV-c', 1555685747),
(107, 'inserted _4n_69s26VqfFA3I-xMe-ZXbyk2nznBgrMkoI4rcI5-1gsXl4foHOsl971Nkt44I', 1555685750),
(108, 'inserted LEqlU3N38e93VcgeFiX0pEz9gKa5rsiTPbCkVxyU9brfrsGV1gFUDB8ahrD306RZ', 1555685757),
(109, 'inserted XlEeoQgAtpqsjvY1BAqkBDXbCkYHNXHNsy_zmYZDZe_oQ8pQbvC9t5o_krJw8fTL', 1555685760),
(110, 'inserted m3f5he8ldQmzGuugLw8TT0xbauKAhHtUaHVgv3jBPkk91v69rlcxzAJbWdLqvDlI', 1555685781),
(111, 'inserted 9As_A_7b-Ba9q7P106OL9V375d1CYDPXrMNNzHclBZuWNO4ho2baTE9foV-iItk9', 1555685786),
(112, 'inserted mRZZ8tAhYSQ2sZA2W6_VR7FzETMtGY9o7baQYPmCSvIwTS4HxVxoAkVJLpi1Qst8', 1555685789),
(113, 'inserted ry7vp0Gotze-Fhn1Ghj5i6eaZBu55zhN7uin48LujJZ9cblD1OyUnhItRccrpQ8B', 1555685790),
(114, 'inserted 8jdrDiCWK1Q3jHgqA972zwBc6jWKNH7JJ-2kDvVKGYgEGxBkMWmt8yqZaYrDuwYe', 1555685795),
(115, 'inserted VbhY9i5wPHTc4tTpr0_84NtsztAl0plbYzLKGSbUfASP9Xs7YL-hv-GrBFO0ptXp', 1555685801),
(116, 'inserted oMvJ2RY8wpSQ6YigWugykzutHTO-a8sbpFQ8PaIISi2I8bXKRnEW5tzaQoLmtv7C', 1555685812),
(117, 'inserted LEXrW0qBaMKvX6nzphUzwo2WbeNgZ8Mn6VGfmujlhHhK3jHPtdDjmieSw3XFk-qA', 1555685841),
(118, 'inserted mNl-KYmUDFd2Z47m1QBGp8tflQbynp8p1XrEc_MadHcmVQTVC5UgS9sl2PnbASNR', 1555685847),
(119, 'inserted 1dJ4Otz135XoFw4G3iT56GwIun1pTGAL07e1D9NNynfNzspmY_3z315IqXmX5tiG', 1555685855),
(120, 'inserted fO7nbj8gRe7pGVSW-cb3M-3gljHpdX4HX24rBnOk-L7nY_oXV17S0JgeZZANdncw', 1555685856),
(121, 'inserted FBVX7Uc6JmTvXw_2Wxzo172UatBknS6WWDTVINHcqdhQ7837eCrViAVl0no3RWVB', 1555685881),
(122, 'inserted 3vNVHSgn4RQ6GshvUPYl6Jb-j-y8dc-DQIiLInbBZgnqTjxJUoBpsE4W4rlScWgu', 1555685885),
(123, 'inserted cO175ahveuEdvqYGvrfnXQUgGevxReAUIRvYodkiEm8hLwIHhB-7Rw9re-G-nwDz', 1555685892),
(124, 'inserted d5-koSkA3pOFfK-Se-FMo_irYYcHg1We6f1ldXXGRD1ZTYR4N5-hqsQ_Yf6sVofP', 1555685897),
(125, 'inserted 9NlDybMwi6jBRQTNYq7dYZcVSGYwZjNgIp2NjxLpyC3AnFc3n1MyemlmnAPJhQrQ', 1555685899),
(126, 'inserted cAqedBBecJapDj-PR3hpIUpVu0wL8WUkR8KvXge-q5vITR8LbN8D53GfPRHvcMh4', 1555685916),
(127, 'inserted 38NYAymOGSw7Jam3vjX7wQhcGfJCQX4g7pPRnvTxB9tLp6jgyAhYYcLrcnNFrWPh', 1555685957),
(128, 'inserted LNJnWpXBGDU9e5zISxwjR50AJcQrDcp3TQ-ceAPNfrQO3DwyLPoI-F-i1CJpoXxr', 1555685962),
(129, 'inserted egPOjWdWt95kOIyGjIS6kWEUlJeAUzu7NXMlYV8RxEzx8uX2rAbEWq-snfCOF72O', 1555686021),
(130, 'inserted BgDEk_1ZyAYa0Loy2m9QvEFwT00s0ECHG6DQJGoBmu_bRvgRcWkhYvw6ZwADzJ9y', 1555686053),
(131, 'inserted zlMg1zXBcc7TJ7M_CkKv32Cam1w2G6LayZMgbBIdDCkhAvhNEGwehUUkd8KL-HWU', 1555686076),
(132, 'inserted EX3WCUlwccPRcwGkbR4jyl1crGo3XmxzfO2dRh9skwfZA0ffWSeeQUTyj0vD7NeU', 1555686141),
(133, 'inserted snOc6YHfgWgX4ahCb5OXC1WpvzFfyEhG9WF83xLzgsTVWBCNWa87iqn4DVYSHxLw', 1555686145),
(134, 'inserted Plngd1ABOiVNGn5cRCKkyERHXfuT76AYpq4jBtkfs7eGK2wJ-BIcgaA7kfeByyQw', 1555686151),
(135, 'inserted VUnm6mbbZRavm-BRFNBtpWxgeLrxJf_QTUh2gVUYSH8E67AnOMtg7cexLQhqxCax', 1555686154),
(136, 'inserted kMmyxt6TiB_rzXfmOn7qi1sA6QQwdDZ2DBXY_GeTpdsqG02C8UUvp2RMMEXNKCQV', 1555686183),
(137, 'inserted YnPdXMssJJ9zoIUXVoNF7Q9Ve6knKn3pstdu6Ah466ZgajAg4gi5RpHOhfO8eMBk', 1555686191),
(138, 'inserted 9I-lsqwCXIcidSBpE_n2tHZPEwthcrow0dBppxMkUlnweGbmtdn8cBPlYtdIVgMp', 1555686206),
(139, 'inserted k3fEaRZAH77hTvjfGtetP7Sur71taa-Yl6-Ropyqb3VQwRF47ebOTfPwyABajwaH', 1555686210),
(140, 'inserted EwAd_ni0QrVGRunY051I1RrB7ghefOshemgGoy7OJxOeER0J68L51iFhpj8pB7cX', 1555686317),
(141, 'inserted P3mmmW2LIigg-BtEpiXiwvT1PTgdAEjTh41sL8ulTPFwLdMZ3zZ40ocTJumw4WBz', 1555687235),
(142, 'inserted ZS4p2atlwHLPUHhDXjSiq6GEcn3XC4FbJBX5kRogzPI5LsKt0NfJDi4OCW_RFMWJ', 1555687297),
(143, 'inserted vmSZO_8vjn1FgIEKSKlEmC2YXHeYVElaXBa0vpEVnF9EUuBOI4UeRVbx8-ouXNoK', 1555687314),
(144, 'inserted wn8YWIsPw75nxfgp0IZLS8Mk3CfNjZGnKKnZUUA1wsZbr-sAWuVfXLymhpPUVQHA', 1555687352),
(145, 'inserted u_h0MhzWRNOwdClcLzQ4jb8wySMlAZAuhjyGN3XBcD_nz4NZLYyclKIcY3ikW320', 1555687387),
(146, 'inserted qlPSVq_9Dxnbxym7YhH9ao2dLPyMAEY_QJx_Y7DQ99x9hMqdMbPgTwcyvLpgwTDr', 1555687441),
(147, 'inserted RzdOszMDIvKrZ6VXNU0dzMKczLqMzjA1zgjBpMro26rfwMoBihkeOx0MbxcJgZJU', 1555687455),
(148, 'inserted T0TxZCJ4MGPrv4LZvjmMe4cdAcgcRGL8pE3swj4sUoYaz2vkDw_FTwo3D6LAfQy4', 1555687489),
(149, 'inserted a-d_Lo03UZWtk0Yj3b-280ot9w1K6TYkp6iJNPtZNFxVluUdKMQCvNSApOElVebN', 1555687494),
(150, 'inserted 6WFweOdz-idGyKIGD92fM_IhwPpPDvoziQnn5mCw0UmvjWxkU-otV9HxOj285vdk', 1555687588),
(151, 'inserted i44p89F7R_f2soxEykreDjEJW-bMqilNpgjbZL5HoqGT4IVthGt259NdF5AY7cel', 1555687593),
(152, 'inserted 2hbztd2MmGDAgK1_Gb96znEmM3rFoDFdoBgGCr9MEg6rFnDd7aSPY69f2vOV-g0y', 1555687635),
(153, 'inserted 3LgsQWq7ncx5Xgd6uQCxfl37gxDaUIuZoaKTWH10SbL7ZVj7kY7ySd6PpYjGqUlh', 1555687639),
(154, 'inserted rqkjpITxLSqXxrakFzXW-eiBKlf2qzvn2sLGq0tT-ofijzjTfUYNqVV9FgOaL3Nv', 1555687692),
(155, 'inserted v9ORIPtvtHyQxVrtcBsxi9yV62DkClqqbALuf3vIvvc5b-zNt5ESLhftM7YPMQIj', 1555687696),
(156, 'inserted 4JCpwQPObKCDqNuq9g6RiiKElx-U3unKJ6N1zkhHxfoy5PySD91G3LPQu0E5ZimG', 1555687720),
(157, 'inserted UWjg_Nep-NcReyaofWNOcmEet6lvW1JDxkKEkW9rAX3gq5DNQWxFYAwCo8RP2n1A', 1555687726),
(158, 'inserted H_AWo_x7HIpFFheRzmaOxpAPfYMRILKT5hr4adWoDKRkKgn_1-e9-YqM0miZZ7ch', 1555687751),
(159, 'inserted Bh8ZFd5Fw1s53kQMVxSCURtiSZDzcTsjGtetPlXxWHQunDOwsMBFEmyY76rKrcmJ', 1555687755),
(160, 'inserted 1FY9xKy4qeHNKUR02qGzFBeZ1WT24rcc1WwA1CXR75PvrW9lrzOTa5O92Px-D0Ee', 1555687766),
(161, 'inserted aHzAHBGTeQ1jvIZDbmAmYQGyG_jEG7Gf9vSYmn3LW5SHkFZjCuXqiQ7IK491e7Jr', 1555687768),
(162, 'inserted _gFZ7sW-YoYIEa86K2QQFpi4YTicJHznnX_qYAdTzz9NtwiEnSwDFJ2xNkktV80Q', 1555687784),
(163, 'inserted AZ4Gj0AtHoFEl1btbe-EN5jiYcp3JRIujBS3J4OlnygRzbfnOrSQOPDeDPFmeDQQ', 1555687788),
(164, 'inserted h8EtUzbUiKfaealPFKDBZiFh4c-ZAIRexvrR1i_A_z1qXri4ApT6umtjpkWqL7ZG', 1555687801),
(165, 'inserted 8N292Zv5W1ZmgfMft84f7rHmtdfGFuk1HiK6bpIF41lQ6xktn5Ho6Tw5aQ-jfrpD', 1555687804),
(166, 'inserted BpgDqUDA_0Ju5BSPaX6AGAkQUn5TQUUoonBZkbQJdGFl8-EI5OIQJyW43bRzd9Mf', 1555687809),
(167, 'inserted fOmoI0npzDufWA5JyVATdHtJ9uWEJbs1iOUzesjdq5xd5wqR33oLVmVad3YYQPq9', 1555687823),
(168, 'inserted 0qhQ4D_mV0pDGL0LYdrjVcej8Gg8WlbguGcSD_9rlLY3sq3XxDpvo9nJr4UZyyW6', 1555687827),
(169, 'inserted j-QbZFCsffkf2ca60RUNZeGVhSr2TCHmByEmZHg9qMYyUGSMcUwNWnYdnHzOmRKv', 1555687832),
(170, 'inserted VtJX6smNmn3Y27eWHr0NL7ETvVqq5bNw41aCFvN68zYPT_eKY2gptvVuoKcBFDBr', 1555687833),
(171, 'inserted w0mZt81hGY24Uz0ia8wFi4KnhFnEHFSGm_3rBD4ypjwFPH2rci_zCetSZyrAR9Bn', 1555687836),
(172, 'inserted RpRwgTiudR0nRvshfgoS_H5ksKJMPkyoXaqMRoTHGNiOQI7FYLUAZ3eoOfbEucgS', 1555687937),
(173, 'inserted wgmarmQXi9-Fm-gDpDorQUKNGrXgS-vFLO5khNnhK_g_j3YKm7QA74tf0P68H4qM', 1555687941),
(174, 'inserted ehZj9vaXdPTW1BYcLZORjOV9tjqnuZehSB6hu42gVho0aUT323pL371uJhLq8_sp', 1555687961),
(175, 'inserted UDyRp46pZ7gx-j7OobvrMYYAFQUg-aB7Y2QE3N1-VWJNVq7bl-rdtvvkapPrS1Lo', 1555687965),
(176, 'inserted crP8RjyP75yxqlo35OuIRVj6RLIvrP07aNg2htevm5_RnQrpGlQCOt5D9oXPFpgu', 1555687985),
(177, 'inserted _nZKabMnfi4fF0hSIysYcPJ09NgaCAJY4fDsrORZKetX5KTkaU46XflKFqvb1fij', 1555688076),
(178, 'inserted cr7fBaEcZCEMF6NnFu84rR-DnHBBjZvM7NPqoY198wiPqUZU3xwqn9w0doZbXAkw', 1555688080),
(179, 'inserted J_j32XN1z8oLqMDMdyx-65w76mU-TK0VwzjbHp_Q1zsx5GmSLFcQkb3OwYIJtr_c', 1555688084),
(180, 'inserted bWduZCSVFPgV4GoBkmdwnx3vt6dM7-qBMEEFHcXRw97noSwgRz1bvVOvk2okn-oC', 1555688149),
(181, 'inserted SZHMk7bE7kewSvH_MRHkq8vT5bNxoMEbsleuANT_dtkaJ2DmZ7lea1Rr2C6R4kvJ', 1555688179),
(182, 'inserted iVFDHb-uRu-fE-mccOJ6UCnp5g4asZk-YcTrTa70SqYngXaFdQ89ASKyegdQMuwh', 1555688187),
(183, 'inserted TRtKNnm50Y6S8z83Jp6PwUFxkz0JxfpJa0J1Y3vconL4YwclTYYYNRBfu9NJBNl-', 1555688266),
(184, 'inserted ivA2etpTVZLpo0r7KKM7P76W26lUMwfMiEPJ93bUBzNbq0Tarx7LoQWKb-p0eb7H', 1555688275),
(185, 'inserted qSIqGR_Esjkmj427d4v5fdOtz_KLGBr7QXqC36J87fbqwZl9C-SYj7Q1zjXe_aus', 1555688294),
(186, 'inserted r_TJp7xNOxXUsbXBEhb2yelI8nGCD-vzTAzpjZ4rqSLYDE0b7PMCnUH3CL98n0Xc', 1555688332),
(187, 'inserted arKPQl9g-C9X472zCbi1THdGYB4AEUuZ45MqbPIm3sNZ_tfmivmJ77n2XatLe2X3', 1555688351),
(188, 'inserted 8pZFDKhw8x7X-FMGL6dqdVHuizyRgZbvJ_eFreeI3L1yJiCx1H7y5Xb_VvfZkVk6', 1555688416),
(189, 'inserted AzdKJa0W7UNCxPEzHULUGc5Wc06o9Q61CIFfq3_smK7zqvNt9AcStJuHxk9nYQaa', 1555688442),
(190, 'inserted bwYbsThFSVL25UzF2vDE_1Jm7ivU_QzC8S2VNArBeT6JwUzy2S0EsAmkQU08pUgN', 1555688503),
(191, 'inserted DEGjJKxCfyTXz1cPium2FXWMI2yZE2CkJy2v1U0spYivgc_5Q06STunpVY1GV79o', 1555688524),
(192, 'inserted InsjT8eyK3EBDSfSqSK6_zE4H4O1YukElrIFY3UJhuyiuOxyTLhXaSgeh-jfPsHg', 1555688582),
(193, 'inserted ZiGP8jRKP23Ate0-0zModcUg1CMvHmY6potb8wGUMgLCcPiEFGVF2CwJI6JFriQE', 1555688592),
(194, 'inserted IEFIZ4nujzMydGYSebo-Jv2oOFxXrtI-t-NdjtbQP8nfFnPikaQCIDUR6BqUgmjf', 1555688612),
(195, 'inserted zqHBH04CnZEvybNUyzgvxFN641OzlPl1LMd1Hd0NJVzUC4gULE4Rir3jSWoXysa4', 1555688614),
(196, 'inserted cINPL_2FcIJhGrGTqpohszNpTbIWx9EMFqMpDXdhpKfmHQb5QFkZLhiPz8p8EQl-', 1555688620),
(197, 'inserted ww3xTEz790YZjZjBuawE1iGYJhfhb2xxu756lIobqI9bo3sjx7Y1tNNDLYCimdoD', 1555688635),
(198, 'inserted dpLx1HJ-chc1AJGz0zPSqgYZh9R_-MvASluy4eZDCB8p4m7FettQz7c1RFFHMmrB', 1555688636),
(199, 'inserted 5DvMsJB0K_paRDxnyBSGkX__7c2jhqOUh1vPBOQMksmncH5RlvTr1yMP5dfB4DJZ', 1555688663),
(200, 'inserted 7ih-JiB9_g5l5ciZTun5UKKwQ5XE8XIyKnXxpsHe7uQU-TDBwyTvqBXsDK7Da_he', 1555688664),
(201, 'inserted n_8VtTiO_TMyd6E4alQAgCbxxDSTXqVjLaQta_AeNq6cScGG_v_ARJFYBARwF4d4', 1555688678),
(202, 'inserted k1BrNBF3SzzF-24ojC00p6StIiSeYfeUc5E0sJcVRnWv__c3FYw6aDDdU2EBZ--d', 1555688696),
(203, 'inserted lSeIf7bu-StYHr3YxVUepw0Zs2xh9ccTyKBMZjDTHgi3KVwvn_9CtfVgBkTQPaEr', 1555688727),
(204, 'inserted WygW4oOIaWEDWVC_cF3ZZ4GoeziU8PkW0I8RAFnlypFVrvVI5eKX4Y3xUXGtz-CE', 1555688733),
(205, 'inserted R3y5AtASZlui06UGsu3KSZfNvv5AXWIDaldeMPY_A9nHypeHKLbFYJWa7Wn8VDwg', 1555688735),
(206, 'inserted lglaRZfd8c10nZuOBebuq6Y3tKbYs25bwlVaBkqrWuVcM8kFEe9oKf5xk2YjF8-R', 1555688871),
(207, 'inserted x4cfWiqtt-MPYzVe3xm1s-jsYOp9FFvXm5itjznB5URKOgIKncWq4yeq2A51ty-K', 1555688889),
(208, 'inserted fPJ7js3f5tAEPr8wRpT8xIHPiBUDpr_eSRJdDFVs-3EtYE94Pr9notawyTXIxgju', 1555688934),
(209, 'inserted XoFcWWVCKj3iOUlWpsiBuNW_M_82s70q8-oRqU2YL9DeimsM--WhpH2vCTuYp8SX', 1555688956),
(210, 'inserted pyHxVuYACC1Lo7-DEP_mpFxCv23SxxAmWGGavTNwjYuKPYAfVIRXqCZ1vfkeLYIp', 1555688977),
(211, 'inserted JBwsrxy0TcyEshGMb5EgrqhnJYPTM4mOFXH3XW488_VgR-7lQ_3lLZZzVD0yvJJQ', 1555688980),
(212, 'inserted egz43wJebkSkpAfJLh_zPLeplYO7CSUcisIFdwycSnPw3adcCIFKmQkqYufZmXRJ', 1555688998),
(213, 'inserted 5ieBmHCpFrea-S-jm55XndE8P7aQyJAwi6-KAA9oQUBElD6EPDK6LoV7AQC9qTIf', 1555689003),
(214, 'inserted jRE3dbHCU_XTk2jxxZ3isG8Cia2T-GS0OvWtCYzR4zvA2pn2HWL9ahpjNU7XKMIC', 1555689051),
(215, 'inserted Zz9IPXCUb2ytxMKOYP8muYN60WxkZNucXmgomJMLWB-8QNq7OZgSKorDDEqEO4T-', 1555689056),
(216, 'inserted JGj1ItqzXnmi2pelO0P9d9fghZmBP7Og', 1555689080),
(217, 'inserted bkZt10Zl_Sf7xXlWyNeZwCBCzOf-abIf', 1555689084),
(218, 'inserted NsiIhrTTCXw-Saa-dsRvMaPopAxrBTOy', 1555689162),
(219, 'inserted 1NE9wAD1eeAJ1jPUe3xtXiYowlmNo55W', 1555689182),
(220, 'inserted CIL0IwROvyM2BmaFxtywCqk0iZgmMJyr', 1555689185),
(221, 'inserted ycJiJ_2zfv_qdBH98R8CsU0IJf-LL6MX', 1555689194),
(222, 'inserted I5L4bvfiBRJyegLFapMtTMgT0seaGdCY', 1555689207),
(223, 'inserted BH8HN1NOQU1UH7L1IMDKss5I-qnF4RDR', 1555689289),
(224, 'inserted nAon1C2kxmK7WP5sQIU5cuA9Lb2A1AQn', 1555689293),
(225, 'inserted 4C_J50cGpL6Lst0Vx6Ln-whLaNh-znyY', 1555689386),
(226, 'inserted uiAGqqI4I-1w7v92MnwgJstZQX8tD94-', 1555689399),
(227, 'inserted 5_dqYM_Y3_jw_YTxI6ZbIh4Ob8xeJ9ml', 1555689402),
(228, 'inserted jQ58Rd7c9lQirqSV2XhFV_MWes8jybOu', 1555689480),
(229, 'inserted f6cwGajArGSHZILi2KO8lPdVHeag-ngo', 1555689483),
(230, 'inserted H7rbhsjChyfTfWqGqiTH7uFj7fHo0PiE', 1555689497),
(231, 'inserted r0WvQzGqzVJicdjY6azdSujml1f5-h80', 1555689513),
(232, 'inserted Rc-RxwUr8S4gx3nZRm4w4YjrOONDTOEm', 1555689570),
(233, 'inserted Q-_gvzTbrpdnlg_m6aMRN1Ow4WaWn55L', 1555689574),
(234, 'inserted qqen8jzwCEA7S7RqUFSGkwz5B-lhSSSW', 1555689696),
(235, 'inserted hxADkOY_A9UodiBuDoEY_EiX133L0xzn', 1555689700),
(236, 'inserted EJJzCCaQwkHKSh__1PzaLXFua2fvisny', 1555689723),
(237, 'inserted gUn3snO4RBHTYYlb6xS_XM8dLSKkrvjF', 1555689727),
(238, 'inserted hoXVuxCzcvoVLVInKrg5n6RM1KzUuq6f', 1555689942),
(239, 'inserted 2j039cXgGBHwxWc--R7U7XkuGMiFM1WE', 1555690531),
(240, 'inserted QVtzkIDObJTzbmxj9RgmnDqov3bjaZPL', 1555690831),
(241, 'inserted vpTfhLP358YMI-T2VB_zbCKzmPrb5Spi', 1555690862),
(242, 'inserted 14VotDxwywuH-wOVhEsFJPtp2A_xirYF', 1555690878),
(243, 'inserted B7sPfm_v-mj-HOSc5Y_tYSbhP6gKF5lE', 1555690905),
(244, 'inserted bJWS2KVorVPrpUd-xh9mfnpZJ3FxB_6Z', 1555690926),
(245, 'inserted ZQPQm_xLID5Ag42AHvg5Xv_4z2DwlxSJ', 1555690947),
(246, 'inserted ek1e3tyDNX9g5DOcr5em8kSbf06uWid6', 1555690950),
(247, 'inserted 3Ri9nPzSW7ocCa9QwpZbvs2NKUitC1Vr', 1555691000),
(248, 'inserted WEvQ2zzn45EkgPgkp9gCBWyMw7t5Xe3i', 1555691087),
(249, 'inserted UJFoMjd2YCGCHRRy4ohRfHIz-ZEAS9vb', 1555691456),
(250, 'inserted dmXpnnmPyiH8u4kvv2UX2iJvSU_bKsG7', 1555691468),
(251, 'inserted ctqQC7Pf6ANb8MxMTGnyUjzIZlfINiKB', 1555691471),
(252, 'inserted 5JCkAwV8OjA8BGkN3YcyOdv59LfxTUlD', 1555691488),
(253, 'inserted zA20pasjGPeElxSofWpGDNGFOMSjqY6X', 1555691490),
(254, 'inserted 5CC4IFmJlS3J1cyCdh0xuBn6Hyw52fyE', 1555691493),
(255, 'inserted CnD49ihevCMufMNpMdVDMdXO_bU3EZ1v', 1555697295),
(256, 'inserted 9ybGNLEYrI3tptFRE-UQqfHVnsTnME8l', 1555697464),
(257, 'inserted 92An9EblmAmbzhrMQiIvRolWvxGTmLPJ', 1555697491),
(258, 'inserted XmwrhES5DB7Qs6XFPWmnDvyWIImUqKvU', 1555697573),
(259, 'inserted brtXCAtFXEH81FvtGyyaxCfjT4Eq4Qfh', 1555697643),
(260, 'inserted ayVEFOepmVmyZsv7sT4lyN5EoM7xky5z', 1555697689),
(261, 'inserted Ue_XUEgURiG3IE4OxZwSziPl8l6nl1hS', 1555697711),
(262, 'inserted 9yr9pnJdt9SDi6HK8fXOga-Hg18poFWP', 1555697719),
(263, 'inserted GX7hD4hqbkDxuHtpPs9YFqEbUe4PpQK3', 1555697957),
(264, 'inserted dTPMlgEGoINcnSgMRfMkCJDiJidHQGwp', 1555697968),
(265, 'inserted A1AjJ2TMmCxVRNdyqUu5VZmlBgqi1pTF', 1555697969),
(266, 'inserted fdpvGhfbdjQmyv9cMNc6qxVyG_FJDQsV', 1555697983),
(267, 'inserted a6Zh1ZPwfVgo7LMyd__D9EfZxqCG8-GH', 1555697984),
(268, 'inserted 3YDaRq88phVWInB98htIr7IeZLlkCoJY', 1555697994),
(269, 'inserted LS8aaXVgx-DQwk5uq3VbAHSmtIoNAEJJ', 1555698016),
(270, 'inserted _yDMfpB4WTnvHZpoJ8XWG9_t_i5N5N-A', 1555698057),
(271, 'inserted 1y1XLzz02ZaSbebg0gDX-WIWaP1pbtmn', 1555698147),
(272, 'inserted WEAwLojEtRpIttR7mLqVw_0OTdbXjbHc', 1555698156),
(273, 'inserted u51hCwpdNGNJddLMD0m5twuoG8wHcpZk', 1555698307),
(274, 'inserted bpZUAC-nC6AfA_mFYAr03clZ-7QWWMsh', 1555698346),
(275, 'inserted TIEqbVe4SCa2HGeFuMoE-WccJ5Z2V_kR', 1555698355),
(276, 'inserted -S_299CyCQWMQnyjDfSk5MtwSYoo-MD4', 1555698388),
(277, 'inserted xzIwh27ppWAP1rAIctMP7TCYNHXto1nD', 1555698394),
(278, 'inserted 7Vu0MFRjHitbs-j0hMl3O-H9z4szp207', 1555698411),
(279, 'inserted EbeWDHefowUEoaLUc2SQPAX8J-bcvkOU', 1555698456),
(280, 'inserted 0lvDm4d88Tx0FjtoITDVw852y0JHu738', 1555698462),
(281, 'inserted c9OtBuUJ_HrGs56PLg34_Kd2VvhTxWBy', 1555698540),
(282, 'inserted 6jyk3FXeEW89DgsKYSnnqODwUvF-QiLl', 1555698553),
(283, 'inserted vRVov7uKjdwAOyXzvYGI9KdPSpGHws0z', 1555698600),
(284, 'inserted UGw41ldwPkdq_o5IBhSpm3ghzJRG14rG', 1555698623),
(285, 'inserted 2T2o5l7L_SIrcsXc46xD41h92BygdVN4', 1555698647),
(286, 'inserted naSg4GUGWqclcNBznoQ4B96FlXTYpzjS', 1555698665);

-- --------------------------------------------------------

--
-- Table structure for table `trongate_tokens`
--

DROP TABLE IF EXISTS `trongate_tokens`;
CREATE TABLE `trongate_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(125) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `expiry_date` int(11) NOT NULL,
  `code` varchar(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trongate_tokens`
--

INSERT INTO `trongate_tokens` (`id`, `token`, `user_id`, `expiry_date`, `code`) VALUES
(285, 'naSg4GUGWqclcNBznoQ4B96FlXTYpzjS', 1, 1555785065, '0');

-- --------------------------------------------------------

--
-- Table structure for table `trongate_users`
--

DROP TABLE IF EXISTS `trongate_users`;
CREATE TABLE `trongate_users` (
  `id` int(11) NOT NULL,
  `code` varchar(32) DEFAULT NULL,
  `user_level_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trongate_users`
--

INSERT INTO `trongate_users` (`id`, `code`, `user_level_id`) VALUES
(1, 'UVsY8ASG5evncc4U6trru2XH5Tbq7MU5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `trongate_user_levels`
--

DROP TABLE IF EXISTS `trongate_user_levels`;
CREATE TABLE `trongate_user_levels` (
  `id` int(11) NOT NULL,
  `level_title` varchar(125) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trongate_user_levels`
--

INSERT INTO `trongate_user_levels` (`id`, `level_title`) VALUES
(1, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `query_mem`
--
ALTER TABLE `query_mem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trongate_tokens`
--
ALTER TABLE `trongate_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trongate_users`
--
ALTER TABLE `trongate_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trongate_user_levels`
--
ALTER TABLE `trongate_user_levels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `query_mem`
--
ALTER TABLE `query_mem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT for table `trongate_tokens`
--
ALTER TABLE `trongate_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT for table `trongate_users`
--
ALTER TABLE `trongate_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trongate_user_levels`
--
ALTER TABLE `trongate_user_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
