-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 31.11.39.60:3306
-- Creato il: Lug 16, 2023 alle 04:52
-- Versione del server: 5.7.33-36-log
-- Versione PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Sql1566603_1`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(5, 'Lingua e letteratura italiana', '2023-05-03 15:25:05'),
(6, 'Lingua e cultura latina e greca', '2023-05-03 15:25:05'),
(7, 'Lingue e culture straniere', '2023-05-03 15:25:05'),
(8, 'Storia', '2023-05-03 15:25:05'),
(9, 'Geografia', '2023-05-03 15:25:05'),
(10, 'Filosofia e scienze umane', '2023-05-03 15:25:05'),
(11, 'Storia dell\'arte', '2023-05-03 15:25:05'),
(12, 'Diritto ed economia', '2023-05-03 15:25:05'),
(13, 'Matematica', '2023-05-03 15:25:05'),
(14, 'Fisica', '2023-05-03 15:25:05'),
(15, 'Scienze naturali', '2023-05-03 15:25:05'),
(16, 'Scienze integrate', '2023-05-03 15:25:05'),
(17, 'Informatica', '2023-05-03 15:25:05'),
(18, 'Tecnologie e tecniche di rappresentazione grafica', '2023-05-03 15:25:05');

-- --------------------------------------------------------

--
-- Struttura della tabella `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `hash` text NOT NULL,
  `user` int(11) NOT NULL,
  `slang` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL,
  `visibility` int(11) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `create_at`, `author`, `visibility`, `category`) VALUES
(11, 'Database', '<p id=\"isPasted\">I database sono una raccolta di dati organizzati in modo da poter essere facilmente accessibili, gestiti e aggiornati. Ci sono diversi tipi di database, tra cui i database relazionali, i database non relazionali e i database di grafo.</p><p>I database sono ampiamente utilizzati in diversi settori, tra cui il commercio elettronico, la finanza, la gestione delle risorse umane e la logistica. Consentono di archiviare grandi quantit&agrave; di dati in modo efficiente e di recuperarli rapidamente quando necessario.</p><p>Per creare un database, &egrave; necessario definire la struttura dei dati, ovvero i campi e le tabelle che verranno utilizzati. &Egrave; anche importante definire le regole per l&#39;accesso ai dati, in modo da garantire la sicurezza e la privacy.</p><p>Per accedere ai dati presenti in un database, &egrave; possibile utilizzare un linguaggio di interrogazione come SQL (Structured Query Language). SQL consente di selezionare, aggiornare e cancellare i dati presenti nel database.</p><p>La gestione dei database richiede un certo livello di competenza tecnica, ma ci sono anche strumenti e piattaforme che semplificano la creazione e la gestione dei database.</p>', '2023-05-06 15:12:15', 38, 0, 17),
(13, 'AutoCAD: Il potente alleato per il design e l\'ingegneria', '<p id=\"isPasted\">AutoCAD &egrave; uno dei software pi&ugrave; utilizzati nel campo del design e dell&#39;ingegneria edile. Sviluppato da Autodesk, AutoCAD offre una vasta gamma di strumenti per la creazione di disegni tecnici e modelli 3D.</p><p>AutoCAD si distingue per la sua interfaccia intuitiva e le sue potenti funzionalit&agrave;. Consente agli utenti di creare disegni precisi e dettagliati utilizzando strumenti di disegno come linee, cerchi, polilinee e poligoni. I comandi di modifica, come spostamento, copia e ruotamento, consentono di apportare modifiche ai disegni in modo rapido ed efficiente.</p><p>Una delle caratteristiche pi&ugrave; apprezzate di AutoCAD &egrave; la possibilit&agrave; di lavorare con disegni in 3D. Il software permette di creare oggetti tridimensionali utilizzando comandi di modellazione e di visualizzare i modelli da diverse prospettive. Ci&ograve; consente agli utenti di ottenere una migliore comprensione degli spazi e delle forme tridimensionali prima ancora che vengano realizzate fisicamente.</p><p>Oltre alla creazione di disegni e modelli, AutoCAD offre anche funzionalit&agrave; avanzate come l&#39;annotazione e l&#39;etichettatura dei disegni, la generazione di tavole e la gestione dei livelli. Queste caratteristiche consentono agli utenti di organizzare e documentare i loro progetti in modo accurato e professionale.</p><p>AutoCAD supporta anche l&#39;importazione e l&#39;esportazione di file in diversi formati, consentendo la collaborazione con altri software e professionisti del settore. Inoltre, il software offre la possibilit&agrave; di personalizzare l&#39;interfaccia e i comandi, adattandoli alle specifiche esigenze dell&#39;utente.</p><p>Grazie alla sua versatilit&agrave; e alle sue numerose funzionalit&agrave;, AutoCAD viene utilizzato in vari settori, tra cui architettura, ingegneria civile, meccanica e design industriale. Fornisce un ambiente di lavoro efficiente e preciso per la realizzazione di progetti complessi e di alta qualit&agrave;.</p>', '2023-06-20 12:01:08', 38, 0, 18);

