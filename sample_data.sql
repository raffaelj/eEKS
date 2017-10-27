

CREATE TABLE IF NOT EXISTS `accounting` (
`ID` int(10) unsigned NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_last_changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `value_date` date DEFAULT NULL,
  `voucher_date` date DEFAULT NULL,
  `gross_amount` decimal(11,2) DEFAULT NULL,
  `tax_rate` decimal(3,2) DEFAULT NULL,
  `account` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `posting_text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_of_costs` int(4) unsigned DEFAULT NULL,
  `mode_of_employment` int(4) unsigned DEFAULT NULL,
  `cat_01` int(4) unsigned DEFAULT NULL,
  `cat_02` int(4) unsigned DEFAULT NULL,
  `cat_03` int(4) unsigned DEFAULT NULL,
  `cat_04` int(4) unsigned DEFAULT NULL,
  `cat_05` int(4) unsigned DEFAULT NULL,
  `notes_01` text COLLATE utf8_unicode_ci,
  `notes_02` text COLLATE utf8_unicode_ci,
  `notes_03` text COLLATE utf8_unicode_ci,
  `notes_04` text COLLATE utf8_unicode_ci,
  `notes_05` text COLLATE utf8_unicode_ci,
  `file_01` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_02` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_03` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `accounting` (`ID`, `date_created`, `date_last_changed`, `value_date`, `voucher_date`, `gross_amount`, `tax_rate`, `account`, `invoice_number`, `from_to`, `posting_text`, `object`, `type_of_costs`, `mode_of_employment`, `cat_01`, `cat_02`, `cat_03`, `cat_04`, `cat_05`, `notes_01`, `notes_02`, `notes_03`, `notes_04`, `notes_05`, `file_01`, `file_02`, `file_03`) VALUES
(1, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2016-06-15', '2016-06-29', '150.00', NULL, 'Girokonto', '16011', 'Barbara Baldrian', NULL, 'Website-Erstellung Nachbesserungen', 15, 1, 4, NULL, NULL, NULL, NULL, 'in Raten überwiesen', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '2017-10-20 19:56:05', '2017-10-27 11:55:12', NULL, '2016-06-29', '1000.00', NULL, 'Girokonto', '17009', 'Max Mustermann', NULL, 'Website-Erstellung', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2016-07-27', '2016-06-29', '350.00', NULL, 'Girokonto', '16011', 'Barbara Baldrian', NULL, 'Website-Erstellung Nachbesserungen', 15, 1, 4, NULL, NULL, NULL, NULL, 'in Raten überwiesen', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2016-08-21', '2016-08-19', '200.00', NULL, 'Girokonto', '16012', 'Computer und Medien e. V.', NULL, 'Sommerferienkurse', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2016-11-05', '2016-11-07', '90.00', NULL, 'Barkasse', '16013', 'Felix Flattermann', NULL, '3h HTML-Einzelunterricht', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2016-11-25', '2016-11-07', '50.00', NULL, 'Girokonto', '16014', 'Stadt Leipzig, Justus-Jonas-Schule', NULL, '2h Tanz-Workshop (Projektwoche)', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '2017-10-20 19:56:05', '2017-10-27 10:15:39', '2016-11-10', '2016-11-07', '250.00', NULL, 'Girokonto', '16015', 'Computer und Medien e. V.', NULL, 'Herbstferienkurse', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2016-10-06', '2016-10-02', '180.00', NULL, 'Girokonto', '16016', 'Computer und Medien e. V.', NULL, 'HTML-Kurse Aug-Sept 2016', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2017-02-01', '2016-11-09', '24.00', NULL, 'Girokonto', '16017', 'Moritz Moster', NULL, '1h HTML-Einzelunterricht', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2016-11-21', '2016-11-18', '450.00', NULL, 'Girokonto', '16018', 'Bernd Hölle', NULL, 'Logo-Vektorisierung, Website-Änderungen', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '2017-10-20 19:56:05', '2017-10-27 10:19:04', '2016-11-27', '2016-12-01', '100.00', NULL, 'Barkasse', '16019', 'Verein meiner Freunde e. V.', NULL, 'Auftritt zur Weihnachtsfeier', 15, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2016-12-05', '2016-12-01', '90.00', NULL, 'Girokonto', '16020', 'Computer und Medien e. V.', NULL, 'HTML-Kurse Nov 2016', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2016-12-05', '2016-12-01', '300.00', NULL, 'Girokonto', '16021', 'Computer und Medien e. V.', NULL, 'Projekttag (Planung und Durchführung)', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2017-01-16', '2017-01-16', '30.00', NULL, 'Barkasse', '17001', 'Verein meiner Freunde e. V.', NULL, '1h Tanz-Workshop', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2017-02-01', '2017-01-25', '24.00', NULL, 'Girokonto', '17002', 'Moritz Moster', NULL, '1h HTML-Einzelunterricht', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2017-03-04', '2017-02-20', '40.00', NULL, 'Girokonto', '17003', 'Bernd-Boxhorn-Schule', NULL, '2h Tanz-Workshop im Sportunterricht', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2017-02-23', '2017-02-20', '145.00', NULL, 'Girokonto', '17004', 'Computer und Medien e. V.', NULL, 'Winterferienkurse', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2017-03-30', '2017-03-15', '150.00', NULL, 'Girokonto', '17005', 'Computer und Medien e. V.', NULL, 'Workshop Projekttag Plakatgestaltung', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2017-04-12', '2017-04-07', '200.00', NULL, 'Girokonto', '17006', 'Computer und Medien e. V.', NULL, 'Weiterbildung Wordpress', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2017-04-21', '2017-04-02', '300.00', NULL, 'Girokonto', '17007', 'Einhornladen', NULL, 'Umzug d. Onlineshops auf neuen Server', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '2017-10-20 19:56:05', '2017-10-27 11:31:46', '2016-08-30', '2016-08-27', '-6.44', NULL, 'Girokonto', NULL, 'Github', NULL, 'Webhosting (7$)', 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, '2017-10-20 19:56:05', '2017-10-27 11:31:46', '2016-09-29', '2016-09-27', '-6.43', NULL, 'Girokonto', NULL, 'Github', NULL, 'Webhosting (7$)', 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '2017-10-20 19:56:05', '2017-10-27 11:31:46', '2016-10-31', '2016-10-27', '-6.63', NULL, 'Girokonto', NULL, 'Github', NULL, 'Webhosting (7$)', 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '2017-10-20 19:56:05', '2017-10-27 11:28:12', '2016-11-29', '2016-11-27', '-6.82', NULL, 'Girokonto', NULL, 'Github', NULL, 'Webhosting (7$)', 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '2017-10-20 19:56:05', '2017-10-27 11:31:46', '2016-12-29', '2016-12-27', '-6.92', NULL, 'Girokonto', NULL, 'Github', NULL, 'Webhosting (7$)', 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, '2017-10-20 19:56:05', '2017-10-27 11:31:46', '2017-01-31', '2017-01-27', '-6.77', NULL, 'Girokonto', NULL, 'Github', NULL, 'Webhosting (7$)', 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '2017-10-20 19:56:05', '2017-10-27 11:31:46', '2017-03-06', '2017-02-27', '-6.85', NULL, 'Girokonto', NULL, 'Github', NULL, 'Webhosting (7$)', 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, '2017-10-20 19:56:05', '2017-10-27 11:31:46', '2017-03-29', '2017-03-27', '-6.67', NULL, 'Girokonto', NULL, 'Github', NULL, 'Webhosting (7$)', 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, '2017-10-20 19:56:05', '2017-10-27 11:31:46', '2017-05-02', '2017-04-27', '-6.64', NULL, 'Girokonto', NULL, 'Github', NULL, 'Webhosting (7$)', 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, '2017-10-20 19:56:05', '2017-10-27 12:14:47', '2017-01-08', '2017-01-05', '-36.19', NULL, 'Girokonto', NULL, 'Druckerei um die Ecke', NULL, 'Flyer-Druck', 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, '2017-10-20 19:56:05', '2017-10-27 10:35:41', '2016-09-02', '2016-08-22', '-14.95', NULL, 'Girokonto', NULL, 'CO2 (Telekonika)', NULL, 'Telefon, Internet (anteilig 50% v. 29,90 €)', 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, '2017-10-20 19:56:05', '2017-10-27 10:35:41', '2016-10-04', '2016-09-23', '-14.95', NULL, 'Girokonto', NULL, 'CO2 (Telekonika)', NULL, 'Telefon, Internet (anteilig 50% v. 29,90 €)', 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, '2017-10-20 19:56:05', '2017-10-27 10:35:41', '2016-11-03', '2016-10-25', '-14.95', NULL, 'Girokonto', NULL, 'CO2 (Telekonika)', NULL, 'Telefon, Internet (anteilig 50% v. 29,90 €)', 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, '2017-10-20 19:56:05', '2017-10-27 10:35:41', '2016-12-05', '2016-11-22', '-14.95', NULL, 'Girokonto', NULL, 'CO2 (Telekonika)', NULL, 'Telefon, Internet (anteilig 50% v. 29,90 €)', 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, '2017-10-20 19:56:05', '2017-10-27 10:35:41', '2017-01-02', '2016-12-21', '-14.95', NULL, 'Girokonto', NULL, 'CO2 (Telekonika)', NULL, 'Telefon, Internet (anteilig 50% v. 29,90 €)', 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, '2017-10-20 19:56:05', '2017-10-27 12:46:38', '2017-02-03', '2017-01-26', '-14.95', NULL, 'Girokonto', NULL, 'CO2 (Telekonika)', NULL, 'Telefon, Internet (anteilig 50% v. 29,90 €)', 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, '2017-10-20 19:56:05', '2017-10-27 12:46:38', '2017-03-06', '2017-03-01', '-14.95', NULL, 'Girokonto', NULL, 'CO2 (Telekonika)', NULL, 'Telefon, Internet (anteilig 50% v. 29,90 €)', 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, '2017-10-20 19:56:05', '2017-10-27 12:46:56', '2017-04-03', '2017-03-22', '-14.95', NULL, 'Girokonto', NULL, 'CO2 (Telekonika)', NULL, 'Telefon, Internet (anteilig 50% v. 29,90 €)', 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, '2017-10-20 19:56:05', '2017-10-27 12:46:56', '2017-05-04', '2017-04-25', '-14.95', NULL, 'Girokonto', NULL, 'CO2 (Telekonika)', NULL, 'Telefon, Internet (anteilig 50% v. 29,90 €)', 9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, '2017-10-20 19:56:05', '2017-10-27 11:55:12', '2017-05-23', '2017-05-10', '24.00', NULL, 'Girokonto', '17008', 'Moritz Moster', NULL, '1h HTML-Einzelunterricht', 15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, '2017-10-20 19:56:05', '2017-10-27 12:14:47', '2016-12-02', '2016-12-02', '-35.99', NULL, 'Barkasse', NULL, 'Elektronikladen  E. Erbsmann', NULL, 'SVGA-Kabel 10m', 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, 'ja', NULL, NULL, NULL, NULL, NULL, NULL),
(46, '2017-10-20 19:56:05', '2017-10-27 12:14:47', '2016-11-16', '2016-11-15', '-9.54', NULL, 'Girokonto', NULL, 'LABEL-Markt', NULL, 'Deko-Klebeband', 3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, '2017-10-20 19:56:05', '2017-10-27 12:14:47', '2016-11-22', '2016-11-15', '-250.98', NULL, 'Girokonto', NULL, 'Engel-Musik GmbH', NULL, 'portable Musikanlage', 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, '10 Jahre, außer auf Akku', NULL, NULL, NULL, NULL, NULL, NULL),
(49, '2017-10-20 19:56:05', '2017-10-27 12:14:47', '2016-11-02', '2016-11-01', '-55.99', NULL, 'Girokonto', NULL, 'Schumi Schuhmarkt', NULL, 'Schuhe und Schuhpflege', 22, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'ja', NULL, NULL, NULL, NULL, NULL, NULL),
(50, '2017-10-20 19:56:05', '2017-10-27 12:14:47', '2016-08-16', '2016-08-12', '-19.99', NULL, 'Girokonto', NULL, 'LEBE-Markt', NULL, 'Kochtopf', 12, 2, NULL, NULL, NULL, NULL, NULL, NULL, 'ja', NULL, NULL, NULL, NULL, NULL, NULL),
(51, '2017-10-20 19:56:05', '2017-10-27 12:14:47', '2016-09-02', '2016-09-01', '-95.90', NULL, 'Girokonto', NULL, 'Elektronikmarkt El&Tron', NULL, 'Staubsauger', 12, 2, NULL, NULL, NULL, NULL, NULL, NULL, 'ja', NULL, NULL, NULL, NULL, NULL, NULL),
(52, '2017-10-20 19:56:05', '2017-10-27 12:14:47', '2017-01-20', '2017-01-20', '-6.99', NULL, 'Barkasse', NULL, 'LEBE-Markt', NULL, 'Arbeitshandschuhe', 22, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'ja', NULL, NULL, NULL, NULL, NULL, NULL),
(53, '2017-10-20 19:56:05', '2017-10-27 12:14:47', '2017-04-06', '2017-04-05', '-16.99', NULL, 'Girokonto', NULL, 'LABEL-Markt', NULL, 'Haartrockner', 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, 'ja', NULL, NULL, NULL, NULL, NULL, NULL),
(54, '2017-10-20 19:56:05', '2017-10-27 12:14:47', '2017-04-24', '2017-04-24', '-47.97', NULL, 'Barkasse', NULL, 'Opi-Baumarkt', NULL, 'Verteilerdosen, Regal', 12, 2, NULL, NULL, NULL, NULL, NULL, NULL, 'ja', NULL, NULL, NULL, NULL, NULL, NULL),
(55, '2017-10-20 19:56:05', '2017-10-27 12:48:38', '2017-04-24', '2017-04-24', '-8.99', NULL, 'Barkasse', NULL, 'LEBE-Markt', NULL, 'Thermoskanne', 12, 2, NULL, NULL, NULL, NULL, NULL, NULL, 'ja', NULL, NULL, NULL, NULL, NULL, NULL),
(56, '2017-10-20 19:56:05', '2017-10-27 12:14:47', NULL, '2017-05-09', '-37.98', '0.00', 'Girokonto', NULL, 'Kleidungsladen', NULL, 'Hemd, Krawatte', 22, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'ja', NULL, NULL, NULL, NULL, NULL, NULL),
(57, '2017-10-20 19:56:05', '2017-10-27 12:14:47', '2017-05-10', '2017-05-09', '-149.99', NULL, 'Girokonto', NULL, 'Haushaltswarenladen', NULL, 'Spezial-Kaffeemaschine', 12, 2, NULL, NULL, NULL, NULL, NULL, NULL, '5 Jahre', NULL, NULL, NULL, NULL, NULL, NULL),
(58, '2017-10-20 19:56:05', '2017-10-27 19:33:15', '2016-11-17', NULL, '-23.42', NULL, 'Girokonto', NULL, 'lowcost-clothing (ebay)', NULL, 'Glitzerunterwäsche', 22, 2, NULL, NULL, NULL, NULL, NULL, 'keine Rechnung, nur E-Mail-Bestätigung', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, '2017-10-20 19:56:05', '2017-10-27 19:33:03', '2016-11-22', NULL, '-5.19', NULL, 'Girokonto', NULL, 'lowqualitiy24 (ebay)', NULL, 'USB-Maus', 12, 2, NULL, NULL, NULL, NULL, NULL, 'keine Rechnung, nur E-Mail-Bestätigung', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, '2017-10-20 19:56:05', '2017-10-27 18:11:09', '2016-11-22', '2016-11-22', '-20.55', NULL, NULL, NULL, 'Good Lack', NULL, 'Farben', 3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

CREATE TABLE IF NOT EXISTS `mode_of_employment` (
`ID` int(11) NOT NULL,
  `mode_of_employment` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(2) unsigned NOT NULL,
  `notes` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `mode_of_employment` (`ID`, `mode_of_employment`, `sort_order`, `notes`) VALUES
(1, 'freiberuflich', 1, ''),
(2, 'privat', 2, ''),
(3, 'gewerblich', 4, ''),
(4, 'sozialversicherungspflichtig', 6, ''),
(5, 'kurzfristig', 5, ''),
(6, 'Aufwandsentschädigung', 3, ''),
(7, 'sonstiges/extern', 7, ''),
(8, 'Test HiHiHo', 0, '');

CREATE TABLE IF NOT EXISTS `type_of_costs` (
`ID` int(10) unsigned NOT NULL,
  `type_of_costs` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_income` tinyint(1) DEFAULT NULL,
  `sort_order` int(2) unsigned DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `type_of_costs` (`ID`, `type_of_costs`, `is_income`, `sort_order`, `notes`) VALUES
(1, 'noch nicht zugeordnet', NULL, NULL, NULL),
(2, 'Büro', NULL, NULL, NULL),
(3, 'Werkstoff', NULL, NULL, NULL),
(4, 'Werkzeug', NULL, NULL, NULL),
(5, 'Werbung', NULL, NULL, NULL),
(6, 'betriebl. Versicherungen', NULL, NULL, NULL),
(7, 'Raummiete', NULL, NULL, NULL),
(8, 'Kontogebühren', NULL, NULL, NULL),
(9, 'Telefon, Internet', NULL, NULL, NULL),
(10, 'Beratungskosten', NULL, NULL, NULL),
(11, 'Reise ÖPNV', NULL, NULL, NULL),
(12, 'Privatkram', NULL, NULL, NULL),
(13, 'Fortbildungskosten', NULL, NULL, NULL),
(14, 'Wareneinkauf', NULL, NULL, NULL),
(15, 'Honorar', 1, 1, NULL),
(16, 'Teilnahmebeiträge', 1, 2, NULL),
(17, 'Aufwandsentschädigung', 1, 4, NULL),
(18, 'Kunstverkauf', 1, 3, NULL),
(19, 'kurzfristig beschäftigt', 1, NULL, NULL),
(20, 'Bewirtungskosten', NULL, NULL, NULL),
(21, 'Honorar (Ausgabe)', NULL, NULL, NULL),
(22, 'Arbeitskleidung', NULL, NULL, NULL),
(23, 'Gehalt', 1, 5, NULL);


ALTER TABLE `accounting`
 ADD PRIMARY KEY (`ID`);

ALTER TABLE `mode_of_employment`
 ADD PRIMARY KEY (`ID`);

ALTER TABLE `type_of_costs`
 ADD PRIMARY KEY (`ID`);


ALTER TABLE `accounting`
MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=62;
ALTER TABLE `mode_of_employment`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
ALTER TABLE `type_of_costs`
MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;