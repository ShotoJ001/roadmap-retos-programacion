<?php
require_once __DIR__ . "/../config/conexion.php";

if (isset($_GET['alta'])) {
    $id = (int)$_GET['alta'];
    $conexion->query("UPDATE alumnos SET estatus = 'Activo', fecha_baja = NULL WHERE id = $id");
    header("Location: bajaAlumno.php"); exit;
}

if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    $conexion->query("DELETE FROM alumnos WHERE id = $id");
    header("Location: bajaAlumno.php"); exit;
}

$lista = $conexion->query("SELECT * FROM alumnos WHERE estatus = 'Inactivo' ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alumnos Inactivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Alumnos Dados de Baja</h5>
            <a href="../crudregistro/CrudAlumno.php" class="btn btn-secondary btn-sm">Regresar</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Matrícula</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Domicilio</th>
                        <th>Contacto</th>
                        <th>Tutor</th>
                        <th>Estatus</th>
                        <th>Fecha de Baja</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($r = $lista->fetch_assoc()): ?>
                    <tr>
                        <td><?= $r['id'] ?></td>
                        <td><strong><?= htmlspecialchars($r['matricula']) ?></strong></td>
                        <td><?= htmlspecialchars($r['nombre']) ?></td>
                        <td><?= htmlspecialchars($r['apaterno']) ?></td>
                        <td><?= htmlspecialchars($r['amaterno']) ?></td>
                        <td><?= htmlspecialchars($r['dom']) ?></td>
                        <td><?= htmlspecialchars($r['mail']) ?><br><small class="text-muted"><?= htmlspecialchars($r['tel']) ?></small></td>
                        <td><?= htmlspecialchars($r['tutor'] ?? '') ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($r['estatus']) ?></span></td>
                        <td><?= htmlspecialchars($r['fecha_baja'] ?? '') ?></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="?alta=<?= $r['id'] ?>" class="btn btn-success btn-sm" title="Dar de alta"><i class="bi bi-check-lg"></i></a>
                                <a href="?eliminar=<?= $r['id'] ?>" class="btn btn-danger btn-sm" title="Eliminar definitivamente" onclick="return confirm('¿Eliminar definitivamente de la base de datos?');"><i class="bi bi-trash-fill"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>