-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2026 a las 10:15:00
-- Versión del servidor: 10.11.16-MariaDB
-- Versión de PHP: 8.3.36

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
  `matricula` varchar(20) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `apaterno` varchar(80) NOT NULL,
  `amaterno` varchar(80) NOT NULL,
  `dom` varchar(150) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `tutor` varchar(120) NOT NULL,
  `estatus` varchar(15) NOT NULL DEFAULT 'Activo',
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `matricula`, `nombre`, `apaterno`, `amaterno`, `dom`, `mail`, `tel`, `tutor`, `estatus`, `fecha_baja`) VALUES
(1, 'ESC202601', 'Jimena', 'Linares', 'Cruz', 'Av. Instituto Tecnológico 100', 'jimena.linares@escuela.edu.mx', '5511223344', 'Isabel', 'Activo', NULL),
(2, 'ESC202602', 'Sofia', 'Ramirez', 'Ortega', 'Calle Reforma 45', 'sofia.ramirez@escuela.edu.mx', '5522334455', 'María ', 'Activo', NULL),
(3, 'ESC202603', 'Mateo', 'Vargas', 'Solis', 'Av. Juárez 210', 'mateo.vargas@escuela.edu.mx', '5533445566', 'Daniela ', 'Activo', NULL),
(4, 'ESC202604', 'Valeria', 'Mendoza', 'Paz', 'Calle Hidalgo 88', 'valeria.mendoza@escuela.edu.mx', '5544556677', 'Candido ', 'Inactivo', '2026-11-15 16:10:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones`
--

CREATE TABLE `asignaciones` (
  `id` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_profesor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaciones`
--

INSERT INTO `asignaciones` (`id`, `id_materia`, `id_alumno`, `id_profesor`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 2),
(3, 1, 2, 1),
(4, 1, 3, 1),
(5, 3, 4, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `calificacion` decimal(4,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificaciones`
--

INSERT INTO `calificaciones` (`id`, `id_alumno`, `id_materia`, `id_unidad`, `calificacion`) VALUES
(1, 1, 1, 1, 8.0),
(2, 1, 1, 2, 10.0),
(3, 1, 2, 1, 9.0),
(4, 2, 1, 1, 8.5),
(5, 3, 1, 1, 9.0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `clave_grupo` varchar(20) NOT NULL,
  `nombre_grupo` varchar(100) NOT NULL,
  `turno` varchar(20) NOT NULL,
  `estatus` varchar(15) NOT NULL DEFAULT 'Activo',
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `clave_grupo`, `nombre_grupo`, `turno`, `estatus`, `fecha_baja`) VALUES
(1, 'TIC-4A', 'Cuarto Semestre Grupo A', 'Matutino', 'Inactivo', '2026-11-16 00:33:04'),
(2, 'TIC-4B', 'Cuarto Semestre Grupo B', 'Vespertino', 'Activo', NULL),
(3, 'TIC-5A', 'Quinto Semestre Grupo A', 'Matutino', 'Activo', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `estatus` varchar(15) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id`, `id_grupo`, `id_alumno`, `estatus`) VALUES
(1, 1, 1, 'Activo'),
(2, 1, 2, 'Activo'),
(3, 1, 3, 'Activo'),
(4, 2, 4, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `clave_mat` varchar(20) NOT NULL,
  `nombre_mat` varchar(100) NOT NULL,
  `creditos` int(11) NOT NULL,
  `estatus` varchar(15) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `clave_mat`, `nombre_mat`, `creditos`, `estatus`) VALUES
(1, 'PRG-202', 'Programación Web II', 5, 'Activo'),
(2, 'BDD-301', 'Administración de Bases de Datos', 5, 'Activo'),
(3, 'RED-104', 'Redes y Telecomunicaciones', 4, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `clave` varchar(20) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `apaterno` varchar(80) NOT NULL,
  `amaterno` varchar(80) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `estatus` varchar(15) NOT NULL DEFAULT 'Activo',
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `clave`, `nombre`, `apaterno`, `amaterno`, `mail`, `tel`, `estatus`, `fecha_baja`) VALUES
(1, 'DOC-01', 'Laura', 'Gomez', 'Ibarra', 'laura.gomez@escuela.edu.mx', '5588990011', 'Inactivo', '2026-11-16 00:13:06'),
(2, 'DOC-02', 'Roberto', 'Sanchez', 'Pena', 'roberto.sanchez@escuela.edu.mx', '5588990022', 'Activo', NULL),
(3, 'DOC-03', 'Elena', 'Vargas', 'Cruz', 'elena.vargas@escuela.edu.mx', '5588990033', 'Activo', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos`
--

CREATE TABLE `puestos` (
  `id` int(11) NOT NULL,
  `nombre_puesto` varchar(80) NOT NULL,
  `estatus` varchar(15) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `puestos`
--

INSERT INTO `puestos` (`id`, `nombre_puesto`, `estatus`) VALUES
(1, 'Administrador del Sistema', 'Activo'),
(2, 'Docente Titular', 'Activo'),
(3, 'Control Escolar', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `nombre_unidad` varchar(100) NOT NULL,
  `estatus` varchar(15) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `nombre_unidad`, `estatus`) VALUES
(1, 'Unidad 1 - Fundamentos', 'Activo'),
(2, 'Unidad 2 - Desarrollo', 'Activo'),
(3, 'Unidad 3 - Proyecto Final', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(120) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `id_puesto` int(11) NOT NULL,
  `estatus` varchar(15) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_completo`, `usuario`, `password`, `id_puesto`, `estatus`) VALUES
(1, 'Jimena Linares Cruz', 'jimena.admin', '8cb2237d0679ca88db6464eac60da96345513964', 1, 'Activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `puestos`
--
ALTER TABLE `puestos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
