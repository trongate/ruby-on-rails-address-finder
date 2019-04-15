-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 15, 2019 at 12:03 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `trongate_framework_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `date_created`) VALUES
(1, 'Here is a comment.', 1555296906),
(2, 'Here is a second comment.', 1555296914),
(3, 'Third one.', 1555296921),
(4, 'Here we go again.', 1555296929);

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

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
(8, NULL, 'asdfasdfd', 'david.webguy@gmail.com', 'asdfdf', '3.00', 1555211412, 1555211412, 1);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

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
-- Table structure for table `trongate_tokens`
--

CREATE TABLE `trongate_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `information` text NOT NULL,
  `expiry_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trongate_tokens`
--

INSERT INTO `trongate_tokens` (`id`, `token`, `information`, `expiry_date`) VALUES
(4, 'riZ5&uCprQgpaiAgt)QLf(kRO.Rpn&ucsX!SRYS0@91Si(lTU&19VuqTRZLFb2Wo', '{\"tables\":{\"comments\":\"*\"}}', 1555297469),
(5, 'kaM,HU}cVqH6jT@q8Z!Zte.v5tdsUT{yM5]e[5SE(1@v3,8]XJL%CN7MEy1dK.Z}', '{\"tables\":{\"comments\":\"*\"}}', 1555297542),
(6, 'c4UVsSZ9(*O7slqeZN@1&@{2{6Y*@JPUC!%K0VxNjFYlmwu(m%HUnyi%AWNzENtV', '{\"tables\":{\"comments\":\"*\"}}', 1555297752),
(7, '&]9YChRu%ezPYTl)iUrnDPlN3K!MHLKV.KaTDY.k2U,.zK@2mlk!BbfaoCqdG&P*', '{\"tables\":{\"comments\":\"*\"}}', 1555297815),
(8, 'STLqmlJbri6(RtBoPsHgsu88j6iQ{*53NWd{qOrdE}zs0NUfqbNVIyUpBA6qjG&j', '{\"tables\":{\"comments\":\"*\"}}', 1555297845),
(9, 'NZUo{EP%Qjr9{DGcpzcK)hFcb!xrUb,LPZ(.c[k(}qxlJw&9X1LRU@]f)HCm3n4T', '{\"tables\":{\"comments\":\"*\"}}', 1555297860),
(10, 'Gf]wL1rc2@KgF[h!w&EJYAIlSyjo!H}UMvVX@KvotjBcx1a%)Da9s8%S1V,u1e3x', '{\"tables\":{\"comments\":\"*\"}}', 1555297984),
(11, '9%Ejk6gho!M%OrnX,@RZzrfoXb[&QinhAdgUjQyz1l&bmHxq2VA9nxbNq[iSc{76', '{\"tables\":{\"comments\":\"*\"}}', 1555298193),
(12, 'gjvx57P.xfnXZRjRfYeNKs3QVBgW3W[FZusvSru6%r[1F5F{FYSx)(G2rNj7wqaC', '{\"tables\":{\"comments\":\"*\"}}', 1555298261),
(13, 'jaBUIoR0Z2O}X26TT5KK!rBctkPDlH(ftmTK.NMo3wxK]Rv&23A7&x[91[z4P*ib', '{\"tables\":{\"comments\":\"*\"}}', 1555298278),
(14, 'nJFz2T@XWxLG&5&y&AX@}14IzqE*IAMkQsJ9jV6AKWuqQH@]TJo2szE@l8&(K&W7', '{\"tables\":{\"comments\":\"*\"}}', 1555298341),
(15, 'Qyq%E(OqA.ea{xTK0lIs%WE@HIIwc]ukDzsNHC@}[Yq,V*69{bLd33}%d(IGnpU}', '{\"tables\":{\"comments\":\"*\"}}', 1555298348),
(16, '!KBLUeOvY1wg%0!dRh2}dRq,z.jR6AKhw,2oaF89gT680N{&9d!9FX)jHr0KMsG}', '{\"tables\":{\"comments\":\"*\"}}', 1555298400),
(17, 'zqRUY[hH1Bl1Ww0zXH}CFOp}a].*aT%25JBcXKz1LK&fQG&Sl!@PDr6x1s(9sO{g', '{\"tables\":{\"comments\":\"*\"}}', 1555298409),
(18, '*RhTvK*eLY58OnrrHqNTxk6Rrfjsa1qOmtyOuZS6yo!ToABY&hjg%[TmoK]}FYb!', '{\"tables\":{\"comments\":\"*\"}}', 1555298429),
(19, 'k13d[{9{Xoq02,B&R(tm{UN)@7AStawoPnO64GJpD.,VeqcO.)uW1nUxu(nJtKTj', '{\"tables\":{\"comments\":\"*\"}}', 1555298525),
(20, 'TY8Mq7S{)8c@e.Kf@PYN(Ab30fYr}Xy(U00efpnH6WokJKb98ACv47hxS!%a,1XW', '{\"tables\":{\"comments\":\"*\"}}', 1555298551),
(21, 'BI0(CX%99U[u@9nNaC1PV(hRQrnln8)AZBOHaoeW%[Kw5{WfR(*BC]L**vgodv!&', '{\"tables\":{\"comments\":\"*\"}}', 1555298553),
(22, '6qa0wxlHOSk6foz0upJL}CHyU8HiaqFklCMP2Rm1(b(tu.WlyLhtvVNH0K2L1TzY', '{\"tables\":{\"comments\":\"*\"}}', 1555298951),
(23, '[qhBER*esmd*kl2mv)KKjYQjl*sdhmtcOKfmb,TxdPxShe1Bm{,S]BM%TW)[v)9B', '{\"tables\":{\"comments\":\"*\"}}', 1555298956),
(24, '0!00kSmap{M2Q9hNgIcjJySl9QQ[hQf2acKc&up4531V1Vd!z5U,.bDO&RPPqA.F', '{\"tables\":{\"comments\":\"*\"}}', 1555299052),
(25, 'zmKFUX5LXQ2jBEA4Y2yWwlE.fSqq%ite2(nVtQsR@UsZ9hx)5FP,2er8E8sbCoNM', '{\"tables\":{\"comments\":\"*\"}}', 1555299158),
(26, 'Tp%G7UfJiHsWwc29A4ZZ![9Y0{b]lkYk.9er]TVvLnvqtNv}OSnMIoeZwodF4lZy', '{\"tables\":{\"comments\":\"*\"}}', 1555299185),
(27, 'd%dt34QwVTBd1r0kmZ]]On.Q4SE9yhWmhWrjzOk,L8zg52oBTEaO(3.kuYizNtSi', '{\"tables\":{\"comments\":\"*\"}}', 1555299201),
(28, 'COcsGRdZ2KTMvbYNbTalan*wE8qCuE.%,Z@)@hSuz0vB4bw!vGcPP*llJU0ecwxg', '{\"tables\":{\"comments\":\"*\"}}', 1555299208),
(29, ')hWdD,ZSx*s(Gp(s]dBhYEgOh5VLH7IAyQlTok{@}4u.!haRkuBzWr0bbi1eFGmw', '{\"tables\":{\"comments\":\"*\"}}', 1555299224),
(30, 'gJkCB&CRTK@gQV,XHjni.o{uqNsk1oBodlUMqj*)&mQ@}H9}.j!o87)kRfE{3GUy', '{\"tables\":{\"comments\":\"*\"}}', 1555299241),
(31, '.X.MM5ndNMMjXbk0&vNXUNE*XQ8jAXQ52%[R&bDdmiYY1dF!to4PbLgLX%nWX94t', '{\"tables\":{\"comments\":\"*\"}}', 1555299260),
(32, '[4kk@(P8,e43S[.}dTzMWjaDI(ev@y}mI7{%i,sKnZ,y}MAWc.26APmuL@R1Kwvf', '{\"tables\":{\"comments\":\"*\"}}', 1555299267),
(33, 'r]]K3rfjJ{)uQwFsFzkCA,3H,)n6zP}b5fAmayQjy0.o(J0LKx&G.(Z2xNn3v8uc', '{\"tables\":{\"comments\":\"*\"}}', 1555299290),
(34, 'hsozCfp0bZSH6MNB)gHO,Ts@{pBo}XC)rfxwMdcCQfAO2CPktE@ou5E53JGpo0EQ', '{\"tables\":{\"comments\":\"*\"}}', 1555300473),
(35, 'c7DA.*h}[3so6hfmIEVA0@%x)bzX]o*1a7MQzZu@O%{U8ALf(V2MUzk[42B(}nxM', '{\"tables\":{\"comments\":\"*\"}}', 1555300490),
(36, '9,,aVTtrgsw&Us%da(debDeT58Zy6qos)1s20eVR*ZyitI(elEAX5NnOM86Y6lQ1', '{\"tables\":{\"comments\":\"*\"}}', 1555300548),
(37, 'D6)JI08tMdUyq{H4wNk,*vayg80YMk](s]e9DnwUwm2&*H9.!})NjBzB(,M(mG)c', '{\"tables\":{\"comments\":\"*\"}}', 1555300556),
(38, 'XRXIK[!JkMalOQMojFBna4{h8WlGsk]BrcqY!x.tom&rdu&UZm{K{7ziO%b]m)TI', '{\"tables\":{\"comments\":\"*\"}}', 1555300578),
(39, 'Oqo]yR}VBX1@*B2%IU@k!Yo(!5JIFRWDEptuSkiG7jIHByW(Dw0npMMDh!QIdrjK', '{\"tables\":{\"comments\":\"*\"}}', 1555300869);

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
-- Indexes for table `trongate_tokens`
--
ALTER TABLE `trongate_tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trongate_tokens`
--
ALTER TABLE `trongate_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
