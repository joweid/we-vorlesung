-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Dez 2022 um 20:23
-- Server-Version: 10.4.25-MariaDB
-- PHP-Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `todoliste`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `aufgaben`
--

CREATE TABLE `aufgaben` (
  `id` int(10) NOT NULL,
  `name` varchar(80) NOT NULL,
  `beschreibung` varchar(200) NOT NULL,
  `erstellungsdatum` date NOT NULL,
  `faelligkeitsdatum` date NOT NULL,
  `ersteller` int(10) NOT NULL,
  `reiter` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `aufgaben`
--

INSERT INTO `aufgaben` (`id`, `name`, `beschreibung`, `erstellungsdatum`, `faelligkeitsdatum`, `ersteller`, `reiter`) VALUES
(1, 'HTML Dokument erstellen', 'HTML Dokument erstellen', '2022-12-10', '2022-12-12', 2, 1),
(2, 'CSS Dokument erstellen', 'CSS Dokument erstellen', '2022-12-11', '2022-12-13', 3, 1),
(3, 'Kaffee kochen', 'Kaffee kochen', '2022-12-14', '2022-12-14', 2, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `hat_aufgabe`
--

CREATE TABLE `hat_aufgabe` (
  `mitglied` int(10) NOT NULL,
  `aufgabe` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `hat_projekt`
--

CREATE TABLE `hat_projekt` (
  `mitglied` int(10) NOT NULL,
  `projekt` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mitglieder`
--

CREATE TABLE `mitglieder` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwort` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `mitglieder`
--

INSERT INTO `mitglieder` (`id`, `username`, `email`, `passwort`) VALUES
(1, 'Max Mustermann', 'max-mustermann@gmail.com', 'muster-passwort'),
(2, 'Erika Müller', 'erika-mülelr@web.de', '123456'),
(3, 'Quentin Tarantino', 'quentin-tarantino@hollywood.us', 'django');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `projekte`
--

CREATE TABLE `projekte` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `beschreibung` varchar(200) NOT NULL,
  `ersteller` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reiter`
--

CREATE TABLE `reiter` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `beschreibung` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `reiter`
--

INSERT INTO `reiter` (`id`, `name`, `beschreibung`) VALUES
(1, 'ToDo', 'Dinge, die erledigt werden müssen'),
(2, 'Erledigt', 'Dinge, die erledigt worden sind'),
(3, 'Verschoben', 'Dinge, die später erledigt werden');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `aufgaben`
--
ALTER TABLE `aufgaben`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ersteller` (`ersteller`),
  ADD KEY `reiter` (`reiter`);

--
-- Indizes für die Tabelle `hat_aufgabe`
--
ALTER TABLE `hat_aufgabe`
  ADD KEY `mitglied` (`mitglied`),
  ADD KEY `aufgabe` (`aufgabe`);

--
-- Indizes für die Tabelle `hat_projekt`
--
ALTER TABLE `hat_projekt`
  ADD KEY `mitglied` (`mitglied`),
  ADD KEY `projekt` (`projekt`);

--
-- Indizes für die Tabelle `mitglieder`
--
ALTER TABLE `mitglieder`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `projekte`
--
ALTER TABLE `projekte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ersteller` (`ersteller`);

--
-- Indizes für die Tabelle `reiter`
--
ALTER TABLE `reiter`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `aufgaben`
--
ALTER TABLE `aufgaben`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `mitglieder`
--
ALTER TABLE `mitglieder`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `projekte`
--
ALTER TABLE `projekte`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `reiter`
--
ALTER TABLE `reiter`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `aufgaben`
--
ALTER TABLE `aufgaben`
  ADD CONSTRAINT `aufgaben_ibfk_1` FOREIGN KEY (`ersteller`) REFERENCES `mitglieder` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `aufgaben_ibfk_2` FOREIGN KEY (`reiter`) REFERENCES `reiter` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints der Tabelle `hat_aufgabe`
--
ALTER TABLE `hat_aufgabe`
  ADD CONSTRAINT `hat_aufgabe_ibfk_1` FOREIGN KEY (`mitglied`) REFERENCES `mitglieder` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hat_aufgabe_ibfk_2` FOREIGN KEY (`aufgabe`) REFERENCES `aufgaben` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `hat_projekt`
--
ALTER TABLE `hat_projekt`
  ADD CONSTRAINT `hat_projekt_ibfk_1` FOREIGN KEY (`mitglied`) REFERENCES `mitglieder` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hat_projekt_ibfk_2` FOREIGN KEY (`projekt`) REFERENCES `projekte` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `projekte`
--
ALTER TABLE `projekte`
  ADD CONSTRAINT `projekte_ibfk_1` FOREIGN KEY (`ersteller`) REFERENCES `mitglieder` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
