-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 06, 2025 alle 10:55
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
