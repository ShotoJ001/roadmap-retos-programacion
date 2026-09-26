-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 26-09-2026 a las 07:57:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Escuela`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apaterno` varchar(100) NOT NULL,
  `amaterno` varchar(100) DEFAULT NULL,
  `dom` varchar(255) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `id_grupo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `nombre`, `apaterno`, `amaterno`, `dom`, `mail`, `tel`, `id_grupo`) VALUES
(1, 'Jimena', 'Linares', 'Cruz', 'colocio ', 'jimenalinares@gmail.com', '5512259318', 'A11'),
(2, 'Maria Jose', 'Linares', 'Cruz', 'Guadalupe', 'mari.j.linares22@gmail.com', '5512331192', 'A11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupo` int(11) NOT NULL,
  `nombre_alumno` varchar(100) NOT NULL,
  `grupo` varchar(50) NOT NULL,
  `matricula` varchar(50) NOT NULL,
  `carrera` varchar(100) DEFAULT NULL,
  `semestre` varchar(20) DEFAULT NULL,
  `estatus_grupo` varchar(20) DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `nombre_alumno`, `grupo`, `matricula`, `carrera`, `semestre`, `estatus_grupo`) VALUES
(1, 'jimena ', 'A11', '20260001', 'TICS', '4', 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_mat` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `id_prof` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_mat`, `descripcion`, `id_prof`) VALUES
(1, 'Matematicas ', 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id_prof` int(11) NOT NULL,
  `nom_prof` varchar(50) NOT NULL,
  `apaterno_prof` varchar(50) NOT NULL,
  `amaterno_prof` varchar(50) DEFAULT NULL,
  `dom_prof` varchar(255) DEFAULT NULL,
  `mail_prof` varchar(100) DEFAULT NULL,
  `tel_prof` varchar(20) DEFAULT NULL,
  `estatus_prof` varchar(20) DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id_prof`, `nom_prof`, `apaterno_prof`, `amaterno_prof`, `dom_prof`, `mail_prof`, `tel_prof`, `estatus_prof`) VALUES
(1, 'Carlos', 'Ramírez', 'Gómez', NULL, NULL, NULL, 'Activo'),
(2, 'María', 'López', 'Martínez', NULL, NULL, NULL, 'Activo'),
(3, 'Juan', 'Pérez', 'Hernández', NULL, NULL, NULL, 'Activo'),
(4, 'Ana', 'García', 'Vargas', NULL, NULL, NULL, 'Activo'),
(5, 'Luis', 'Martínez', 'Torres', NULL, NULL, NULL, 'Activo'),
(6, 'Sofía', 'Rodríguez', 'Cruz', NULL, NULL, NULL, 'Activo'),
(7, 'Pedro', 'Fernández', 'Luna', NULL, NULL, NULL, 'Activo'),
(8, 'Isabel', 'Díaz', 'Ruiz', NULL, NULL, NULL, 'Activo'),
(9, 'Jorge', 'Álvarez', 'Reyes', NULL, NULL, NULL, 'Activo'),
(10, 'Carmen', 'Moreno', 'Ortiz', NULL, NULL, NULL, 'Activo'),
(11, 'Miguel', 'Ruiz', 'Mendoza', NULL, NULL, NULL, 'Activo'),
(12, 'Laura', 'Jiménez', 'Castillo', NULL, NULL, NULL, 'Activo'),
(13, 'José', 'Torres', 'Navarro', NULL, NULL, NULL, 'Activo'),
(14, 'Patricia', 'Gómez', 'Soto', NULL, NULL, NULL, 'Activo'),
(15, 'Francisco', 'Castro', 'Rojas', NULL, NULL, NULL, 'Activo'),
(16, 'Verónica', 'Vargas', 'Medina', NULL, NULL, NULL, 'Activo'),
(17, 'Daniel', 'Hernández', 'Aguilar', NULL, NULL, NULL, 'Activo'),
(18, 'Gabriela', 'Sánchez', 'Domínguez', NULL, NULL, NULL, 'Activo'),
(19, 'Alejandro', 'Castillo', 'Flores', NULL, NULL, NULL, 'Activo'),
(20, 'Diana', 'Romero', 'Silva', NULL, NULL, NULL, 'Activo'),
(21, 'Roberto', 'Mendoza', 'Cervantes', NULL, NULL, NULL, 'Activo'),
(22, 'Mónica', 'Aguilar', 'Delgado', NULL, NULL, NULL, 'Activo'),
(23, 'Manuel', 'Flores', 'Velázquez', NULL, NULL, NULL, 'Activo'),
(24, 'Silvia', 'Ortiz', 'Córdoba', NULL, NULL, NULL, 'Activo'),
(25, 'Rafael', 'Domínguez', 'Montoya', NULL, NULL, NULL, 'Activo'),
(26, 'Lucía', 'Reyes', 'Ponce', NULL, NULL, NULL, 'Activo'),
(27, 'Fernando', 'Navarro', 'Guzmán', NULL, NULL, NULL, 'Activo'),
(28, 'Elena', 'Luna', 'Valencia', NULL, NULL, NULL, 'Activo'),
(29, 'Alberto', 'Cruz', 'Escalante', NULL, NULL, NULL, 'Activo'),
(30, 'Adriana', 'Rojas', 'Palacios', NULL, NULL, NULL, 'Activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_mat`),
  ADD KEY `id_prof` (`id_prof`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id_prof`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_mat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id_prof` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `materias_ibfk_1` FOREIGN KEY (`id_prof`) REFERENCES `profesores` (`id_prof`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