-- --------------------------------------------------------

--
-- Struttura della tabella `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tax_code` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `schools`
--

INSERT INTO `schools` (`id`, `name`, `tax_code`) VALUES
(2, 'PIETRO GIANNONE LIC.CL. BN Benevento - CM BNPC02000N', 'BNPC02000N'),
(3, 'IM G.GUACCI BENEVENTO Benevento - CM BNPM02000T', 'BNPM02000T'),
(4, 'G.RUMMO LIC.SC. BENEVENTO Benevento - CM BNPS010006', 'BNPS010006'),
(5, 'I.I.S. \"G. ALBERTI\" BN Benevento - CM BNPS01401E', 'BNPS01401E'),
(6, 'I.S. \"G. GALILEI\" - \"M. VETRONE\" Benevento - CM BNPS016016', 'BNPS016016'),
(7, 'I.S. \"G. GALILEI\" - \"M. VETRONE\" Benevento - CM BNRA01601Q', 'BNRA01601Q'),
(8, 'I.S. \"LE STREGHE\" - \"M. POLO\" Benevento - CM BNRC01801A', 'BNRC01801A'),
(9, 'I.S. \"LE STREGHE\" - \"M. POLO\" Benevento - CM BNRH01801G', 'BNRH01801G'),
(10, 'L.PALMIERI IPIA BN Benevento - CM BNRI01000B', 'BNRI01000B'),
(11, 'BENEVENTO LICEO ARTIST. Benevento - CM BNSL010003', 'BNSL010003'),
(12, 'BENEVENTO CONSERV.MUS. Benevento - CM BNST020003', 'BNST020003'),
(13, 'I.S. \"G. GALILEI\" - \"M. VETRONE\" Benevento - CM BNTA01601G', 'BNTA01601G'),
(14, 'ALESSANDRO LOMBARDI Benevento - CM BNTD008013', 'BNTD008013'),
(15, 'I.I.S. \"G. ALBERTI\" BN Benevento - CM BNTD01401A', 'BNTD01401A'),
(16, 'ISTITUTO D\'ISTRUZIONE SUPERIORE RAMPONE Benevento - CM BNTD024011', 'BNTD024011'),
(17, 'G.B.LUCARELLI ITIS BN Benevento - CM BNTF010008', 'BNTF010008'),
(18, 'I.I.S. \"G. ALBERTI\" BN Benevento - CM BNTF01401L', 'BNTF01401L'),
(19, 'ISTITUTO D\'ISTRUZIONE SUPERIORE RAMPONE Benevento - CM BNTF024017', 'BNTF024017'),
(20, 'I.S. \"G. GALILEI\" - \"M. VETRONE\" Benevento - CM BNTL01601C', 'BNTL01601C'),
(21, 'P.GIANNONE CONV.NAZ. BN Benevento - CM BNVC01000A', 'BNVC01000A'),
(22, 'D.D. BENEVENTO - 3 CIRCOLO Benevento - CM BNCT704006', 'BNCT704006'),
(23, 'I.C. G.B. LUCARELLI BENEVENTO Benevento - CM BNCT717008', 'BNCT717008');

-- --------------------------------------------------------

--
-- Struttura della tabella `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `sessions`
--

INSERT INTO `sessions` (`id`, `session_id`, `user_id`) VALUES
(24, 'e11opc2o9286fcjhun89jlf5g1', 38);

-- --------------------------------------------------------

--
-- Struttura della tabella `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `school` int(11) DEFAULT NULL,
  `role` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `password`, `email`, `school`, `role`, `status`, `created_at`, `updated_at`) VALUES
(38, 'Alessandro', 'Masone', '$2y$10$/Go3yywnrisBwyt9DS5qWulpPCxef1UT1JGcE8SGmnKiOQJxVMT9u', 'masonealessandro04@gmail.com', 17, 1, 1, '2023-05-03 16:25:44', '2023-05-04 14:15:20');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes_post_foreign` (`post`),
  ADD KEY `likes_user_foreign` (`user`);

--
-- Indici per le tabelle `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_user_foreign` (`user`);

--
-- Indici per le tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_author_foreign` (`author`),
  ADD KEY `posts_category_foreign` (`category`);

--
-- Indici per le tabelle `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_foreign` (`user_id`);

--
-- Indici per le tabelle `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tokens_user_foreign` (`user_id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_school_foreign` (`school`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT per la tabella `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT per la tabella `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`school`) REFERENCES `schools` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
