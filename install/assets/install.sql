SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE IF NOT EXISTS `ci_sessions` (
    `session_id` varchar(255) NOT NULL,
    `ip_address` varchar(255) NOT NULL,
    `user_agent` varchar(255) NOT NULL,
    `last_activity` varchar(255) NOT NULL,
    `user_data` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `clienti` (
    `id` int(4) NOT NULL,
    `nome` varchar(50) CHARACTER SET latin1 NOT NULL,
    `cognome` varchar(50) CHARACTER SET latin1 NOT NULL,
    `telefono` varchar(28) CHARACTER SET latin1 NOT NULL,
    `indirizzo` varchar(50) CHARACTER SET latin1 NOT NULL,
    `citta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `email` varchar(50) CHARACTER SET latin1 NOT NULL,
    `vat` varchar(60) CHARACTER SET latin1 NOT NULL,
    `cf` varchar(60) CHARACTER SET latin1 NOT NULL,
    `data` date NOT NULL,
    `commenti` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `clienti` (`id`, `nome`, `cognome`, `telefono`, `indirizzo`, `citta`, `email`, `vat`, `cf`, `data`, `commenti`) VALUES
(1, 'John', 'Doe', '0000000000', '490 E South Orlando, FL', 'Orlando', 'email@provider.com', 'VAT', 'NIN', '2015-07-28', 'This is one comment');


CREATE TABLE IF NOT EXISTS `impostazioni` (
    `id` int(4) NOT NULL,
    `titolo` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `lingua` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `showcredit` int(11) NOT NULL,
    `disclaimer` varchar(370) COLLATE utf8_unicode_ci NOT NULL,
    `skebby_user` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `skebby_pass` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `skebby_name` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `skebby_method` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `admin_user` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
    `admin_password` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
    `valuta` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `indirizzo` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
    `invoice_mail` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
    `telefono` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
    `vat` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `invoice_type` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `tax` decimal(30,0) NOT NULL,
    `invoice_name` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `categorie` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
    `twilio_mode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
    `twilio_account_sid` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
    `twilio_auth_token` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
    `twilio_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
    `prefix_number` int(5) NOT NULL,
    `usesms` int(2) NOT NULL,
    `r_apertura` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
    `r_chiusura` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
    `colore1` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `colore2` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `colore3` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `colore4` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `colore5` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `colore_prim` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
    `logo` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
    `campi_personalizzati` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
    `stampadue` int(2) NOT NULL,
    `numc` int(11) NOT NULL,
    `currency_symbol` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `currency_text` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `currency_position` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `printinonepage` int(11) NOT NULL,
    `rtl_support` int(11) NOT NULL,
    `email_sender` text COLLATE utf8_unicode_ci NOT NULL,
    `email_subject` text COLLATE utf8_unicode_ci NOT NULL,
    `email_use_smtp` int(11) NOT NULL,
    `email_smtp_host` text COLLATE utf8_unicode_ci NOT NULL,
    `email_smtp_user` text COLLATE utf8_unicode_ci NOT NULL,
    `email_smtp_pass` text COLLATE utf8_unicode_ci NOT NULL,
    `email_smtp_port` text COLLATE utf8_unicode_ci NOT NULL,
    `email_smtp_open_text` longtext COLLATE utf8_unicode_ci NOT NULL,
    `email_smtp_closed_text` longtext COLLATE utf8_unicode_ci NOT NULL,
    `background_transition` text COLLATE utf8_unicode_ci,
    `timezone` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `impostazioni` (`id`, `titolo`, `lingua`, `showcredit`, `disclaimer`, `skebby_user`, `skebby_pass`, `skebby_name`, `skebby_method`, `admin_user`, `admin_password`, `valuta`, `indirizzo`, `invoice_mail`, `telefono`, `vat`, `invoice_type`, `tax`, `invoice_name`, `categorie`, `twilio_mode`, `twilio_account_sid`, `twilio_auth_token`, `twilio_number`, `prefix_number`, `usesms`, `r_apertura`, `r_chiusura`, `colore1`, `colore2`, `colore3`, `colore4`, `colore5`, `colore_prim`, `logo`, `campi_personalizzati`, `stampadue`, `numc`, `currency_symbol`, `currency_text`, `currency_position`, `printinonepage`, `rtl_support`, `email_sender`, `email_subject`, `email_use_smtp`, `email_smtp_host`, `email_smtp_user`, `email_smtp_pass`, `email_smtp_port`, `email_smtp_open_text`, `email_smtp_closed_text`, `background_transition`, `timezone`) VALUES
(1, 'YourBusinessName', 'english', 0, 'Insert here your disclaimer. (Visible on invoice footer)', '', '', '', '', 'demo@demo.com', 'demo', 'Euro', 'Your complete address', 'yourbusiness@mail.com', '(39)0000000000', '##00000000000', 'EU', '7', 'Name Surname', 'Computer\r\nSmartphone', 'prod', '', '', '', 39, 2, 'Hello %customer%, your order/repair for %model% was opened by %businessname%. Check the state of repair on %fixbookurl%.\nStatus code: (%statuscode%)', 'Hello %customer%, your order/repair fo %model% has been completed, come to %businessname% for take it. Thanks for choosing us.', '#3dc45b', '#f27705', '#a8a8a8', '#d61a1a', '#2b2b2b', '#08a4cc', 'logo_nav.png?13', 'YToyOntpOjA7czo0OiJJTUVJIjtpOjE7czo2OiJDdXN0b20iO30=', 1, 0, '', '', 'left', 0, 0, '', '', 0, '', '', '', '', 'Hello %customer%, your order/repair for %model% was opened by %businessname%. Check the state of repair on %fixbookurl%.Status code: (%statuscode%)', 'Hello %customer%, your order/repair fo %model% has been completed, come to %businessname% for take it. Thanks for choosing us.', '0', 'Pacific/Midway');


CREATE TABLE IF NOT EXISTS `oggetti` (
    `ID` int(255) NOT NULL,
    `Nominativo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `ID_Nominativo` int(11) NOT NULL,
    `Telefono` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `sms` int(1) NOT NULL DEFAULT '0',
    `Tipo` int(1) NOT NULL,
    `Guasto` mediumtext COLLATE utf8_unicode_ci NOT NULL,
    `Categoria` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `Modello` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `Pezzo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `Anticipo` int(11) NOT NULL,
    `Prezzo` int(255) NOT NULL,
    `dataApertura` datetime NOT NULL,
    `dataChiusura` datetime DEFAULT NULL,
    `status` int(1) NOT NULL DEFAULT '3',
    `Commenti` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
    `codice` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
    `custom_field` longtext COLLATE utf8_unicode_ci NOT NULL,
    `send_email` int(11) NOT NULL,
    `email` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



ALTER TABLE `ci_sessions`
 ADD PRIMARY KEY (`session_id`);

ALTER TABLE `clienti`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `impostazioni`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `oggetti`
 ADD PRIMARY KEY (`ID`);

ALTER TABLE `clienti`
MODIFY `id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;

ALTER TABLE `impostazioni`
MODIFY `id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

ALTER TABLE `oggetti`
MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;

/* NEW FIELDS */
ALTER TABLE `impostazioni` ADD `background_transition` TEXT NULL;
UPDATE `impostazioni` SET `background_transition` = 'false' WHERE `impostazioni`.`id` = 1;
ALTER TABLE `impostazioni` ADD `timezone` TEXT NULL ;

ALTER TABLE `oggetti` CHANGE `Anticipo` `Anticipo` DECIMAL(10,2) NOT NULL;
ALTER TABLE `oggetti` CHANGE `Prezzo` `Prezzo` DECIMAL(10,2) NOT NULL;
