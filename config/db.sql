-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Tempo de geração: 23/10/2019 às 13:13
-- Versão do servidor: 5.7.26
-- Versão do PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Banco de dados: `cats`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `Cats`
--

CREATE TABLE `Cats` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `Cats`
--

INSERT INTO `Cats` (`id`, `name`, `color`) VALUES
(35, 'Garfield ', 'Laranja'),
(36, 'Felix', 'Cinza');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `Cats`
--
ALTER TABLE `Cats`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `Cats`
--
ALTER TABLE `Cats`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
