<?php
require_once __DIR__ . "/../Config/conexion.php";

$es_directo = (basename($_SERVER['SCRIPT_FILENAME']) === 'navbar.php');

if ($es_directo): ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escuela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php endif; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid px-4">
    <a class="navbar-brand" href="<?= $base ?>/navBar/navbar.php">Escuela</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuEscuela">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menuEscuela">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Catalogo</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= $base ?>/crudregistro/CrudAlumno.php">Alumnos</a></li>
            <li><a class="dropdown-item" href="<?= $base ?>/crudregistro/CrudProfesor.php">Profesores</a></li>
            <li><a class="dropdown-item" href="<?= $base ?>/crudregistro/CrudGrupo.php">Grupos</a></li>
            <li><a class="dropdown-item" href="<?= $base ?>/crudregistro/CrudMateria.php">Materias</a></li>
            <li><a class="dropdown-item" href="<?= $base ?>/crudregistro/CrudUnidad.php">Unidades</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?= $base ?>/crudregistro/CrudPuesto.php">Puestos</a></li>
            <li><a class="dropdown-item" href="<?= $base ?>/crudregistro/CrudUsuario.php">Usuarios</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Procesos</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= $base ?>/procesos/inscripcion_grupo.php">Inscripción a Grupos</a></li>
            <li><a class="dropdown-item" href="<?= $base ?>/procesos/asignacion_materia.php">Asignación de Materias</a></li>
            <li><a class="dropdown-item" href="<?= $base ?>/procesos/captura_calificaciones.php">Captura de Calificaciones</a></li>
          </ul>
        </li>

       <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Reportes</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= $base ?>/reportes/rep_alumnos.php">Alumnos</a></li>
            <li><a class="dropdown-item" href="<?= $base ?>/reportes/rep_boleta.php">Boleta</a></li>
            <li><a class="dropdown-item" href="<?= $base ?>/reportes/rep_calificaciones.php">Calificaciones</a></li>
            <li><a class="dropdown-item" href="<?= $base ?>/reportes/rep_grupos.php">Grupos</a></li>
            <li><a class="dropdown-item" href="<?= $base ?>/reportes/rep_materias.php">Materias</a></li>
            <li><a class="dropdown-item" href="<?= $base ?>/reportes/rep_profesores.php">Profesores</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?= $base ?>/reportes/rep_unidad.php">Unidad</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>

<?php if ($es_directo): ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php endif; ?>