-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 26-Jun-2019 às 10:15
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bibliotecalpaw`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_autores`
--

CREATE TABLE `tb_autores` (
  `idtb_autores` int(11) NOT NULL,
  `nomeAutor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_autores`
--

INSERT INTO `tb_autores` (`idtb_autores`, `nomeAutor`) VALUES
(2, 'Andre'),
(3, 'Kent Beck'),
(4, 'Luiz Nunes');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categoria`
--

CREATE TABLE `tb_categoria` (
  `idtb_categoria` int(11) NOT NULL,
  `nomeCategoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_categoria`
--

INSERT INTO `tb_categoria` (`idtb_categoria`, `nomeCategoria`) VALUES
(1, 'Programacao'),
(2, 'Banco de Dados'),
(3, 'Algoritmos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_editora`
--

CREATE TABLE `tb_editora` (
  `idtb_editora` int(11) NOT NULL,
  `nomeEditora` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_editora`
--

INSERT INTO `tb_editora` (`idtb_editora`, `nomeEditora`) VALUES
(1, 'Casa do Codigo'),
(2, 'Elseveir');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_emprestimo`
--

CREATE TABLE `tb_emprestimo` (
  `tb_usuaio_idtb_usuaio` int(11) NOT NULL,
  `tb_exemplar_idtb_exemplar` int(11) NOT NULL,
  `dataEmprestimo` date NOT NULL,
  `observacao` tinytext,
  `dt_entrega` date DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `vencimento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_emprestimo`
--

INSERT INTO `tb_emprestimo` (`tb_usuaio_idtb_usuaio`, `tb_exemplar_idtb_exemplar`, `dataEmprestimo`, `observacao`, `dt_entrega`, `tipo`, `vencimento`) VALUES
(1, 6, '2019-06-24', '', '2019-06-24', 1, '2019-07-04'),
(1, 7, '0000-00-00', '', NULL, 0, '2019-07-05'),
(1, 8, '2019-05-15', '', NULL, 0, '2019-05-25'),
(4, 7, '2019-06-20', '', '2019-06-24', 1, '2019-07-05');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_exemplar`
--

CREATE TABLE `tb_exemplar` (
  `idtb_exemplar` int(11) NOT NULL,
  `tb_livro_idtb_livro` int(11) NOT NULL,
  `tipoExemplar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_exemplar`
--

INSERT INTO `tb_exemplar` (`idtb_exemplar`, `tb_livro_idtb_livro`, `tipoExemplar`) VALUES
(6, 1, 1),
(7, 2, 1),
(8, 3, 1),
(9, 4, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_livro`
--

CREATE TABLE `tb_livro` (
  `idtb_livro` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `edicao` varchar(4) DEFAULT NULL,
  `ano` year(4) NOT NULL,
  `upload` varchar(255) DEFAULT NULL,
  `tb_editora_idtb_editora` int(11) NOT NULL,
  `tb_categoria_idtb_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_livro`
--

INSERT INTO `tb_livro` (`idtb_livro`, `titulo`, `isbn`, `edicao`, `ano`, `upload`, `tb_editora_idtb_editora`, `tb_categoria_idtb_categoria`) VALUES
(1, 'Teste', '421345662995', '2', 2009, '', 1, 1),
(2, 'PHP do jeito certo', '987654', '2', 2000, '', 1, 1),
(3, 'Desenvolvimento web', '34562345', '3', 2019, '', 1, 1),
(4, 'Test Driven Development', '', '', 1986, 'images.jpg', 1, 1),
(5, 'Test Driven Development', '1234567891011', '2', 1986, '', 1, 1),
(6, 'Test Driven Development', '1234567891054', '1', 1989, 'images.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_livro_autor`
--

CREATE TABLE `tb_livro_autor` (
  `tb_livro_idtb_livro` int(11) NOT NULL,
  `tb_autores_idtb_autores` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_reserva`
--

CREATE TABLE `tb_reserva` (
  `id_reserva` int(11) NOT NULL,
  `idtb_usuaio` int(11) NOT NULL,
  `dataReserva` date NOT NULL,
  `dataVencimento` date DEFAULT NULL,
  `observacao` blob,
  `status` char(1) NOT NULL DEFAULT 'R'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_reserva_usuario`
--

CREATE TABLE `tb_reserva_usuario` (
  `id_reserva` int(11) NOT NULL,
  `idtb_usuaio` int(11) NOT NULL,
  `id_exemplar` int(11) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuaio`
--

CREATE TABLE `tb_usuaio` (
  `idtb_usuaio` int(11) NOT NULL,
  `nomeUsuario` varchar(255) NOT NULL,
  `tipo` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_usuaio`
--

INSERT INTO `tb_usuaio` (`idtb_usuaio`, `nomeUsuario`, `tipo`, `email`, `senha`) VALUES
(1, 'andre.aluno', 1, 'andrelucio2@outlook.com', '202cb962ac59075b964b07152d234b70'),
(3, 'andre.gerente', 5, 'andrelucio.work@gmail.com', '202cb962ac59075b964b07152d234b70'),
(4, 'andre.professor', 2, 'andrelucio2@gmail.com', '202cb962ac59075b964b07152d234b70'),
(5, 'andre.funcionario', 3, 'andre3@gmail.com', '202cb962ac59075b964b07152d234b70'),
(6, 'andre.bibliotecario', 4, 'andre4@gmail.com', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tp_usuario_tb`
--

CREATE TABLE `tp_usuario_tb` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tp_usuario_tb`
--

INSERT INTO `tp_usuario_tb` (`id`, `nome`) VALUES
(1, 'Aluno'),
(2, 'Professor'),
(3, 'Funcionário'),
(4, 'Bibliotecário'),
(5, 'Administrador/Gerente');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_autores`
--
ALTER TABLE `tb_autores`
  ADD PRIMARY KEY (`idtb_autores`);

--
-- Indexes for table `tb_categoria`
--
ALTER TABLE `tb_categoria`
  ADD PRIMARY KEY (`idtb_categoria`);

--
-- Indexes for table `tb_editora`
--
ALTER TABLE `tb_editora`
  ADD PRIMARY KEY (`idtb_editora`);

--
-- Indexes for table `tb_emprestimo`
--
ALTER TABLE `tb_emprestimo`
  ADD PRIMARY KEY (`tb_usuaio_idtb_usuaio`,`tb_exemplar_idtb_exemplar`),
  ADD KEY `fk_tb_usuaio_has_tb_exemplar_tb_exemplar1_idx` (`tb_exemplar_idtb_exemplar`),
  ADD KEY `fk_tb_usuaio_has_tb_exemplar_tb_usuaio1_idx` (`tb_usuaio_idtb_usuaio`);

--
-- Indexes for table `tb_exemplar`
--
ALTER TABLE `tb_exemplar`
  ADD PRIMARY KEY (`idtb_exemplar`),
  ADD KEY `fk_tb_exemplar_tb_livro1_idx` (`tb_livro_idtb_livro`);

--
-- Indexes for table `tb_livro`
--
ALTER TABLE `tb_livro`
  ADD PRIMARY KEY (`idtb_livro`),
  ADD UNIQUE KEY `isbn_UNIQUE` (`isbn`),
  ADD KEY `fk_tb_livro_tb_editora1_idx` (`tb_editora_idtb_editora`),
  ADD KEY `fk_tb_livro_tb_categoria1_idx` (`tb_categoria_idtb_categoria`);

--
-- Indexes for table `tb_livro_autor`
--
ALTER TABLE `tb_livro_autor`
  ADD PRIMARY KEY (`tb_livro_idtb_livro`,`tb_autores_idtb_autores`),
  ADD KEY `fk_tb_livro_has_tb_autores_tb_autores1_idx` (`tb_autores_idtb_autores`),
  ADD KEY `fk_tb_livro_has_tb_autores_tb_livro_idx` (`tb_livro_idtb_livro`);

--
-- Indexes for table `tb_reserva`
--
ALTER TABLE `tb_reserva`
  ADD PRIMARY KEY (`id_reserva`);

--
-- Indexes for table `tb_reserva_usuario`
--
ALTER TABLE `tb_reserva_usuario`
  ADD PRIMARY KEY (`id_reserva`,`idtb_usuaio`,`id_exemplar`);

--
-- Indexes for table `tb_usuaio`
--
ALTER TABLE `tb_usuaio`
  ADD PRIMARY KEY (`idtb_usuaio`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `FK_usuario_X_tp_usuario_T` (`tipo`);

--
-- Indexes for table `tp_usuario_tb`
--
ALTER TABLE `tp_usuario_tb`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_autores`
--
ALTER TABLE `tb_autores`
  MODIFY `idtb_autores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_categoria`
--
ALTER TABLE `tb_categoria`
  MODIFY `idtb_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_editora`
--
ALTER TABLE `tb_editora`
  MODIFY `idtb_editora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_exemplar`
--
ALTER TABLE `tb_exemplar`
  MODIFY `idtb_exemplar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_livro`
--
ALTER TABLE `tb_livro`
  MODIFY `idtb_livro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_reserva`
--
ALTER TABLE `tb_reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_usuaio`
--
ALTER TABLE `tb_usuaio`
  MODIFY `idtb_usuaio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tp_usuario_tb`
--
ALTER TABLE `tp_usuario_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_emprestimo`
--
ALTER TABLE `tb_emprestimo`
  ADD CONSTRAINT `fk_tb_usuaio_has_tb_exemplar_tb_exemplar1` FOREIGN KEY (`tb_exemplar_idtb_exemplar`) REFERENCES `tb_exemplar` (`idtb_exemplar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_usuaio_has_tb_exemplar_tb_usuaio1` FOREIGN KEY (`tb_usuaio_idtb_usuaio`) REFERENCES `tb_usuaio` (`idtb_usuaio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_exemplar`
--
ALTER TABLE `tb_exemplar`
  ADD CONSTRAINT `fk_tb_exemplar_tb_livro1` FOREIGN KEY (`tb_livro_idtb_livro`) REFERENCES `tb_livro` (`idtb_livro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_livro`
--
ALTER TABLE `tb_livro`
  ADD CONSTRAINT `fk_tb_livro_tb_categoria1` FOREIGN KEY (`tb_categoria_idtb_categoria`) REFERENCES `tb_categoria` (`idtb_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_livro_tb_editora1` FOREIGN KEY (`tb_editora_idtb_editora`) REFERENCES `tb_editora` (`idtb_editora`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_livro_autor`
--
ALTER TABLE `tb_livro_autor`
  ADD CONSTRAINT `fk_tb_livro_has_tb_autores_tb_autores1` FOREIGN KEY (`tb_autores_idtb_autores`) REFERENCES `tb_autores` (`idtb_autores`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_livro_has_tb_autores_tb_livro` FOREIGN KEY (`tb_livro_idtb_livro`) REFERENCES `tb_livro` (`idtb_livro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_reserva_usuario`
--
ALTER TABLE `tb_reserva_usuario`
  ADD CONSTRAINT `fk_tb_reserva_usuario_id_emprestimo` FOREIGN KEY (`id_reserva`) REFERENCES `tb_reserva` (`id_reserva`);

--
-- Limitadores para a tabela `tb_usuaio`
--
ALTER TABLE `tb_usuaio`
  ADD CONSTRAINT `FK_usuario_X_tp_usuario_T` FOREIGN KEY (`tipo`) REFERENCES `tp_usuario_tb` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
