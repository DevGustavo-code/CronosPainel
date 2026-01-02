--Banco de Dados do projeto diretamente exportado do phpmyadmin.
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/01/2026 às 14:58
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cronos`
--
-- --------------------------------------------------------
--
-- Estrutura para tabela `contents`
--
CREATE TABLE `contents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `status` enum('nao','andamento','dominado') DEFAULT 'nao',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

--
-- Estrutura para tabela `goals`
--

CREATE TABLE `goals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `period` enum('semana','mes','ano') NOT NULL,
  `hours` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `goals`
--

INSERT INTO `goals` (`id`, `user_id`, `period`, `hours`, `created_at`) VALUES
(1, 2, 'semana', 60, '2026-01-02 12:46:41'),
(3, 1, 'semana', 20, '2026-01-02 13:15:51');

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `token`, `expires_at`, `created_at`) VALUES
(3, 1, 'a9e670486111889459b246f3211fd80b80a620261d8a1cca9604d826be0c7dee', '2026-01-02 15:57:37', '2026-01-02 13:57:37');

-- --------------------------------------------------------

--
-- Estrutura para tabela `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('semanal','mensal') NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pendente','concluido') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `plans`
--

INSERT INTO `plans` (`id`, `user_id`, `type`, `description`, `created_at`, `status`) VALUES
(13, 2, 'semanal', 'php', '2026-01-02 13:08:03', 'pendente'),
(20, 1, 'semanal', 'php', '2026-01-02 13:52:44', 'pendente'),
(21, 1, 'semanal', 'c#', '2026-01-02 13:52:50', 'pendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `study_logs`
--

CREATE TABLE `study_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `hours` decimal(4,2) NOT NULL,
  `study_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `study_logs`
--

INSERT INTO `study_logs` (`id`, `user_id`, `subject`, `hours`, `study_date`, `created_at`) VALUES
(1, 1, 'Estudo Geral', 2.00, '2025-12-30', '2025-12-30 14:31:50'),
(2, 1, 'Estudo Geral', 2.00, '2026-01-02', '2026-01-02 12:40:42'),
(3, 1, 'Estudo Geral', 2.00, '2026-01-02', '2026-01-02 12:41:17'),
(4, 2, 'Estudo Geral', 4.00, '2026-01-02', '2026-01-02 12:46:53'),
(5, 2, 'Estudo Geral', 1.00, '2026-01-01', '2026-01-02 12:47:00'),
(6, 2, 'Estudo Geral', 9.00, '2025-12-02', '2026-01-02 12:47:13'),
(7, 2, 'Estudo Geral', 50.00, '2026-01-03', '2026-01-02 12:47:50'),
(8, 2, 'Estudo Geral', 2.00, '2025-12-02', '2026-01-02 12:48:12'),
(9, 2, 'Estudo Geral', 25.00, '2026-02-02', '2026-01-02 12:52:37'),
(10, 2, 'Estudo Geral', 14.00, '2026-01-02', '2026-01-02 13:04:49');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--
INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'gustavo', 'gustavo@gmail.com', '$2y$10$hnTbZC8rxtc.t7i4cd9yBe6TOy2hK.9Bj85DaFlKmWsIMEiiIf1jC', 'user', '2025-12-30 14:26:01', '2026-01-02 13:52:26'),
(2, 'Roberto', 'pedro@gmail.com', '$2y$10$oX2w.jLe0La6NwQWp07XuuyZANpW3BoiqjN1B99gjoU7Ax/zrWWSa', 'user', '2026-01-02 12:41:53', '2026-01-02 12:41:53');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_content_user` (`user_id`);

--
-- Índices de tabela `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`period`);

--
-- Índices de tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_plan_user` (`user_id`);

--
-- Índices de tabela `study_logs`
--
ALTER TABLE `study_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_study_user` (`user_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `goals`
--
ALTER TABLE `goals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `study_logs`
--
ALTER TABLE `study_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `contents`
--
ALTER TABLE `contents`
  ADD CONSTRAINT `fk_content_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `fk_password_resets_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
--
-- Restrições para tabelas `plans`
--
ALTER TABLE `plans`
  ADD CONSTRAINT `fk_plan_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
--
-- Restrições para tabelas `study_logs`
--
ALTER TABLE `study_logs`
  ADD CONSTRAINT `fk_study_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
