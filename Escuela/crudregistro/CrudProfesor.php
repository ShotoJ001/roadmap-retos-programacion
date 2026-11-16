<?php
require_once __DIR__ . "/../config/conexion.php";
if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    $conexion->query("UPDATE profesores SET estatus = 'Inactivo', fecha_baja = NOW() WHERE id = $id");
    header("Location: CrudProfesor.php"); exit;
}
$lista = $conexion->query("SELECT * FROM profesores WHERE estatus = 'Activo' ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Profesores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Gestión de Profesores</h5>
            <div>
                <a href="../baja/bjaProfesor.php" class="btn btn-warning btn-sm text-dark fw-bold me-2">Ver Bajas</a>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Clave</th>
                        <th>Docente</th>
                        <th>Correo</th>
                        <th>Tel</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($r = $lista->fetch_assoc()): ?>
                    <tr>
                        <td><?= $r['id'] ?></td>
                        <td><strong><?= htmlspecialchars($r['clave']) ?></strong></td>
                        <td><?= htmlspecialchars($r['nombre'].' '.$r['apaterno'].' '.$r['amaterno']) ?></td>
                        <td><?= htmlspecialchars($r['mail']) ?></td>
                        <td><?= htmlspecialchars($r['tel']) ?></td>
                        <td><span class="badge bg-success">Activo</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="../formularios/alta.php?tipo=profesor" class="btn btn-success btn-sm" title="Alta"><i class="bi bi-plus-lg"></i></a>
                                <a href="../formularios/modificar.php?tipo=profesor&id=<?= $r['id'] ?>" class="btn btn-primary btn-sm" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                                <a href="?eliminar=<?= $r['id'] ?>" class="btn btn-danger btn-sm" title="Dar de baja" onclick="return confirm('¿Enviar este profesor a bajas?');"><i class="bi bi-trash-fill"></i></a>
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