<?php
require_once __DIR__ . "/../config/conexion.php";

if (isset($_GET['alta'])) {
    $id = (int)$_GET['alta'];
    $conexion->query("UPDATE unidades SET estatus = 'Activo', fecha_baja = NULL WHERE id = $id");
    header("Location: bajaUnidad.php");
    exit;
}

if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    $conexion->query("DELETE FROM unidades WHERE id = $id");
    header("Location: bajaUnidad.php");
    exit;
}

$lista = $conexion->query("SELECT * FROM unidades WHERE estatus = 'Inactivo' ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bajas de Unidades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Unidades Dadas de Baja</h5>
            <a href="../crudregistro/CrudUnidad.php" class="btn btn-secondary btn-sm">Regresar</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Unidad</th>
                        <th>Estatus</th>
                        <th>Fecha de Baja</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($r = $lista->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$r['id'] ?></td>
                        <td><?= htmlspecialchars($r['nombre_unidad']) ?></td>
                        <td><span class="badge text-bg-secondary"><?= htmlspecialchars($r['estatus']) ?></span></td>
                        <td><?= htmlspecialchars($r['fecha_baja'] ?? '—') ?></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="?alta=<?= (int)$r['id'] ?>" class="btn btn-success" title="Dar de alta">
                                    <i class="bi bi-check-lg"></i>
                                </a>
                                <a href="?eliminar=<?= (int)$r['id'] ?>" class="btn btn-danger" title="Eliminar definitivamente" onclick="return confirm('¿Eliminar esta unidad de forma definitiva?');">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
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