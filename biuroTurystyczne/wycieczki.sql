-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 01 Gru 2020, 19:07
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `wycieczki`
--
CREATE DATABASE IF NOT EXISTS `wycieczki` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE `wycieczki`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `ID_uzytkownika` int(11) NOT NULL,
  `Imie` varchar(25) COLLATE utf8_polish_ci NOT NULL,
  `Nazwisko` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `Data_urodzenia` date NOT NULL,
  `Haslo` char(255) COLLATE utf8_polish_ci NOT NULL,
  `Data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`ID_uzytkownika`, `Imie`, `Nazwisko`, `Email`, `Data_urodzenia`, `Haslo`, `Data`) VALUES
(7, 'Jakub', 'Augustyn', 'kub4a1@gmail.com', '2001-11-05', '$2y$10$WgGeJLZ5Q4ThmLYpwg9aLeW7a6LAFdIgJ8Gasz.P2nPink5PCGvU.', '2020-11-16 19:10:09'),
(8, 'Daria', 'Kowalska', 'DariaK@wp.pl', '1999-08-11', '$2y$10$aNDZWCBLuMZ9VgpDQiVzdu3125v.rUjs9WvpcvaRdJT0kDXZOUCi2', '2020-11-16 20:06:45'),
(9, 'Mia', 'Kaj', 'MiaKaj@gmail.com', '2002-12-31', '$2y$10$SRV7UnlMbKTcm62KUz6GBuMtEQvKHHOeOMPhV1SQvur12fg8G9xm6', '2020-11-16 20:08:17'),
(10, 'Filip', 'Grzegorzek', 'filipek@interia.pl', '1990-03-20', '$2y$10$GHfThMwNWdmfxwW4o2xJ1eWT7H3iiuG8iwmfuvbvj1ERfaPtqAOOm', '2020-11-16 20:09:15'),
(14, 'test', 'nazwsiag', 'test@test.pl', '2020-10-07', '$2y$10$HNzz8qfsIjioJbdr/zJWWuzYEU9ilq.NJ3C4GIBOrqn/VHFhKI.SW', '2020-11-17 21:43:44'),
(35, 'test', 'nazwsiag', 'test22@test.pl', '2020-10-07', '$2y$10$3MRBNPWw7b4zP.xG4b1EVO1FjCM0kRXunaD2DoTnDYLK187puden6', '2020-11-19 13:42:32');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wycieczki`
--

CREATE TABLE `wycieczki` (
  `ID_wycieczki` int(11) NOT NULL,
  `Nazwa` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `Miejsca` int(11) UNSIGNED NOT NULL,
  `AktualnaIloscMiejsc` int(11) UNSIGNED NOT NULL,
  `Cena` decimal(10,2) NOT NULL,
  `Data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `wycieczki`
--

INSERT INTO `wycieczki` (`ID_wycieczki`, `Nazwa`, `Miejsca`, `AktualnaIloscMiejsc`, `Cena`, `Data`) VALUES
(1, 'Grecja', 25, 20, '1500.00', '2021-07-22'),
(2, 'Karaiby', 1, 0, '10000.00', '2021-09-08'),
(3, 'Słowacja', 50, 48, '3777.00', '2021-06-29'),
(4, 'Peru', 15, 13, '5000.00', '2021-05-01'),
(5, 'Paryż', 10, 10, '2500.00', '2021-02-20'),
(6, 'Drwinia', 5, 4, '150.00', '2021-08-27');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zapisaninawycieczki`
--

CREATE TABLE `zapisaninawycieczki` (
  `ID_wpisu` int(11) NOT NULL,
  `ID_uzytkownika` int(11) NOT NULL,
  `ID_wycieczki` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zapisaninawycieczki`
--

INSERT INTO `zapisaninawycieczki` (`ID_wpisu`, `ID_uzytkownika`, `ID_wycieczki`) VALUES
(18, 7, 2),
(19, 7, 1),
(20, 7, 4),
(21, 8, 1),
(22, 8, 3),
(23, 8, 4),
(24, 9, 1),
(25, 9, 3),
(27, 10, 6),
(28, 10, 1),
(29, 35, 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`ID_uzytkownika`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indeksy dla tabeli `wycieczki`
--
ALTER TABLE `wycieczki`
  ADD PRIMARY KEY (`ID_wycieczki`);

--
-- Indeksy dla tabeli `zapisaninawycieczki`
--
ALTER TABLE `zapisaninawycieczki`
  ADD PRIMARY KEY (`ID_wpisu`),
  ADD KEY `ID_uzytkownika` (`ID_uzytkownika`),
  ADD KEY `ID_wycieczki` (`ID_wycieczki`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `ID_uzytkownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT dla tabeli `wycieczki`
--
ALTER TABLE `wycieczki`
  MODIFY `ID_wycieczki` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `zapisaninawycieczki`
--
ALTER TABLE `zapisaninawycieczki`
  MODIFY `ID_wpisu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `zapisaninawycieczki`
--
ALTER TABLE `zapisaninawycieczki`
  ADD CONSTRAINT `zapisaninawycieczki_ibfk_1` FOREIGN KEY (`ID_uzytkownika`) REFERENCES `uzytkownicy` (`ID_uzytkownika`),
  ADD CONSTRAINT `zapisaninawycieczki_ibfk_2` FOREIGN KEY (`ID_wycieczki`) REFERENCES `wycieczki` (`ID_wycieczki`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
