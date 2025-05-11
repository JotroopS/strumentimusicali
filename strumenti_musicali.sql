-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 11, 2025 alle 18:46
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `strumenti_musicali`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `carrello`
--

CREATE TABLE `carrello` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) DEFAULT NULL,
  `id_strumento` int(11) DEFAULT NULL,
  `quantita` int(11) DEFAULT 1,
  `aggiunto_il` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `immagine` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`id`, `nome`, `descrizione`, `immagine`) VALUES
(1, 'Chitarra', NULL, NULL),
(2, 'Violino', NULL, NULL),
(3, 'Arpa', NULL, NULL),
(4, 'Flauto', NULL, NULL),
(5, 'Sax', NULL, NULL),
(6, 'Clarinetto', NULL, NULL),
(7, 'Batteria', NULL, NULL),
(8, 'Congas', NULL, NULL),
(9, 'Tamburi', NULL, NULL),
(10, 'Pianoforte', NULL, NULL),
(11, 'Organo', NULL, NULL),
(12, 'Synthesizer', NULL, NULL),
(13, 'Microfono dinamico', NULL, NULL),
(14, 'Microfono a condensatore', NULL, NULL),
(15, 'Microfono USB', NULL, NULL),
(16, 'Cavi', NULL, NULL),
(17, 'Supporti', NULL, NULL),
(18, 'Custodie', NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `dettagli_ordini`
--

CREATE TABLE `dettagli_ordini` (
  `id` int(11) NOT NULL,
  `id_ordine` int(11) DEFAULT NULL,
  `id_strumento` int(11) DEFAULT NULL,
  `quantita` int(11) DEFAULT NULL,
  `prezzo_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `ordini`
--

CREATE TABLE `ordini` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) DEFAULT NULL,
  `data_ordine` datetime DEFAULT current_timestamp(),
  `totale` decimal(10,2) DEFAULT NULL,
  `stato` enum('in elaborazione','spedito','consegnato','annullato') DEFAULT 'in elaborazione',
  `indirizzo_spedizione` varchar(255) DEFAULT NULL,
  `metodo_pagamento` enum('carta','paypal','bonifico') DEFAULT 'carta',
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `strumenti`
--

CREATE TABLE `strumenti` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modello` varchar(100) DEFAULT NULL,
  `descrizione` text DEFAULT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `quantita` int(11) DEFAULT 0,
  `immagine` varchar(255) DEFAULT NULL,
  `disponibilita` tinyint(1) DEFAULT 1,
  `id_categoria` int(11) DEFAULT NULL,
  `data_aggiunta` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `strumenti`
--

INSERT INTO `strumenti` (`id`, `nome`, `marca`, `modello`, `descrizione`, `prezzo`, `quantita`, `immagine`, `disponibilita`, `id_categoria`, `data_aggiunta`) VALUES
(4, 'Chitarra Elettrica Fender', 'Fender', 'Stratocaster', 'Modello classico Fender Stratocaster, versatile e amato da tutti i chitarristi.', 999.99, 8, 'fender_stratocaster.jpg', 1, 1, '2025-05-09 14:21:15'),
(5, 'Chitarra Elettrica Gibson', 'Gibson', 'Les Paul Standard', 'Il suono potente e corposo della leggendaria Gibson Les Paul.', 1499.99, 8, 'gibson_lespaul.jpg', 1, 1, '2025-05-09 14:21:15'),
(6, 'Chitarra Ibanez', 'Ibanez', 'RG550-RF', 'Modello RG550-RF, ottimo per rock e metal, con finitura Red Flare.', 799.99, 12, 'ibanez_rg550.jpg', 1, 1, '2025-05-09 14:21:15'),
(7, 'Chitarra PRS', 'PRS', 'SE Custom 24', 'PRS SE Custom 24, equilibrio perfetto tra qualità e prezzo.', 749.99, 15, 'prs_se.jpg', 1, 1, '2025-05-09 14:21:15'),
(8, 'Violino 4/4 Classico', 'Stentor', 'Student I', 'Violino perfetto per principianti, include archetto e custodia.', 159.99, 10, 'violino1.jpg', 1, 2, '2025-05-09 14:37:35'),
(9, 'Violino Professionale', 'Yamaha', 'V7SG', 'Violino di alta qualità per studenti avanzati e professionisti.', 499.00, 5, 'violino2.jpg', 1, 2, '2025-05-09 14:37:35'),
(10, 'Violino Elettrico', 'Cecilio', 'CVE-1BK', 'Violino elettrico nero, include cuffie, cavi e archetto.', 229.50, 7, 'violino3.jpg', 1, 2, '2025-05-09 14:37:35'),
(11, 'Violino Barocco', 'Karl Höfner', 'H11-B', 'Modello barocco artigianale, ideale per musica antica.', 850.00, 2, 'violino4.jpg', 1, 2, '2025-05-09 14:37:35'),
(12, 'Arpa Celtica', 'Camac', 'Bardic 27', 'Arpa celtica portatile, perfetta per principianti e musicisti itineranti.', 1599.00, 5, 'arpa1.jpg', 1, 3, '2025-05-10 23:05:22'),
(13, 'Arpa da Concerto', 'Lyon & Healy', 'Style 23', 'Arpa professionale da concerto, con suono ricco e dinamico.', 15500.00, 2, 'arpa2.jpg', 1, 3, '2025-05-10 23:05:22'),
(14, 'Arpa Irlandese', 'Salvi', 'Ana', 'Elegante arpa irlandese, costruita con legno massello e sonorità calda.', 2900.00, 4, 'arpa3.jpg', 1, 3, '2025-05-10 23:05:22'),
(15, 'Mini Arpa da Studio', 'Rees Harps', 'Sharpsicle', 'Compatta e leggera, perfetta per l’apprendimento e la pratica a casa.', 780.00, 6, 'arpa4.jpg', 1, 3, '2025-05-10 23:05:22'),
(16, 'Flauto Traverso Yamaha', 'Yamaha', 'YFL-222', 'Flauto traverso per principianti, corpo in nickel‑silver', 249.00, 12, 'flauto1.jpg', 1, 4, '2025-05-10 23:09:24'),
(17, 'Flauto Dolce Aulos', 'Aulos', '201A', 'Flauto dolce soprano in resina ABS', 29.90, 20, 'flauto2.jpg', 1, 4, '2025-05-10 23:09:24'),
(18, 'Flauto in Sol Solid Body', 'Pearl', 'PF-665E', 'Flauto in sol con intarsi in madreperla', 379.00, 8, 'flauto3.jpg', 1, 4, '2025-05-10 23:09:24'),
(19, 'Flauto dritto in legno', 'Mollenhauer', '4110', 'Flauto dritto barocco in noce', 199.00, 5, 'flauto4.jpg', 1, 4, '2025-05-10 23:09:24'),
(20, 'Sax Contralto Yamaha', 'Yamaha', 'YAS-280', 'Contralto entry‑level con finitura ottone', 799.00, 6, 'sax1.jpg', 1, 5, '2025-05-10 23:09:24'),
(21, 'Sax Tenore Selmer', 'Selmer', 'TS711', 'Tenore professionale serie III', 2499.00, 3, 'sax2.jpg', 1, 5, '2025-05-10 23:09:24'),
(22, 'Sax Alto Jean Paul', 'Jean Paul', 'AS-400', 'Alto in ottone verniciato con custodia', 349.00, 10, 'sax3.jpg', 1, 5, '2025-05-10 23:09:24'),
(23, 'Sax Baritono Mendini', 'Mendini', 'BAR-100', 'Baritono per studenti, include accessori', 299.00, 4, 'sax4.jpg', 1, 5, '2025-05-10 23:09:24'),
(24, 'Clarinetto Sib Buffet', 'Buffet Crampon', 'E11', 'Clarinetto per studenti in resina ABS', 599.00, 7, 'clarinetto1.jpg', 1, 6, '2025-05-10 23:09:24'),
(25, 'Clarinetto in silver', 'Yamaha', 'YCL-650', 'Corpo in granadilla con chiavi in argento', 1899.00, 2, 'clarinetto2.jpg', 1, 6, '2025-05-10 23:09:24'),
(26, 'Clarinetto Bb Mendini', 'Mendini', 'CL-100', 'Entry‑level con custodia e bocchino', 129.00, 15, 'clarinetto3.jpg', 1, 6, '2025-05-10 23:09:24'),
(27, 'Clarinetto basso Leblanc', 'Leblanc', 'L376', 'Basso professionale con meccanica rinforzata', 3499.00, 1, 'clarinetto4.jpg', 1, 6, '2025-05-10 23:09:24'),
(28, 'Set Batteria Pearl', 'Pearl', 'Roadshow', '5 pezzi + piatti starter kit', 499.00, 5, 'batteria1.jpg', 1, 7, '2025-05-10 23:09:24'),
(29, 'Set Batteria Mapex', 'Mapex', 'Armory', '6 pezzi shell pack professionale', 999.00, 3, 'batteria2.jpg', 1, 7, '2025-05-10 23:09:24'),
(30, 'Batteria Elettronica Alesis', 'Alesis', 'Nitro Mesh', '8 pad mesh, sound module integrato', 379.00, 4, 'batteria3.jpg', 1, 7, '2025-05-10 23:09:24'),
(31, 'Set Percussioni LP', 'Latin Percussion', 'LP Aspire', 'Conga + bongo + cajon bundle', 599.00, 2, 'batteria4.jpg', 1, 7, '2025-05-10 23:09:24'),
(32, 'Conga Meinl', 'Meinl', 'Headliner', '10\"+11.5\" set con supporti', 449.00, 4, 'conga1.jpg', 1, 8, '2025-05-10 23:09:24'),
(33, 'Conga Tumba LP', 'Latin Percussion', 'LP-568', '11.75\" tumba con cerchi in acciaio', 579.00, 3, 'conga2.jpg', 1, 8, '2025-05-10 23:09:24'),
(34, 'Conga Tycoon', 'Tycoon', 'TCMC', '10\"+11.5\" coppia in mogano', 399.00, 6, 'conga3.jpg', 1, 8, '2025-05-10 23:09:24'),
(35, 'Conga Gon Bops', 'Gon Bops', 'Master 11\"', 'Congas pro series in mogano', 799.00, 2, 'conga4.jpg', 1, 8, '2025-05-10 23:09:24'),
(36, 'Tamburo Cajon LP', 'Latin Percussion', 'LP Cajon', 'Cajon con pickup integrato', 139.00, 8, 'tamburo1.jpg', 1, 9, '2025-05-10 23:09:24'),
(37, 'Djembe Meinl', 'Meinl', 'African Spirit', '12\" djembe in legno massello', 169.00, 5, 'tamburo2.jpg', 1, 9, '2025-05-10 23:09:24'),
(38, 'Bongo LP', 'Latin Percussion', 'Matador', '7\"+8.5\" bongo set', 99.00, 10, 'tamburo3.jpg', 1, 9, '2025-05-10 23:09:24'),
(39, 'Tabla Pearl', 'Pearl', 'Session', 'Set tabla indiana con cajon', 299.00, 3, 'tamburo4.jpg', 1, 9, '2025-05-10 23:09:24'),
(40, 'Pianoforte Digitale Yamaha', 'Yamaha', 'P-45', '88 tasti pesati, leggero e compatto', 449.00, 7, 'pianoforte1.jpg', 1, 10, '2025-05-10 23:09:24'),
(41, 'Pianoforte Kawai', 'Kawai', 'ES110', '88 tasti, speaker integrati', 599.00, 4, 'pianoforte2.jpg', 1, 10, '2025-05-10 23:09:24'),
(42, 'Pianoforte Roland', 'Roland', 'FP-30X', 'Bluetooth MIDI, 128 polifonia', 799.00, 3, 'pianoforte3.jpg', 1, 10, '2025-05-10 23:09:24'),
(43, 'Pianoforte Casio', 'Casio', 'PX-S1100', 'Slim design, tasti pesati', 499.00, 6, 'pianoforte4.jpg', 1, 10, '2025-05-10 23:09:24'),
(44, 'Organo Hammond', 'Hammond', 'SK1', '61 tasti, drawbars, speaker integrato', 1199.00, 2, 'organo1.jpg', 1, 11, '2025-05-10 23:09:24'),
(45, 'Organo Yamaha', 'Yamaha', 'YC-61', 'Synth organico + pianoforte', 999.00, 3, 'organo2.jpg', 1, 11, '2025-05-10 23:09:24'),
(46, 'Organo Korg', 'Korg', 'BX-3', 'Soundwheel organ emulation', 899.00, 4, 'organo3.jpg', 1, 11, '2025-05-10 23:09:24'),
(47, 'Organo Nord', 'Nord', 'C2D', 'Dual manual, effetti analogici', 2499.00, 1, 'organo4.jpg', 1, 11, '2025-05-10 23:09:24'),
(48, 'Synth Korg Minilogue', 'Korg', 'Minilogue', '4 voci analogiche, sequencer', 499.00, 5, 'synth1.jpg', 1, 12, '2025-05-10 23:09:24'),
(49, 'Synth Novation', 'Novation', 'Bass Station II', 'Monofonico, ottimo per bassi', 329.00, 6, 'synth2.jpg', 1, 12, '2025-05-10 23:09:24'),
(50, 'Synth Arturia', 'Arturia', 'MicroFreak', 'Hybrid digital/analogico', 299.00, 4, 'synth3.jpg', 1, 12, '2025-05-10 23:09:24'),
(51, 'Synth Roland', 'Roland', 'System-8', 'Plug‑out synth engine', 999.00, 2, 'synth4.jpg', 1, 12, '2025-05-10 23:09:24'),
(52, 'Shure SM58', 'Shure', 'SM58', 'Standard live vocal dynamic mic', 99.00, 12, 'micdin1.jpg', 1, 13, '2025-05-10 23:09:24'),
(53, 'Sennheiser e835', 'Sennheiser', 'e835', 'Dynamic cardioid vocal mic', 89.00, 10, 'micdin2.jpg', 1, 13, '2025-05-10 23:09:24'),
(54, 'AKG D5', 'AKG', 'D5', 'Supercardioid dynamic mic', 119.00, 8, 'micdin3.jpg', 1, 13, '2025-05-10 23:09:24'),
(55, 'Electro-Voice N/D367a', 'EV', 'N/D367a', 'Handheld dynamic', 129.00, 5, 'micdin4.jpg', 1, 13, '2025-05-10 23:09:24'),
(56, 'Audio‑Technica AT2020', 'Audio‑Technica', 'AT2020', 'Cardioid condenser studio mic', 99.00, 15, 'miccon1.jpg', 1, 14, '2025-05-10 23:09:24'),
(57, 'Rode NT1‑A', 'Rode', 'NT1-A', 'Low-noise cardioid condenser', 229.00, 7, 'miccon2.jpg', 1, 14, '2025-05-10 23:09:24'),
(58, 'AKG C214', 'AKG', 'C214', 'Large-diaphragm condenser', 349.00, 4, 'miccon3.jpg', 1, 14, '2025-05-10 23:09:24'),
(59, 'Neumann TLM 102', 'Neumann', 'TLM 102', 'German condenser mic', 699.00, 2, 'miccon4.jpg', 1, 14, '2025-05-10 23:09:24'),
(60, 'Blue Yeti', 'Blue', 'Yeti', 'USB multi-pattern condenser', 129.00, 14, 'micusb1.jpg', 1, 15, '2025-05-10 23:09:24'),
(61, 'Audio‑Technica AT2020USB+', 'Audio‑Technica', 'AT2020USB+', 'USB condenser mic', 149.00, 9, 'micusb2.jpg', 1, 15, '2025-05-10 23:09:24'),
(62, 'Samson Meteor', 'Samson', 'Meteor', 'Large diaphragm USB', 69.00, 11, 'micusb3.jpg', 1, 15, '2025-05-10 23:09:24'),
(63, 'Rode NT-USB', 'Rode', 'NT-USB', 'Studio-quality USB mic', 169.00, 6, 'micusb4.jpg', 1, 15, '2025-05-10 23:09:24'),
(64, 'Cavo Strumento Planet Waves', 'Planet Waves', 'Classic Series', '1/4\" TS, 3m', 19.99, 25, 'cavo1.jpg', 1, 16, '2025-05-10 23:09:24'),
(65, 'Cavo XLR Mogami', 'Mogami', '2534', 'XLR‑XLR, 5m', 39.99, 18, 'cavo2.jpg', 1, 16, '2025-05-10 23:09:24'),
(66, 'Cavo Jack Hosa', 'Hosa', 'CMP-153', '1/4\" TRS, 3m', 14.99, 30, 'cavo3.jpg', 1, 16, '2025-05-10 23:09:24'),
(67, 'Cavo MIDI Roland', 'Roland', 'MIDI-5', '5-pin DIN, 2m', 12.99, 20, 'cavo4.jpg', 1, 16, '2025-05-10 23:09:24'),
(68, 'Supporto Tastiera On-Stage', 'On-Stage', 'X-Style', 'Regolabile per piano e synth', 29.99, 15, 'supporto1.jpg', 1, 17, '2025-05-10 23:09:24'),
(69, 'Supporto Chitarra Hercules', 'Hercules', 'GS301B', 'A‑frame per chitarra/acustica', 19.99, 12, 'supporto2.jpg', 1, 17, '2025-05-10 23:09:24'),
(70, 'Supporto Batteria Pearl', 'Pearl', 'DS-930', 'Leggio per piatti e tamburi', 49.99, 8, 'supporto3.jpg', 1, 17, '2025-05-10 23:09:24'),
(71, 'Supporto Microfono K&M', 'K&M', '210/9', 'Regolabile, nero', 24.99, 20, 'supporto4.jpg', 1, 17, '2025-05-10 23:09:24'),
(72, 'Custodia Chitarra Fender', 'Fender', 'Classic', 'Gig bag imbottita', 59.99, 10, 'custodia1.jpg', 1, 18, '2025-05-10 23:09:24'),
(73, 'Custodia Violino Stentor', 'Stentor', 'Polyfoam', 'Per violino 4/4, imbottita', 39.99, 14, 'custodia2.jpg', 1, 18, '2025-05-10 23:09:24'),
(74, 'Custodia Flauto Aulos', 'Aulos', 'ABS case', 'Rigida per flauto traverso', 19.99, 20, 'custodia3.jpg', 1, 18, '2025-05-10 23:09:24'),
(75, 'Custodia Sax Protec', 'Protec', 'Contoured', 'Gig bag per sax alto', 89.99, 6, 'custodia4.jpg', 1, 18, '2025-05-10 23:09:24');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `indirizzo` varchar(255) DEFAULT NULL,
  `citta` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `data_nascita` date NOT NULL,
  `data_registrazione` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `nome`, `cognome`, `email`, `password`, `indirizzo`, `citta`, `telefono`, `data_nascita`, `data_registrazione`) VALUES
(1, 'Jotroop', 'Singh', 'jotroopsingh644@gmail.com', '$2y$10$2LK2GPgx8nrAuyRSGUKPL.QL8cCCTuAHfOyq/GVqg3Pwsoab9nU/u', 'Via Provinciale 20', 'Cenate Sopra', '3519476235', '2006-08-29', '2025-05-03 21:28:19');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `carrello`
--
ALTER TABLE `carrello`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_strumento` (`id_strumento`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `dettagli_ordini`
--
ALTER TABLE `dettagli_ordini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ordine` (`id_ordine`),
  ADD KEY `id_strumento` (`id_strumento`);

--
-- Indici per le tabelle `ordini`
--
ALTER TABLE `ordini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`);

--
-- Indici per le tabelle `strumenti`
--
ALTER TABLE `strumenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `carrello`
--
ALTER TABLE `carrello`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `dettagli_ordini`
--
ALTER TABLE `dettagli_ordini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `ordini`
--
ALTER TABLE `ordini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `strumenti`
--
ALTER TABLE `strumenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `carrello`
--
ALTER TABLE `carrello`
  ADD CONSTRAINT `carrello_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`),
  ADD CONSTRAINT `carrello_ibfk_2` FOREIGN KEY (`id_strumento`) REFERENCES `strumenti` (`id`);

--
-- Limiti per la tabella `dettagli_ordini`
--
ALTER TABLE `dettagli_ordini`
  ADD CONSTRAINT `dettagli_ordini_ibfk_1` FOREIGN KEY (`id_ordine`) REFERENCES `ordini` (`id`),
  ADD CONSTRAINT `dettagli_ordini_ibfk_2` FOREIGN KEY (`id_strumento`) REFERENCES `strumenti` (`id`);

--
-- Limiti per la tabella `ordini`
--
ALTER TABLE `ordini`
  ADD CONSTRAINT `ordini_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`);

--
-- Limiti per la tabella `strumenti`
--
ALTER TABLE `strumenti`
  ADD CONSTRAINT `strumenti_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
