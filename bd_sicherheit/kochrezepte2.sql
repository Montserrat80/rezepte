-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 15. Jan 2021 um 10:36
-- Server-Version: 10.4.16-MariaDB
-- PHP-Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `kochrezepte2`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `erneahrungsform`
--

CREATE TABLE `erneahrungsform` (
  `erform_nr` tinyint(2) UNSIGNED NOT NULL,
  `erform_bz` varchar(30) NOT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `erneahrungsform`
--

INSERT INTO `erneahrungsform` (`erform_nr`, `erform_bz`) VALUES
(1, 'Vegan'),
(2, 'Vegetarisch'),
(3, 'Glutenfrei'),
(4, 'Koscher'),
(19, 'Paleo'),
(20, 'Clean Eating'),
(21, 'Low Carb'),
(22, 'Laktosefrei');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `menue_arten`
--

CREATE TABLE `menue_arten` (
  `menueart_nr` tinyint(2) UNSIGNED NOT NULL,
  `menueart_bz` varchar(30) NOT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `menue_arten`
--

INSERT INTO `menue_arten` (`menueart_nr`, `menueart_bz`) VALUES
(1, 'Salate'),
(15, 'Vorspeisen'),
(3, 'Beilagen'),
(4, 'Hauptspeisen'),
(18, 'Dip'),
(7, 'Kuchen'),
(8, 'Desserts'),
(9, 'Gebäck'),
(10, 'Smoothies'),
(11, 'Suppen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezepte`
--

CREATE TABLE `rezepte` (
  `rezepte_nr` int(6) UNSIGNED NOT NULL,
  `bezeichnung` varchar(100) NOT NULL,
  `menueart_nr` tinyint(2) NOT NULL,
  `portionen` tinyint(2) NOT NULL,
  `zubereitung` text NOT NULL,
  `tipp` varchar(500) DEFAULT NULL,
  `schwstufe_nr` tinyint(2) NOT NULL,
  `arbeitzeit` smallint(3) NOT NULL,
  `kcal` smallint(3) NOT NULL,
  `eiweiss` decimal(4,2) NOT NULL,
  `fett` decimal(4,2) NOT NULL,
  `kohlenhydrate` decimal(4,2) NOT NULL,
  `bild` varchar(100) DEFAULT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `rezepte`
--

INSERT INTO `rezepte` (`rezepte_nr`, `bezeichnung`, `menueart_nr`, `portionen`, `zubereitung`, `tipp`, `schwstufe_nr`, `arbeitzeit`, `kcal`, `eiweiss`, `fett`, `kohlenhydrate`, `bild`) VALUES
(1, 'Rosenkohl aus dem Ofen', 4, 4, 'Den Backofen auf 200 °C Ober-/Unterhitze vorheizen.\r\n\r\nRosenkohl, in etwas Salzwasser al dente gekocht, Kochsud aufbewahrt.\r\n\r\nIn eine Auflaufform den al dent gekochten Rosenkohl mit den Zwiebeln und dem Schinken füllen und alles ein wenig vermischen.\r\n\r\nDie Sahne mit den Eiern, dem geriebenen Emmentaler (davon ein wenig zum späteren Bestreuen aufbewahren) und mit einem Teil des Rosenkohlkochsuds mischen. Mit Salz, Pfeffer und Chiliflocken würzen und über die Mischung in der Auflaufform geben. Wenn ein paar Rosenkohlröschen nicht von der Sauce bedeckt sind, ist das kein Problem, wenn es viele sein sollten, gibt man einfach noch etwas vom Gemüsesud dazu. Den übrig behaltenen Käse darüber streuen und die Form für ca. 50 Minuten in den Backofen geben.\r\n\r\nWenn der Auflauf schön gebräunt ist, aus dem Ofen nehmen.', 'Dazu passen am besten Salzkartoffeln oder Pellkartoffeln. ', 2, 90, 516, '43.07', '33.13', '11.91', '5fd22d592f2f3.jpg'),
(3, 'Rosenkohl in Currysauce', 3, 6, 'Rosenkohl putzen, waschen und in kochendem Salzwasser ca. 15 - 20 Min. garen.\r\n\r\nButter in einem Topf zerlassen, Mehl und Currypulver darin kurz anschwitzen und mit Brühe ablöschen. Crème fraîche zugeben, aufkochen lassen und die Sauce mit Zitronensaft, Salz, Pfeffer und einer Prise Zucker abschmecken. 5 Minuten kochen lassen. Den Apfel waschen, würfeln und zusammen mit dem abgetropften Rosenkohl in die Sauce geben.', 'Dazu passt Schweinefilet und Pellkartoffeln.', 1, 50, 212, '6.05', '14.68', '14.36', '5fd22d8321afa.jpg'),
(85, 'Test-rezept', 7, 8, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', 'Weit hinten, hinter den Wortbergen, fern der Länder Vokalien und Konsonantien leben die Blindtexte.', 1, 20, 751, '12.23', '23.34', '12.56', ''),
(6, 'Rote Linsen-Kokos-Suppe', 11, 6, 'Die Zwiebeln schälen und in feine Würfel schneiden. Im Sonnenblumenöl glasig anschwitzen. Rote Linsen, Tomaten mit Saft und Kokosmilch hinzufügen und gut umrühren. Mit der Gemüsebrühe aufgießen und die Suppe ca. 20 Minuten köcheln.\r\n\r\nZum Schluss mit Salz, Chili- und Kurkumapulver abschmecken.\r\n', 'Die Suppe schmeckt am nächsten Tag doppelt so gut. Dazu passen Garnelenspieße und Baguette. ', 1, 30, 324, '8.25', '7.08', '5.98', '5fd22d953ef73.jpg'),
(7, 'Hack-Käse-Porree-Suppe', 11, 4, 'Das Gehackte in etwas Öl scharf anbraten und mit den klein geschnittenen Zwiebeln und Porree 20 min. unter Rühren braten. Die Brühe zugeben und zum Kochen bringen. Dann den Kräuterschmelzkäse zufügen, mit den Gewürzen abschmecken und nochmal aufkochen lassen. Am besten über Nacht abkühlen lassen.\r\n\r\nVor dem Servieren aufwärmen. ', '', 1, 50, 467, '10.76', '8.18', '10.53', '5fd22daab9b90.jpg'),
(105, 'Grüner Tee Kuchen', 7, 6, 'Mehl, Backpulver, Matchapulver und 100 g Zucker in einer Schüssel mischen.\r\n\r\nEiweiß und Dotter von zwei Eiern trennen. Das Eiweiß steif schlagen und dabei 50 g Zucker einrieseln lassen.\r\n\r\nÖl, Dotter der zwei Eier sowie das dritte Ei schaumig schlagen, dabei die Milch hinzugeben. Die Mehl-Zucker-Matcha-Mischung dazugeben und verrühren. Das steif geschlagene Eiweiß unterheben.\r\n\r\nTeig in eine eingefettete Backform geben und 30 Minuten im vorgeheizten Backofen bei 160 °C Ober-/Unterhitze backen. Ich verwende eine viereckige (20 x 20 cm) Form. ', '', 2, 45, 897, '45.00', '18.00', '99.00', '5ffebfa5aef44.jpg'),
(31, 'Pikanter Dattel-Frischkäse-Dip', 18, 4, 'Datteln und Knoblauch fein hacken. Schmand und Frischkäse verrühren und mit Harissa, Currypulver, Salz und Pfeffer würzen.\r\n\r\nDatteln und Knoblauch hinzufügen, unterrühren und den Dip 2 Stunden im Kühlschrank ziehen lassen. ', '', 1, 10, 214, '12.21', '14.65', '2.58', '5fd3248ddccc9.jpg'),
(103, 'Grießklößchen mit Petersilie', 11, 4, 'Butter im Topf zerlassen. Milch hinzugeben und kurz aufkochen. Grieß in die Milch geben und mit einem Schneebesen rühren bis ein Teig (Konsistenz eher krümelig) entsteht. Topf von der Kochstelle nehmen. Ein paar Minuten warten bis der Teig etwas abgekühlt ist. Nun die Petersilie zum Teig geben. Mit Salz, Pfeffer abschmecken. Die Eier hinzufügen, im Teig verkneten. Nun kleine Kugeln formen, die ca. 5 min in heißer Brühe gar ziehen sollten. \r\n\r\nVarianten:\r\n- Die Klösschen lassen sich mit den verschiedensten Kräutern zubereiten.\r\n- Auch lässt sich ein kleines Stück Fetakäse einarbeiten, z.B. für eine Tomatensuppe.\r\n- Den hergestellten Teig halbieren. Zu ersten Hälfte einen Esslöffel grünes Pesto, zur anderen ein Löffel rotes Pesto geben. Jeweils eine kleine Kugel herstellen, beide zusammendrücken und vorsichtig zu einem Klösschen formen. Dann wie beschrieben verfahren. Sieht toll aus in einer Tomatenessenz.', '', 1, 25, 543, '34.50', '63.00', '83.00', '5ffeb27eaaf3e.jpg'),
(28, 'Tomaten-Shooter', 15, 4, 'Den Mozzarella abtropfen lassen und halbieren. Die Tomaten waschen. Abwechselnd mit Mozzarella und Baslikumblättchen auf vier Holzspieße stecken. Den Tomatensaft mit Chili und Öl auf Eiswürfeln in einem Barshaker schütteln. Mit Meersalz und Worcestershiresoße pikant abschmecken. In eisgekühlte Longdrinkgläser abfüllen und mit den Tomaten-Mozzarella-Basilikum-Spießen servieren. ', '', 1, 15, 215, '12.00', '5.89', '2.30', '5fd239223d652.jpg'),
(27, 'Beeren - Smoothie', 10, 1, 'Die Blueberries in einen Mixer geben und kurz pürieren. Die Himbeeren, Honig und Joghurt dazu geben und ebenfalls fein pürieren. In ein Glas füllen und zum Frühstück oder zwischendurch servieren.\r\n\r\nMan kann auch etwas mehr Honig oder Zucker dazu geben wem es nicht süß genug ist. Das Rezept ist für ein großes Glas. ', 'Lecker zum Frühstück!', 1, 10, 223, '10.30', '9.12', '21.81', '5fd23609efe9a.jpg'),
(19, 'Zitronenkuchen', 7, 6, 'Den Backofen auf 175 °C - 195 °C vorheizen.\r\n\r\nZuerst die Schale von den 3 Zitronen abreiben, zwei Zitronen davon auspressen.\r\n\r\nDann Eier und Zucker schaumig rühren. Das Mehl sieben und mit Vanillezucker, Backpulver, Zitronenschale und Margarine nach und nach dazugeben. Alles gut mixen. Den Teig auf ein mit Backpapier ausgelegtes Backblech streichen. In den vorgeheizten Backofen schieben und ca. 20 Min. auf der mittleren Schiene backen.\r\n\r\nNun aus dem Zitronensaft und dem Puderzucker nach und nach eine Glasur mischen - bitte sehr sparsam mit dem Zitronensaft umgehen, die Glasur muss schön dickflüssig sein.\r\n\r\nSolange der Kuchen noch warm ist, mit einer Gabel überall einstechen. Somit wird er schön saftig, denn die Glasur kann so einsickern. Dann schnell die Glasur auf dem warmen Kuchen verstreichen und auskühlen lassen. ', '', 1, 25, 560, '23.47', '45.89', '92.25', '5fd0781aa65a3.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezepte_erneahrungsform`
--

CREATE TABLE `rezepte_erneahrungsform` (
  `rezepte_nr` int(6) UNSIGNED NOT NULL,
  `erform_nr` tinyint(2) UNSIGNED NOT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `rezepte_erneahrungsform`
--

INSERT INTO `rezepte_erneahrungsform` (`rezepte_nr`, `erform_nr`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezepte_zutaten`
--

CREATE TABLE `rezepte_zutaten` (
  `rezepte_nr` int(6) UNSIGNED NOT NULL,
  `zutaten_nr` tinyint(2) UNSIGNED NOT NULL,
  `menge` varchar(4) DEFAULT NULL,
  `zutaten_bz` varchar(50) NOT NULL,
  `einheit_bz` varchar(20) DEFAULT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `rezepte_zutaten`
--

INSERT INTO `rezepte_zutaten` (`rezepte_nr`, `zutaten_nr`, `menge`, `zutaten_bz`, `einheit_bz`) VALUES
(1, 9, '1', 'Pfeffer frisch gemahlen', 'Prise'),
(1, 8, '1', 'Chiliflocken', 'TL'),
(1, 6, '200', 'Sahne', 'g'),
(1, 5, '250', 'Emmentaler fein gerieben', 'g'),
(1, 4, '1', 'Zwiebel(n) in kleine Würfel geschnitten', 'groß'),
(1, 3, '4', 'Eier', 'größe-L'),
(1, 1, '1', 'Rosenkohl', 'kg'),
(1, 2, '200', 'Kochschinken in Streifen geschnitten', 'g'),
(3, 2, '1', 'Salz und Pfeffer aus der Mühle', 'Prise'),
(3, 3, '30', 'Butter', 'g'),
(3, 4, '2', 'Mehl', 'TL'),
(3, 5, '2', 'Currypulver', 'TL'),
(3, 6, '1/4', 'Brühe', 'Liter'),
(3, 7, '150', 'Crème fraîche', 'g'),
(3, 8, '2', 'Zitronensaft', 'TL'),
(3, 9, '1', 'Zucker', 'Prise'),
(3, 1, '500', 'Rosenkohl', 'g'),
(6, 9, '1', 'Salz', 'Prise'),
(6, 8, '2', 'Sonnenblumenöl', 'TL'),
(6, 6, '2', 'Kurkuma', 'TL'),
(6, 5, '3', 'Chilipulver', 'TL'),
(6, 4, '175', 'Rote Linsen', 'g'),
(6, 3, '1', 'Zwiebel', 'klein'),
(7, 11, '3', 'Öl', 'EL'),
(7, 10, '1/4', 'Cayennepfeffer', 'TL'),
(7, 9, '1', 'Basilikum', 'TL'),
(7, 8, '1', 'Thymian', 'TL'),
(7, 7, '1', 'Salz und Pfeffer', 'Prise'),
(7, 6, '1', 'Rosmarin', 'TL'),
(7, 4, '1', 'Rinderbrühe', 'Liter'),
(7, 3, '500', 'Porree', 'g'),
(28, 1, '6', 'Mini-Mozzarella', 'Kugeln'),
(28, 2, '8', 'Kirschtomaten', 'Stücke'),
(28, 3, '12', 'Basilikum', 'Blätter'),
(28, 4, '600', 'Tomatensaft', 'ml'),
(28, 5, '1/2', 'Chiliflocken', 'TL'),
(28, 6, '2', 'Olivenöl', 'EL'),
(28, 8, '1', 'Worcestershiresauce', 'EL'),
(27, 1, '40', 'Heidelbeeren', 'g'),
(27, 2, '85', 'Himbeeren', 'g'),
(31, 6, '1/2', 'Currypulver', 'TL'),
(31, 5, '1', 'Harissa oder scharfer Ajvar', 'TL'),
(31, 1, '125', 'Soft-Datteln entsteint', 'g'),
(31, 2, '200', 'Schmand', 'g'),
(31, 3, '200', 'Frischkäse', 'g'),
(31, 4, '1', 'Knoblauch', 'Zehe'),
(27, 3, '1', 'Honig', 'TL'),
(31, 7, '1/2', 'Salz', 'TL'),
(31, 8, '3', 'Pfeffer', 'Prise'),
(27, 4, '230', 'Naturjoghurt', 'g'),
(19, 8, '300', 'Puderzucker', 'g'),
(19, 7, '3', 'unbehandelte Zitrone', 'TL'),
(19, 6, '6', 'Eier', 'größe-M'),
(19, 5, '1', 'Backpulver', 'TL'),
(19, 4, '1', 'Vanillezucker', 'Pck.'),
(19, 1, '350', 'Margarine', 'g'),
(1, 7, '1', 'Meersalz', 'Prise'),
(6, 7, '600', 'Gemüsebrühe', 'ml'),
(6, 2, '1', 'Kokosmilch (400 g)', 'Dosen'),
(6, 1, '1', 'Pizzatomaten (400 g)', 'Dosen'),
(7, 5, '400', 'Kräuterschmelzkäse', 'g'),
(7, 2, '500', 'Zwiebel', 'g'),
(7, 1, '500', 'Hackfleisch', 'g'),
(28, 7, '1', 'Meersalz', 'Prise'),
(19, 3, '200', 'Zucker', 'g'),
(19, 2, '350', 'Mehl', 'g'),
(103, 1, '1', 'Fleischbrühe', 'Liter'),
(103, 4, '2', 'Eier', 'größe-M'),
(103, 5, '1/2', 'Peterillie', 'Pck.'),
(85, 2, '4', 'Bauernbrot', 'Scheiben'),
(103, 2, '250', 'Milch', 'g'),
(103, 3, '100', 'Grieß (Hartweizengrieß)', 'g'),
(85, 3, '300', 'Sahne', 'ml'),
(85, 4, '2', 'Zucker', 'TL'),
(85, 1, '15', 'Milch', 'ml'),
(103, 6, '2', 'Butter', 'EL'),
(105, 1, '200', 'Mehl', 'g'),
(105, 2, '150', 'Zucker', 'g'),
(105, 3, '150', 'Öl', 'ml'),
(105, 4, '3', 'Eier', 'größe-L'),
(105, 5, '5', 'Milch', 'EL'),
(105, 6, '12', 'Matchapulver', 'g'),
(105, 7, '1', 'Backpulver', 'TL'),
(105, 8, '1', 'Fett für die Form', 'etwas');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schwierigkeitsstufen`
--

CREATE TABLE `schwierigkeitsstufen` (
  `schwstufe_nr` tinyint(2) UNSIGNED NOT NULL,
  `schwstufe_bz` varchar(20) NOT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `schwierigkeitsstufen`
--

INSERT INTO `schwierigkeitsstufen` (`schwstufe_nr`, `schwstufe_bz`) VALUES
(1, 'Einfach'),
(2, 'Medium'),
(3, 'Schwierig');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `user_nr` int(8) NOT NULL,
  `benutzername` varchar(50) NOT NULL,
  `passwort` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`user_nr`, `benutzername`, `passwort`, `admin`) VALUES
(1, 'test', '$2y$10$Ei6v5lXMa0PB6fEtF82fJu.vbmeWI544GaBUweImBOT6kNnqvjxc2', 0),
(2, 'Montserrat', '$2y$10$Ei6v5lXMa0PB6fEtF82fJu.vbmeWI544GaBUweImBOT6kNnqvjxc2', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zutaten_einheiten`
--

CREATE TABLE `zutaten_einheiten` (
  `einheit_nr` tinyint(2) UNSIGNED NOT NULL,
  `einheit_bz` varchar(20) NOT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `zutaten_einheiten`
--

INSERT INTO `zutaten_einheiten` (`einheit_nr`, `einheit_bz`) VALUES
(1, 'kg'),
(2, 'g'),
(3, 'Dosen'),
(4, 'EL'),
(5, 'TL'),
(8, 'Stücke'),
(7, 'Bund'),
(9, 'Blatt'),
(10, 'Blätter'),
(11, 'Flaschen'),
(12, 'Prisen'),
(13, 'Stangen'),
(14, 'Würfel'),
(15, 'Zehen'),
(16, 'Pck.'),
(22, 'Kugeln'),
(18, 'groß'),
(19, 'etwas'),
(20, 'Liter'),
(21, 'ml'),
(23, 'Dose'),
(24, 'Flasche'),
(25, 'Prise'),
(26, 'Stange'),
(27, 'Stück'),
(28, 'Zehe'),
(29, 'Kugel'),
(30, 'L'),
(31, 'cl'),
(32, 'Glas'),
(33, 'Scheibe'),
(34, 'größe-M'),
(35, 'klein'),
(36, 'größe-L'),
(37, 'Scheiben'),
(38, 'Schuss'),
(39, 'Körner');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `erneahrungsform`
--
ALTER TABLE `erneahrungsform`
  ADD PRIMARY KEY (`erform_nr`),
  ADD UNIQUE KEY `erform_bz` (`erform_bz`);

--
-- Indizes für die Tabelle `menue_arten`
--
ALTER TABLE `menue_arten`
  ADD PRIMARY KEY (`menueart_nr`),
  ADD UNIQUE KEY `menueart_bz` (`menueart_bz`);

--
-- Indizes für die Tabelle `rezepte`
--
ALTER TABLE `rezepte`
  ADD PRIMARY KEY (`rezepte_nr`);

--
-- Indizes für die Tabelle `rezepte_erneahrungsform`
--
ALTER TABLE `rezepte_erneahrungsform`
  ADD PRIMARY KEY (`rezepte_nr`,`erform_nr`);

--
-- Indizes für die Tabelle `rezepte_zutaten`
--
ALTER TABLE `rezepte_zutaten`
  ADD PRIMARY KEY (`rezepte_nr`,`zutaten_nr`);

--
-- Indizes für die Tabelle `schwierigkeitsstufen`
--
ALTER TABLE `schwierigkeitsstufen`
  ADD PRIMARY KEY (`schwstufe_nr`),
  ADD UNIQUE KEY `schwstufe_bz` (`schwstufe_bz`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_nr`),
  ADD UNIQUE KEY `benutzername` (`benutzername`);

--
-- Indizes für die Tabelle `zutaten_einheiten`
--
ALTER TABLE `zutaten_einheiten`
  ADD PRIMARY KEY (`einheit_nr`),
  ADD UNIQUE KEY `einheit_bz` (`einheit_bz`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `erneahrungsform`
--
ALTER TABLE `erneahrungsform`
  MODIFY `erform_nr` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT für Tabelle `menue_arten`
--
ALTER TABLE `menue_arten`
  MODIFY `menueart_nr` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT für Tabelle `rezepte`
--
ALTER TABLE `rezepte`
  MODIFY `rezepte_nr` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT für Tabelle `rezepte_zutaten`
--
ALTER TABLE `rezepte_zutaten`
  MODIFY `zutaten_nr` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `schwierigkeitsstufen`
--
ALTER TABLE `schwierigkeitsstufen`
  MODIFY `schwstufe_nr` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `user_nr` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `zutaten_einheiten`
--
ALTER TABLE `zutaten_einheiten`
  MODIFY `einheit_nr` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
