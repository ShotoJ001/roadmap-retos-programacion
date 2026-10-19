-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 19-10-2026 a las 14:15:56
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
  `id_grupo` int(11) DEFAULT NULL,
  `estatus` varchar(20) DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `nombre`, `apaterno`, `amaterno`, `dom`, `mail`, `tel`, `id_grupo`, `estatus`) VALUES
(1, 'Jimena', 'Linares', 'Cruz', 'Guadalupe', 'jimenalinares04@gmail.com', '5512759316', 3, 'Activo'),
(2, 'Maria Jose', 'Linares', 'Cruz', 'colocio', 'mari.j.linares22@gmail.com', '5512331192', 5, 'Activo'),
(3, 'Fernanda ', 'Lopez ', 'Martinez ', 'francisco y madero ', 'fernanda.lopema@gmail.com', '5548321937', 3, 'Inactivo'),
(4, 'Daniela ', 'Dominguez ', 'Hernandez ', 'Guadalupe', 'daniela@gmail.com', '5544663322', 3, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_materias`
--

CREATE TABLE `asignacion_materias` (
  `id_asignacion` int(11) NOT NULL,
  `id_mat` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_prof` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignacion_materias`
--

INSERT INTO `asignacion_materias` (`id_asignacion`, `id_mat`, `id_alumno`, `id_prof`) VALUES
(1, 3, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id_calif` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_mat` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `calificacion` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificaciones`
--

INSERT INTO `calificaciones` (`id_calif`, `id_alumno`, `id_mat`, `id_unidad`, `id_ciclo`, `calificacion`) VALUES
(1, 4, 3, 1, 1, 9.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciclos`
--

CREATE TABLE `ciclos` (
  `id_ciclo` int(11) NOT NULL,
  `nombre_ciclo` varchar(50) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estatus_ciclo` varchar(20) DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciclos`
--

INSERT INTO `ciclos` (`id_ciclo`, `nombre_ciclo`, `fecha_inicio`, `fecha_fin`, `estatus_ciclo`) VALUES
(1, '2025-2030', '0000-00-00', '0000-00-00', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupo` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `grupo` varchar(50) NOT NULL,
  `matricula` varchar(50) NOT NULL,
  `carrera` varchar(100) NOT NULL,
  `semestre` varchar(20) NOT NULL,
  `estatus_grupo` varchar(20) DEFAULT 'Activo',
  `estatus` varchar(20) DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `Nombre`, `grupo`, `matricula`, `carrera`, `semestre`, `estatus_grupo`, `estatus`) VALUES
(3, 'Jimena', 'A11', '20260001', 'TICS', '4', 'Activo', 'Activo'),
(5, 'DANIELA', 'B02', '10160002', 'Arquitectura', '1', 'Inactivo', 'Inactivo'),
(6, 'ISABEL ', 'C03', '50260001', 'CIVIL ', '03', 'Activo', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id_ins` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `status_ins` varchar(20) DEFAULT 'ACTA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id_ins`, `id_grupo`, `id_alumno`, `status_ins`) VALUES
(1, 3, 1, 'ACTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_mat` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL COMMENT 'Nombre de la materia',
  `clave_mat` varchar(20) NOT NULL COMMENT 'Clave de la materia',
  `creditos` int(11) NOT NULL COMMENT 'Número de créditos',
  `id_prof` int(11) DEFAULT NULL COMMENT 'Profesor asignado',
  `estatus` varchar(20) DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_mat`, `descripcion`, `clave_mat`, `creditos`, `id_prof`, `estatus`) VALUES
(1, 'taller de datos', 'TALLER-DATOS001', 1, 1, 'Activo'),
(3, 'INGENIERÍA DE SOFTWARE', 'inge-001', 3, NULL, 'Inactivo');

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
  `estatus_prof` varchar(20) DEFAULT 'Activo',
  `estatus` varchar(20) DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id_prof`, `nom_prof`, `apaterno_prof`, `amaterno_prof`, `dom_prof`, `mail_prof`, `tel_prof`, `estatus_prof`, `estatus`) VALUES
(1, 'IGNACIO', 'Domingues', 'Hernandez', 'ECATEPEC', 'IGNACIO@GMAIL.COM', '5522110033', 'Activo', 'Activo'),
(3, 'Enrique', 'MONTEJO', 'HERNANDEZ', 'ECATEPEC', 'enrique@gmail.com', '5577889922', 'Activo', 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id_unidad` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id_unidad`, `descripcion`) VALUES
(1, 'Unidad 1'),
(2, 'Unidad 1'),
(3, 'Unidad 1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indices de la tabla `asignacion_materias`
--
ALTER TABLE `asignacion_materias`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD UNIQUE KEY `uk_asignacion` (`id_mat`,`id_alumno`),
  ADD KEY `id_alumno` (`id_alumno`),
  ADD KEY `id_prof` (`id_prof`);

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id_calif`),
  ADD UNIQUE KEY `unico` (`id_alumno`,`id_mat`,`id_ciclo`),
  ADD KEY `id_mat` (`id_mat`),
  ADD KEY `id_ciclo` (`id_ciclo`);

--
-- Indices de la tabla `ciclos`
--
ALTER TABLE `ciclos`
  ADD PRIMARY KEY (`id_ciclo`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id_ins`),
  ADD UNIQUE KEY `uk_inscripcion` (`id_grupo`,`id_alumno`),
  ADD KEY `id_alumno` (`id_alumno`);

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
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id_unidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `asignacion_materias`
--
ALTER TABLE `asignacion_materias`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id_calif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ciclos`
--
ALTER TABLE `ciclos`
  MODIFY `id_ciclo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id_ins` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_mat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id_prof` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id_unidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignacion_materias`
--
ALTER TABLE `asignacion_materias`
  ADD CONSTRAINT `asignacion_materias_ibfk_1` FOREIGN KEY (`id_mat`) REFERENCES `materias` (`id_mat`),
  ADD CONSTRAINT `asignacion_materias_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `asignacion_materias_ibfk_3` FOREIGN KEY (`id_prof`) REFERENCES `profesores` (`id_prof`);

--
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calificaciones_ibfk_2` FOREIGN KEY (`id_mat`) REFERENCES `materias` (`id_mat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calificaciones_ibfk_3` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclos` (`id_ciclo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`),
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id`);

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `materias_ibfk_1` FOREIGN KEY (`id_prof`) REFERENCES `profesores` (`id_prof`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
