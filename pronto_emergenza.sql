-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 05, 2025 alle 13:09
-- Versione del server: 10.4.11-MariaDB
-- Versione PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pronto_emergenza`
--
DROP DATABASE IF EXISTS `pronto_emergenza`;
CREATE DATABASE IF NOT EXISTS `pronto_emergenza` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `pronto_emergenza`;

-- --------------------------------------------------------

--
-- Struttura della tabella `assistenze`
--

CREATE TABLE `assistenze` (
  `idAssistenza` int(11) NOT NULL,
  `data` date NOT NULL COMMENT 'Data in cui l’assistenza è stata fornita',
  `oraInizio` time NOT NULL COMMENT 'L''ora esatta in cui è iniziata l’assistenza',
  `oraFine` time NOT NULL COMMENT 'L’ora esatta in cui l’assistenza è terminata',
  `luogo` varchar(255) NOT NULL COMMENT 'La locazione geografica o la descrizione del luogo in cui si dovrà fornire l’assistenza',
  `idMezzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `assistenze`
--

INSERT INTO `assistenze` (`idAssistenza`, `data`, `oraInizio`, `oraFine`, `luogo`, `idMezzo`) VALUES
(1, '2024-04-09', '11:24:05', '00:00:00', 'Via Manzoni 66', 2),
(2, '2022-04-02', '02:24:05', '12:14:05', 'Viale Roma 1', 1),
(3, '2023-04-15', '03:26:00', '13:26:00', 'Via stretta 73', 3),
(4, '2017-04-06', '11:26:00', '11:06:00', 'Piazzale Loreto', 1),
(5, '2022-04-11', '20:28:57', '20:28:53', 'Pianura', 2),
(6, '2024-04-03', '20:28:00', '22:28:57', 'Via G.E. Falck', 3),
(7, '2024-04-02', '12:28:57', '14:28:57', 'Via Rossi 46', 3),
(8, '2016-04-01', '12:28:59', '17:28:59', 'Via Padova 5', 3),
(9, '2024-04-01', '19:28:59', '21:28:59', 'Via Dante Alighieri, 5', 2),
(10, '2024-04-06', '14:35:48', '15:35:48', 'Via Alessandro Manzoni XVII', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `comunicazioni`
--

CREATE TABLE `comunicazioni` (
  `idComunicazione` int(11) NOT NULL COMMENT 'ID della comunicazione, utilizzato come chiave primaria e auto-incrementato per garantire univocità automatica',
  `dataEmissione` date NOT NULL COMMENT 'data di invio comunicazione ',
  `titolo` varchar(15) NOT NULL COMMENT 'titolo identificatore univoco ',
  `testo` text NOT NULL COMMENT 'contenuto della comunicazione ',
  `nomeFileAllegato` varchar(50) DEFAULT NULL COMMENT 'nome del percorso del file da allegare alla comunicazione ',
  `dataScadenza` date NOT NULL COMMENT 'data di scadenza della comunicazione ',
  `idTipo` int(11) NOT NULL COMMENT 'nome identificatore del tipo di comunicazione ',
  `idUtente` int(11) NOT NULL COMMENT 'ID dell''utente associato alla comunicazione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `comunicazioni`
--

INSERT INTO `comunicazioni` (`idComunicazione`, `dataEmissione`, `titolo`, `testo`, `nomeFileAllegato`, `dataScadenza`, `idTipo`, `idUtente`) VALUES
(1, '2024-04-01', 'Turno001', 'Conferma del tuo turno di servizio per la settimana prossima.', NULL, '2024-04-07', 1, 1),
(2, '2024-04-02', 'Info002', 'Aggiornamento sui protocolli di sicurezza COVID-19 per il personale.', 'protocollo_COVID_02.pdf', '2024-05-02', 2, 2),
(3, '2024-04-03', 'Emergenza003', 'Richiesta di personale extra per emergenza in zona nord.', NULL, '2024-04-03', 3, 3),
(4, '2024-04-04', 'Formazione004', 'Sessione di formazione obbligatoria su nuove attrezzature mediche.', 'formazione_04.pdf', '2024-04-25', 4, 4),
(5, '2024-04-05', 'Manutenzione005', 'Programma di manutenzione delle ambulanze per il mese di aprile.', NULL, '2024-04-30', 5, 5),
(6, '2024-04-06', 'Evento006', 'Invito a partecipare alla giornata della salute mentale per operatori sanitari.', 'evento_06.pdf', '2024-05-06', 6, 6),
(7, '2024-04-07', 'Update007', 'Aggiornamenti del sistema di gestione delle chiamate di emergenza.', 'update_sistema_07.pdf', '2024-05-07', 7, 7),
(8, '2024-04-08', 'Equipaggiamento', 'Nuovo equipaggiamento medico disponibile dall’8 aprile.', NULL, '2024-04-30', 8, 8),
(9, '2024-04-09', 'Procedure009', 'Revisione delle procedure di risposta alle emergenze.', 'procedure_09.pdf', '2024-05-09', 9, 9),
(10, '2024-04-10', 'Urgenza010', 'Richiesta immediata di assistenza in area centrale per incidente stradale.', NULL, '2024-04-10', 10, 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `documenti`
--

CREATE TABLE `documenti` (
  `idDocumento` int(11) NOT NULL,
  `descrizione` varchar(120) NOT NULL COMMENT 'identificativo del certificato ',
  `fronte` varchar(30) NOT NULL COMMENT 'foto del fronte del documento ',
  `retro` varchar(30) DEFAULT NULL COMMENT 'foto del retro del documento ',
  `dataEmissione` date NOT NULL COMMENT 'data di emissione del documento ',
  `dataScadenza` date NOT NULL COMMENT 'data di scadenza del documento ',
  `idUtente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `documenti`
--

INSERT INTO `documenti` (`idDocumento`, `descrizione`, `fronte`, `retro`, `dataEmissione`, `dataScadenza`, `idUtente`) VALUES
(1, 'Carta d\'identità', './cd01a.jpg', './cd01b.jpg', '2017-04-04', '2024-06-30', 1),
(2, 'Patente', './patenteBossini.jpg', NULL, '2024-04-01', '2033-05-05', 2),
(3, 'Codice fiscale', './cfMatteotti.jpg', NULL, '2023-12-05', '2025-04-03', 3),
(4, 'Carta d\'identità', './cd04a.jpg', NULL, '2023-06-08', '2024-04-27', 4),
(5, 'Patente', './patenteSingh.jpg', NULL, '2023-04-04', '2029-05-17', 5),
(6, 'Codice fiscale', './cfMarco.jpg', './cfMarcoretro.jpg', '0000-00-00', '0000-00-00', 6),
(7, 'Carta d\'identità', './cd07.jpg', NULL, '2015-03-05', '2024-04-30', 7),
(8, 'Patente', './patentemio.jpg', NULL, '2021-04-14', '2031-04-30', 8),
(9, 'Codice fiscale', './cf09.jpg', NULL, '0000-00-00', '0000-00-00', 9),
(10, 'Certificato', './certificato.jpg', NULL, '2024-04-01', '2024-06-30', 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `eventiprogrammati`
--

CREATE TABLE `eventiprogrammati` (
  `idEventoProgrammato` int(11) NOT NULL,
  `data` date NOT NULL COMMENT 'data dell''evento',
  `oraInizio` time NOT NULL COMMENT 'ora inizio del trasporto',
  `oraFine` time NOT NULL COMMENT 'ora fine del trasporto',
  `luogo` varchar(50) NOT NULL COMMENT 'luogo di destinazione',
  `nomeRichiedente` varchar(20) NOT NULL COMMENT 'nome della persona da assistere',
  `cognomeRichiedente` varchar(20) NOT NULL COMMENT 'cognome della persona da assistere',
  `idMezzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `eventiprogrammati`
--

INSERT INTO `eventiprogrammati` (`idEventoProgrammato`, `data`, `oraInizio`, `oraFine`, `luogo`, `nomeRichiedente`, `cognomeRichiedente`, `idMezzo`) VALUES
(1, '2024-05-02', '10:00:00', '12:00:00', 'Sala conferenze', 'Mario', 'Rossi', 1),
(2, '2024-05-03', '14:30:00', '16:30:00', 'Sala riunioni', 'Luigi', 'Bianchi', 2),
(3, '2024-05-04', '09:00:00', '11:00:00', 'Ufficio 101', 'Giovanna', 'Verdi', 3),
(4, '2024-05-05', '11:30:00', '13:30:00', 'Aula magna', 'Anna', 'Neri', 4),
(5, '2024-05-06', '13:00:00', '15:00:00', 'Sala riunioni 2', 'Paolo', 'Gialli', 5),
(6, '2024-05-07', '15:30:00', '17:30:00', 'Sala formazione', 'Sofia', 'Rosa', 6),
(7, '2024-05-08', '10:30:00', '12:30:00', 'Studio privato', 'Carlo', 'Arancioni', 7),
(8, '2024-05-09', '08:45:00', '10:45:00', 'Aula 1A', 'Chiara', 'Viola', 8),
(9, '2024-05-10', '12:15:00', '14:15:00', 'Sala seminari', 'Marco', 'Blu', 9),
(10, '2024-05-11', '16:00:00', '18:00:00', 'Spazio coworking', 'Elena', 'Marroni', 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `festivita`
--

CREATE TABLE `festivita` (
  `idFestivita` int(11) NOT NULL,
  `descrizione` text NOT NULL COMMENT 'descrizione festivita',
  `data` date NOT NULL COMMENT 'data festivita'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `festivita`
--

INSERT INTO `festivita` (`idFestivita`, `descrizione`, `data`) VALUES
(1, 'Capodanno', '2024-01-01'),
(2, 'Epifania', '2024-01-06'),
(3, 'Liberazione dal nazifascismo (1945)', '2024-04-25'),
(4, 'Lunedi di Pasqua', '2024-04-01'),
(5, 'Festa del lavoro', '2024-05-01'),
(6, 'Festa della Repubblica', '2024-06-02'),
(7, 'Assunzione di Maria', '2024-08-15'),
(8, 'Ognissanti', '2024-11-01'),
(9, 'Immacolata Concezione', '2024-12-08'),
(10, 'Natale di Gesu', '2024-12-25'),
(11, 'Santo Stefano', '2024-12-26');

-- --------------------------------------------------------

--
-- Struttura della tabella `mezzi`
--

CREATE TABLE `mezzi` (
  `idMezzo` int(11) NOT NULL,
  `nomeMezzo` varchar(30) NOT NULL,
  `modello` varchar(30) NOT NULL COMMENT 'nome del modello del mezzo',
  `targa` varchar(7) NOT NULL COMMENT 'targa del mezzo',
  `dataImmatricolazione` date NOT NULL COMMENT 'data in cui il mezzo è stato immatricolato',
  `dataRevisione` date DEFAULT NULL COMMENT 'data in cui è stata effettuata l''ultima revisione',
  `scadAssicurazione` date NOT NULL COMMENT 'scadenza assicurazione',
  `scadRevisione` date NOT NULL COMMENT 'scadenza revisione',
  `scadBollo` date NOT NULL COMMENT 'scadenza bollo',
  `tipoMezzo` enum('macchina','ambulanza') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `mezzi`
--

INSERT INTO `mezzi` (`idMezzo`, `nomeMezzo`, `modello`, `targa`, `dataImmatricolazione`, `dataRevisione`, `scadAssicurazione`, `scadRevisione`, `scadBollo`, `tipoMezzo`) VALUES
(1, 'programmati 1', 'Ford Focus', 'AB123CD', '2023-01-15', '2024-02-20', '2024-06-30', '2025-02-20', '2025-01-15', 'macchina'),
(2, 'programmati 2', 'Toyota Corolla', 'EF456GH', '2022-11-10', '2024-01-05', '2024-09-15', '2025-01-05', '2025-11-10', 'macchina'),
(3, 'programmati 3', 'Volkswagen Golf', 'IJ789KL', '2021-07-20', '2023-08-25', '2024-03-10', '2025-08-25', '2025-07-20', 'macchina'),
(4, 'Emergenza 1', 'BMW Serie 3', 'MN012OP', '2023-03-05', '2024-05-10', '2024-11-20', '2025-05-10', '2025-03-05', 'ambulanza'),
(5, 'programmati 4', 'Audi A4', 'QR345ST', '2022-09-12', '2023-11-18', '2024-07-25', '2025-11-18', '2025-09-12', 'macchina'),
(6, 'Emergenza 2', 'Mercedes-Benz Classe C', 'UV678WX', '2021-12-30', '2023-02-28', '2024-10-05', '2025-02-28', '2025-12-30', 'ambulanza'),
(7, 'Emergenza 3', 'Honda Civic', 'YZ901AB', '2022-05-08', '2023-06-15', '2024-12-20', '2025-06-15', '2025-05-08', 'ambulanza'),
(8, 'programmati 5', 'Renault Megane', 'CD234EF', '2023-08-22', '2024-09-28', '2025-01-30', '2025-09-28', '2025-08-22', 'macchina'),
(9, 'programmati 6', 'Fiat 500', 'GH567IJ', '2022-04-17', '2023-05-20', '2024-11-12', '2025-05-20', '2025-04-17', 'macchina'),
(10, 'Emergenza 4', 'Peugeot 208', 'KL890MN', '2021-10-25', '2023-11-30', '2024-07-15', '2025-11-30', '2025-10-25', 'ambulanza');

-- --------------------------------------------------------

--
-- Struttura della tabella `ruoli`
--

CREATE TABLE `ruoli` (
  `idRuolo` int(11) NOT NULL,
  `nome` enum('autista','corsista','istruttore','soccorritore') NOT NULL COMMENT 'tipo di ruolo svolto da utente ',
  `descrizione` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ruoli`
--

INSERT INTO `ruoli` (`idRuolo`, `nome`, `descrizione`) VALUES
(1, 'autista', 'Possiede una patente'),
(2, 'corsista', 'L\'utente sta effettuando dei corsi.'),
(3, 'istruttore', 'Segue il corsista.'),
(4, 'soccorritore', 'Utente con una determinata qualifica.');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipicomunicazione`
--

CREATE TABLE `tipicomunicazione` (
  `idTipo` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL COMMENT 'nome identificatore del tipo di comunicazione'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tipicomunicazione`
--

INSERT INTO `tipicomunicazione` (`idTipo`, `nome`) VALUES
(1, 'Aggiornamento'),
(2, 'Altro'),
(3, 'Assistenza'),
(21, 'Compleanno'),
(4, 'Evento'),
(5, 'Formazione'),
(6, 'Manutenzione'),
(7, 'News'),
(8, 'Scadenza'),
(9, 'Sistema'),
(10, 'Urgente');

-- --------------------------------------------------------

--
-- Struttura della tabella `turni118`
--

CREATE TABLE `turni118` (
  `idTurno118` int(11) NOT NULL COMMENT 'Identificativo del turno',
  `data` date NOT NULL COMMENT 'Data del turno',
  `oraInizio` time NOT NULL COMMENT 'Ora inizio turno',
  `oraFine` time NOT NULL COMMENT 'Ora fine turno',
  `festivo` varchar(2) NOT NULL COMMENT 'Controllo per verificare i festivi',
  `controlloAttrezzatura` tinyint(1) NOT NULL COMMENT 'Flag per controllo presenza attrezzatura',
  `convalidato` tinyint(1) NOT NULL COMMENT 'Flag per convalida turno ',
  `idMezzo` int(11) NOT NULL COMMENT 'Identificativo del mezzo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `turni118`
--

INSERT INTO `turni118` (`idTurno118`, `data`, `oraInizio`, `oraFine`, `festivo`, `controlloAttrezzatura`, `convalidato`, `idMezzo`) VALUES
(1, '2024-05-01', '15:40:17', '18:40:17', '1', 1, 1, 5),
(2, '2024-05-02', '09:00:00', '12:00:00', '0', 0, 1, 1),
(3, '2024-05-03', '14:30:00', '17:30:00', '0', 1, 0, 3),
(4, '2024-05-04', '08:00:00', '11:00:00', '0', 1, 1, 4),
(5, '2024-05-05', '16:00:00', '19:00:00', '0', 0, 1, 2),
(6, '2024-05-06', '10:45:00', '13:45:00', '0', 1, 0, 2),
(7, '2024-05-07', '07:30:00', '10:30:00', '0', 0, 1, 4),
(8, '2024-05-08', '15:15:00', '18:15:00', '0', 1, 0, 3),
(9, '2024-05-09', '11:20:00', '14:20:00', '0', 0, 1, 5),
(10, '2024-05-10', '09:30:00', '12:30:00', '0', 1, 0, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `turniutenti`
--

CREATE TABLE `turniutenti` (
  `idTurnoUtente` int(11) NOT NULL COMMENT 'Identificativo del turno dell''utente',
  `testoNota` text DEFAULT NULL COMMENT 'Testo della nota scritta dall''utente',
  `oraInizioEffettiva` time DEFAULT NULL COMMENT 'Ora inizio turno',
  `oraFineEffettiva` time DEFAULT NULL COMMENT 'Ora fine turno',
  `convalidato` tinyint(1) NOT NULL COMMENT 'Flag per controllo convalidazione da admin',
  `idTurno118` int(11) DEFAULT NULL COMMENT 'Identificativo del turno 118',
  `idEventoProgrammato` int(11) DEFAULT NULL COMMENT 'Identificativo dell''evento programmato',
  `idAssistenza` int(11) DEFAULT NULL COMMENT 'Identificativo dell''assistenza associata',
  `idRuolo` int(11) NOT NULL COMMENT 'Identificativo del ruolo',
  `idUtente` int(11) NOT NULL COMMENT 'Identificativo dell''utente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `idUtente` int(11) NOT NULL COMMENT 'Chiave primaria utente',
  `cognome` varchar(30) NOT NULL COMMENT 'Cognome dell''utente',
  `nome` varchar(30) NOT NULL COMMENT 'Nome dell''utente',
  `codiceFiscale` varchar(16) NOT NULL COMMENT 'Codice fiscale dell''utente',
  `dataNascita` date NOT NULL COMMENT 'Data di nascita dell''utente',
  `via` varchar(20) NOT NULL COMMENT 'Via dell''utente',
  `numero` varchar(4) NOT NULL COMMENT 'Numero civico dell''utente',
  `cap` varchar(5) NOT NULL COMMENT 'CAP dell''utente',
  `citta` varchar(20) NOT NULL COMMENT 'Città dell''utente',
  `provincia` varchar(2) NOT NULL COMMENT 'Provincia dell''utente',
  `username` varchar(30) NOT NULL COMMENT 'Username dell''utente',
  `password` varchar(30) NOT NULL COMMENT 'Password ell''utente',
  `email` varchar(30) NOT NULL COMMENT 'E-mail dell''utente',
  `telefono` varchar(13) NOT NULL COMMENT 'Telefono dell''utente',
  `indisponibilita` tinyint(1) NOT NULL COMMENT 'flag che permette di conoscere se l’utente è disponibile o meno per i turni ',
  `istruttore` tinyint(1) NOT NULL COMMENT 'flag per conoscere se l’utente è o meno un istruttore',
  `status` enum('volontario','dipendente','corsista') NOT NULL COMMENT 'Tipo utente',
  `tipoUtente` enum('admin','user') NOT NULL,
  `immagine` varchar(30) DEFAULT NULL,
  `dataoraInvioEmail` datetime NOT NULL,
  `dataoraClickEmail` datetime DEFAULT NULL,
  `validato` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`idUtente`, `cognome`, `nome`, `codiceFiscale`, `dataNascita`, `via`, `numero`, `cap`, `citta`, `provincia`, `username`, `password`, `email`, `telefono`, `indisponibilita`, `istruttore`, `status`, `tipoUtente`, `immagine`, `dataoraInvioEmail`, `dataoraClickEmail`, `validato`) VALUES
(1, 'Rossi', 'Mario', 'RSSMRA80A01H501A', '1980-01-01', 'G. Perlsca', '17/c', '00100', 'Roma', 'RM', 'mario.rossi', 'password123', 'mario.rossi@example.com', '0123456789', 0, 0, 'volontario', 'admin', 'bici.jpg', '2025-03-10 00:00:00', NULL, 0),
(2, 'Bianchi', 'Laura', 'BNCLLRA80A01H501', '1980-03-15', 'Via Milano', '20', '20100', 'Milano', 'MI', 'laura.bianchi', 'istruttore123', 'laura.bianchi@example.com', '9876543210', 0, 1, 'dipendente', 'user', '', '2025-02-13 00:00:00', NULL, 0),
(3, 'Verdi', 'Giuseppe', 'VRDGPZ80A01H501A', '1980-05-20', 'Via Napoli', '30', '80100', 'Napoli', 'NA', 'admin', 'admin123', 'admin@example.com', '1234567890', 0, 0, 'corsista', 'user', '', '2025-03-10 00:00:00', NULL, 0),
(4, 'Ferrari', 'Anna', 'FRRNNA80A01H501A', '1980-08-10', 'Via Firenze', '40', '50100', 'Firenze', 'FI', 'anna.ferrari', 'annapass', 'anna.ferrari@example.com', '4567890123', 1, 0, 'volontario', 'user', '', '2025-02-13 00:00:00', NULL, 0),
(5, 'Russo', 'Luca', 'RSSLCU80A01H501A', '1980-11-25', 'Via Torino', '50', '10100', 'Torino', 'TO', 'luca.russo', 'luca123', 'luca.russo@example.com', '6789012345', 0, 1, 'dipendente', 'user', '', '2025-03-10 00:00:00', NULL, 0),
(6, 'Galli', 'Paola', 'GLLPLA80A01H501A', '1980-02-14', 'Via Venezia', '60', '30100', 'Venezia', 'VE', 'paola.galli', 'paola456', 'paola.galli@example.com', '8901234567', 0, 1, 'corsista', 'user', '', '2025-02-13 00:00:00', NULL, 1),
(7, 'Moretti', 'Marco', 'MRTMRC80A01H501A', '1980-07-30', 'Via Genova', '70', '16100', 'Genova', 'GE', 'marco.moretti', 'moretti789', 'marco.moretti@example.com', '9012345678', 0, 0, 'volontario', 'user', '', '2025-03-10 00:00:00', NULL, 1),
(8, 'Fabbri', 'Elena', 'FBBELN80A01H501A', '1980-09-18', 'Via Bologna', '80', '40100', 'Bologna', 'BO', 'elena.fabbri', 'fabbri10', 'elena.fabbri@example.com', '0123456789', 0, 0, 'dipendente', 'user', '', '2025-02-13 00:00:00', NULL, 1),
(9, 'Mancini', 'Roberto', 'MCNRRT80A01H501A', '1980-04-05', 'Via Verona', '90', '37100', 'Verona', 'VR', 'roberto.mancini', 'mancini23', 'roberto.mancini@example.com', '1234567890', 0, 0, 'volontario', 'admin', '', '2025-03-10 00:00:00', NULL, 1),
(10, 'Martini', 'Giovanna', 'MRTGVN80A01H501A', '1980-10-12', 'Via Palermo', '100', '90100', 'Palermo', 'PA', 'giovanna.martini', 'martini456', 'giovanna.martini@example.com', '2345678901', 0, 0, 'dipendente', 'user', '', '2025-02-13 00:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenticomunicazioni`
--

CREATE TABLE `utenticomunicazioni` (
  `idUtentiComunicazioni` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idComunicazione` int(11) NOT NULL,
  `dataLettura` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `utenticomunicazioni`
--

INSERT INTO `utenticomunicazioni` (`idUtentiComunicazioni`, `idUtente`, `idComunicazione`, `dataLettura`) VALUES
(1, 1, 1, '2024-05-01'),
(2, 2, 2, '2024-05-02'),
(3, 3, 3, '2024-05-03'),
(4, 4, 4, '2024-05-04'),
(5, 5, 5, '2024-05-05'),
(6, 6, 6, '2024-05-06'),
(7, 7, 7, '2024-05-07'),
(8, 8, 8, '2024-05-08'),
(9, 9, 9, '2024-05-09'),
(10, 1, 10, '2024-05-10');

-- --------------------------------------------------------

--
-- Struttura della tabella `utentiruoli`
--

CREATE TABLE `utentiruoli` (
  `idUtentiRuoli` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idRuolo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `utentiruoli`
--

INSERT INTO `utentiruoli` (`idUtentiRuoli`, `idUtente`, `idRuolo`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 2, 3),
(4, 3, 3),
(5, 4, 1),
(6, 5, 4),
(7, 6, 3),
(8, 7, 4),
(9, 8, 2),
(10, 9, 4);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `assistenze`
--
ALTER TABLE `assistenze`
  ADD PRIMARY KEY (`idAssistenza`),
  ADD KEY `idMezzo` (`idMezzo`);

--
-- Indici per le tabelle `comunicazioni`
--
ALTER TABLE `comunicazioni`
  ADD PRIMARY KEY (`idComunicazione`),
  ADD UNIQUE KEY `titolo` (`titolo`),
  ADD KEY `comunicazioni_ibfk_1` (`idTipo`),
  ADD KEY `comunicazioni_ibfk_2` (`idUtente`);

--
-- Indici per le tabelle `documenti`
--
ALTER TABLE `documenti`
  ADD PRIMARY KEY (`idDocumento`),
  ADD KEY `idUtente` (`idUtente`);

--
-- Indici per le tabelle `eventiprogrammati`
--
ALTER TABLE `eventiprogrammati`
  ADD PRIMARY KEY (`idEventoProgrammato`),
  ADD KEY `idMezzo` (`idMezzo`);

--
-- Indici per le tabelle `festivita`
--
ALTER TABLE `festivita`
  ADD PRIMARY KEY (`idFestivita`);

--
-- Indici per le tabelle `mezzi`
--
ALTER TABLE `mezzi`
  ADD PRIMARY KEY (`idMezzo`),
  ADD UNIQUE KEY `nomeMezzo` (`nomeMezzo`);

--
-- Indici per le tabelle `ruoli`
--
ALTER TABLE `ruoli`
  ADD PRIMARY KEY (`idRuolo`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `tipicomunicazione`
--
ALTER TABLE `tipicomunicazione`
  ADD PRIMARY KEY (`idTipo`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `turni118`
--
ALTER TABLE `turni118`
  ADD PRIMARY KEY (`idTurno118`),
  ADD KEY `idMezzo` (`idMezzo`);

--
-- Indici per le tabelle `turniutenti`
--
ALTER TABLE `turniutenti`
  ADD PRIMARY KEY (`idTurnoUtente`),
  ADD KEY `idTurno118` (`idTurno118`),
  ADD KEY `idEventoProgrammato` (`idEventoProgrammato`),
  ADD KEY `idAssistenza` (`idAssistenza`),
  ADD KEY `idRuolo` (`idRuolo`),
  ADD KEY `idUtente` (`idUtente`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`idUtente`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indici per le tabelle `utenticomunicazioni`
--
ALTER TABLE `utenticomunicazioni`
  ADD PRIMARY KEY (`idUtentiComunicazioni`),
  ADD KEY `idUtente` (`idUtente`),
  ADD KEY `idComunicazione` (`idComunicazione`);

--
-- Indici per le tabelle `utentiruoli`
--
ALTER TABLE `utentiruoli`
  ADD PRIMARY KEY (`idUtentiRuoli`),
  ADD KEY `idRuolo` (`idRuolo`),
  ADD KEY `idUtente` (`idUtente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `assistenze`
--
ALTER TABLE `assistenze`
  MODIFY `idAssistenza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `comunicazioni`
--
ALTER TABLE `comunicazioni`
  MODIFY `idComunicazione` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID della comunicazione, utilizzato come chiave primaria e auto-incrementato per garantire univocità automatica', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `documenti`
--
ALTER TABLE `documenti`
  MODIFY `idDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `eventiprogrammati`
--
ALTER TABLE `eventiprogrammati`
  MODIFY `idEventoProgrammato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `festivita`
--
ALTER TABLE `festivita`
  MODIFY `idFestivita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT per la tabella `mezzi`
--
ALTER TABLE `mezzi`
  MODIFY `idMezzo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `ruoli`
--
ALTER TABLE `ruoli`
  MODIFY `idRuolo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `tipicomunicazione`
--
ALTER TABLE `tipicomunicazione`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT per la tabella `turni118`
--
ALTER TABLE `turni118`
  MODIFY `idTurno118` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificativo del turno', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `turniutenti`
--
ALTER TABLE `turniutenti`
  MODIFY `idTurnoUtente` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificativo del turno dell''utente';

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `idUtente` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chiave primaria utente', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `utenticomunicazioni`
--
ALTER TABLE `utenticomunicazioni`
  MODIFY `idUtentiComunicazioni` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `utentiruoli`
--
ALTER TABLE `utentiruoli`
  MODIFY `idUtentiRuoli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `assistenze`
--
ALTER TABLE `assistenze`
  ADD CONSTRAINT `assistenze_ibfk_1` FOREIGN KEY (`idMezzo`) REFERENCES `mezzi` (`idMezzo`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `comunicazioni`
--
ALTER TABLE `comunicazioni`
  ADD CONSTRAINT `comunicazioni_ibfk_1` FOREIGN KEY (`idTipo`) REFERENCES `tipicomunicazione` (`idTipo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `comunicazioni_ibfk_2` FOREIGN KEY (`idUtente`) REFERENCES `utenti` (`idUtente`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `documenti`
--
ALTER TABLE `documenti`
  ADD CONSTRAINT `documenti_ibfk_1` FOREIGN KEY (`idUtente`) REFERENCES `utenti` (`idUtente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `eventiprogrammati`
--
ALTER TABLE `eventiprogrammati`
  ADD CONSTRAINT `eventiprogrammati_ibfk_1` FOREIGN KEY (`idMezzo`) REFERENCES `mezzi` (`idMezzo`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `turni118`
--
ALTER TABLE `turni118`
  ADD CONSTRAINT `turni118_ibfk_1` FOREIGN KEY (`idMezzo`) REFERENCES `mezzi` (`idMezzo`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `turniutenti`
--
ALTER TABLE `turniutenti`
  ADD CONSTRAINT `turniutenti_ibfk_1` FOREIGN KEY (`idTurno118`) REFERENCES `turni118` (`idTurno118`) ON UPDATE CASCADE,
  ADD CONSTRAINT `turniutenti_ibfk_2` FOREIGN KEY (`idEventoProgrammato`) REFERENCES `eventiprogrammati` (`idEventoProgrammato`) ON UPDATE CASCADE,
  ADD CONSTRAINT `turniutenti_ibfk_3` FOREIGN KEY (`idAssistenza`) REFERENCES `assistenze` (`idAssistenza`) ON UPDATE CASCADE,
  ADD CONSTRAINT `turniutenti_ibfk_4` FOREIGN KEY (`idRuolo`) REFERENCES `ruoli` (`idRuolo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `turniutenti_ibfk_5` FOREIGN KEY (`idUtente`) REFERENCES `utenti` (`idUtente`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `utenticomunicazioni`
--
ALTER TABLE `utenticomunicazioni`
  ADD CONSTRAINT `utenticomunicazioni_ibfk_1` FOREIGN KEY (`idUtente`) REFERENCES `utenti` (`idUtente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `utenticomunicazioni_ibfk_2` FOREIGN KEY (`idComunicazione`) REFERENCES `comunicazioni` (`idComunicazione`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `utentiruoli`
--
ALTER TABLE `utentiruoli`
  ADD CONSTRAINT `utentiruoli_ibfk_1` FOREIGN KEY (`idRuolo`) REFERENCES `ruoli` (`idRuolo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `utentiruoli_ibfk_2` FOREIGN KEY (`idUtente`) REFERENCES `utenti` (`idUtente`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
