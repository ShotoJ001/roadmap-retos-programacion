-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-11-2026 a las 04:07:47
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
(3, 'ESC202603', 'Mateo', 'Vargas', 'Solis', 'Av. Juárez 210', 'mateo.vargas@escuela.edu.mx', '5533445566', 'Daniela ', 'Inactivo', '2026-11-21 23:41:09'),
(4, 'ESC202604', 'Valeria', 'Mendoza', 'Paz', 'Calle Hidalgo 88', 'valeria.mendoza@escuela.edu.mx', '5544556677', 'Candido ', 'Activo', NULL),
(6, 'ESC202584', 'ISABEL', 'LINARES ', 'CRUZ', 'COLOSIO', 'patito@gmail.com', '5512759316', '', 'Activo', NULL);

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
(1, 'TIC-4A', 'Cuarto Semestre Grupo A', 'Matutino', 'Activo', NULL),
(2, 'TIC-4B', 'Cuarto Semestre Grupo B', 'Vespertino', 'Activo', NULL),
(3, 'TIC-5A', 'Quinto Semestre Grupo A', 'Matutino', 'Inactivo', '2026-11-21 23:14:56');

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
(4, 2, 4, 'Activo'),
(5, 3, 3, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `clave_mat` varchar(20) NOT NULL,
  `nombre_mat` varchar(100) NOT NULL,
  `creditos` int(11) NOT NULL,
  `estatus` varchar(15) NOT NULL DEFAULT 'Activo',
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `clave_mat`, `nombre_mat`, `creditos`, `estatus`, `fecha_baja`) VALUES
(1, 'PRG-202', 'Programación Web II', 5, 'Activo', NULL),
(2, 'BDD-301', 'Administración de Bases de Datos', 5, 'Activo', NULL),
(3, 'RED-104', 'Redes y Telecomunicaciones', 4, 'Activo', NULL);

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
(3, 'Control Escolar', 'Activo'),
(4, 'Alumnos ', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `nombre_unidad` varchar(100) NOT NULL,
  `estatus` varchar(15) NOT NULL DEFAULT 'Activo',
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `nombre_unidad`, `estatus`, `fecha_baja`) VALUES
(1, 'Unidad 1 - Fundamentos', 'Activo', NULL),
(2, 'Unidad 2 - Desarrollo', 'Activo', NULL),
(3, 'Unidad 3 - Proyecto Final', 'Activo', NULL);

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
(6, 'Jimena Linares Cruz', 'esc202601', '7c4a8d09ca3762af61e59520943dc26494f8941b', 4, 'Activo'),
(7, 'Sofia Ramirez Ortega', 'esc202602', 'd54b76b2bad9d9946011ebc62a1d272f4122c7b5', 4, 'Activo');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_panel_creador_usuarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_panel_creador_usuarios` (
`id_usuario` int(11)
,`nombre_completo` varchar(120)
,`usuario` varchar(50)
,`id_puesto` int(11)
,`nombre_puesto` varchar(80)
,`estatus` varchar(15)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_reporte_alumno`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_reporte_alumno` (
`id_calificacion` int(11)
,`id_alumno` int(11)
,`matricula` varchar(20)
,`alumno` varchar(242)
,`estatus` varchar(15)
,`id_materia` int(11)
,`clave_mat` varchar(20)
,`materia` varchar(100)
,`id_unidad` int(11)
,`unidad` varchar(100)
,`calificacion` decimal(4,1)
,`id_profesor` int(11)
,`profesor` varchar(242)
,`promedio_alumno` decimal(6,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_reporte_usuario`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_reporte_usuario` (
`id_usuario` int(11)
,`nombre_completo` varchar(120)
,`usuario` varchar(50)
,`estatus_usuario` varchar(15)
,`id_puesto` int(11)
,`nombre_puesto` varchar(80)
,`estatus_puesto` varchar(15)
);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_panel_creador_usuarios`
--
DROP TABLE IF EXISTS `v_panel_creador_usuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_panel_creador_usuarios`  AS SELECT `u`.`id` AS `id_usuario`, `u`.`nombre_completo` AS `nombre_completo`, `u`.`usuario` AS `usuario`, `u`.`id_puesto` AS `id_puesto`, `p`.`nombre_puesto` AS `nombre_puesto`, `u`.`estatus` AS `estatus` FROM (`usuarios` `u` join `puestos` `p` on(`u`.`id_puesto` = `p`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_reporte_alumno`
--
DROP TABLE IF EXISTS `v_reporte_alumno`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_reporte_alumno`  AS SELECT `c`.`id` AS `id_calificacion`, `a`.`id` AS `id_alumno`, `a`.`matricula` AS `matricula`, concat_ws(' ',`a`.`nombre`,`a`.`apaterno`,`a`.`amaterno`) AS `alumno`, `a`.`estatus` AS `estatus`, `m`.`id` AS `id_materia`, `m`.`clave_mat` AS `clave_mat`, `m`.`nombre_mat` AS `materia`, `u`.`id` AS `id_unidad`, `u`.`nombre_unidad` AS `unidad`, `c`.`calificacion` AS `calificacion`, coalesce(`prof`.`id`,0) AS `id_profesor`, coalesce(`prof`.`nombre_profesor`,'Sin asignar') AS `profesor`, round(avg(`c`.`calificacion`) over ( partition by `a`.`id`),2) AS `promedio_alumno` FROM ((((`calificaciones` `c` join `alumnos` `a` on(`c`.`id_alumno` = `a`.`id`)) join `materias` `m` on(`c`.`id_materia` = `m`.`id`)) join `unidades` `u` on(`c`.`id_unidad` = `u`.`id`)) left join (select `asig`.`id_alumno` AS `id_alumno`,`asig`.`id_materia` AS `id_materia`,max(`p`.`id`) AS `id`,max(concat_ws(' ',`p`.`nombre`,`p`.`apaterno`,`p`.`amaterno`)) AS `nombre_profesor` from (`asignaciones` `asig` join `profesores` `p` on(`asig`.`id_profesor` = `p`.`id`)) group by `asig`.`id_alumno`,`asig`.`id_materia`) `prof` on(`prof`.`id_alumno` = `c`.`id_alumno` and `prof`.`id_materia` = `c`.`id_materia`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_reporte_usuario`
--
DROP TABLE IF EXISTS `v_reporte_usuario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_reporte_usuario`  AS SELECT `u`.`id` AS `id_usuario`, `u`.`nombre_completo` AS `nombre_completo`, `u`.`usuario` AS `usuario`, `u`.`estatus` AS `estatus_usuario`, `p`.`id` AS `id_puesto`, `p`.`nombre_puesto` AS `nombre_puesto`, `p`.`estatus` AS `estatus_puesto` FROM (`usuarios` `u` join `puestos` `p` on(`u`.`id_puesto` = `p`.`id`)) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
