CREATE TABLE IF NOT EXISTS `accounting` (
`ID` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_last_changed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `value_date` date DEFAULT NULL,
  `voucher_date` date DEFAULT NULL,
  `gross_amount` decimal(11,2) DEFAULT NULL,
  `tax_rate` decimal(3,2) DEFAULT NULL,
  `account` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posting_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_of_costs` int(4) unsigned DEFAULT NULL,
  `cat_01` int(4) unsigned DEFAULT NULL,
  `cat_02` int(4) unsigned DEFAULT NULL,
  `cat_03` int(4) unsigned DEFAULT NULL,
  `cat_04` int(4) unsigned DEFAULT NULL,
  `cat_05` int(4) unsigned DEFAULT NULL,
  `cat_06` int(4) unsigned DEFAULT NULL,
  `cat_07` int(4) unsigned DEFAULT NULL,
  `cat_08` int(4) unsigned DEFAULT NULL,
  `cat_09` int(4) unsigned DEFAULT NULL,
  `cat_10` int(4) unsigned DEFAULT NULL,
  `notes_01` text COLLATE utf8mb4_unicode_ci,
  `notes_02` text COLLATE utf8mb4_unicode_ci,
  `notes_03` text COLLATE utf8mb4_unicode_ci,
  `notes_04` text COLLATE utf8mb4_unicode_ci,
  `notes_05` text COLLATE utf8mb4_unicode_ci,
  `file_01` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_02` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_03` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;