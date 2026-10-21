<?php include '../conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset='UTF-8'>
<title>Gestión de Calificaciones</title>
<style>
body{font-family:Arial;margin:20px;background:#f8f9fa}
.contenedor{max-width:700px;margin:0 auto}
h1{text-align:center;color:#2c3e50;margin-bottom:30px}
.opcion{background:#fff;padding:20px;margin-bottom:15px;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1)}
.opcion a{font-size:18px;color:#2980b9;text-decoration:none;font-weight:bold;display:block;margin-bottom:5px}
.opcion p{color:#7f8c8d;margin:0}
a.volver{display:inline-block;margin-top:20px;background:#2c3e50;color:#fff;padding:10px 20px;border-radius:4px;text-decoration:none}
a.volver:hover{background:#34495e}
</style>
</head>
<body>

<div class="contenedor">
<h1>📋 Gestión de Calificaciones</h1>

<div class="opcion">
    <a href="../registro/calificacion.php">✏️ Registrar Calificación</a>
    <p>Ingresa calificaciones por alumno, materia, unidad y ciclo escolar.</p>
</div>

<div class="opcion">
    <a href="CAPTURA DE CALIFICACIONES/captura_individual.php">📝 Captura Individual</a>
    <p>Formulario detallado para registro y actualización de calificaciones.</p>
</div>

<div class="opcion">
    <a href="CAPTURA DE CALIFICACIONES/captura_masiva.php">📊 Captura Masiva</a>
    <p>Registra calificaciones de varios alumnos al mismo tiempo.</p>
</div>

<div class="opcion">
    <a href="alumnos.php">👤 Alumnos</a>
    <p>Consulta y administra los alumnos registrados.</p>
</div>

<div class="opcion">
    <a href="grupos.php">👥 Grupos</a>
    <p>Gestión de grupos y asignación de alumnos.</p>
</div>

<div class="opcion">
    <a href="materias.php">📚 Materias</a>
    <p>Catálogo de materias del plan de estudios.</p>
</div>

<div class="opcion">
    <a href="profesores.php">👨‍🏫 Profesores</a>
    <p>Registro y asignación de docentes.</p>
</div>

<a href="../index.php" class="volver">← Volver al Inicio</a>
</div>

</body>
</html>