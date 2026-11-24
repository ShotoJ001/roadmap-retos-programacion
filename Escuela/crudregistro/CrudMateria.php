<?php
require_once __DIR__ . "/../config/conexion.php";

if (isset($_GET['baja'])) {
    $id = (int)$_GET['baja'];
    $conexion->query("UPDATE materias SET estatus = 'Inactivo', fecha_baja = NOW() WHERE id = $id");
    header("Location: CrudMateria.php");
    exit;
}

$lista = $conexion->query("SELECT * FROM materias WHERE estatus = 'Activo' ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Materias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>

<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Catalogo de Materias</h5>
            <a href="../baja/bajaMateria.php" class="btn btn-warning btn-sm text-dark fw-semibold">Ver Bajas</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Clave</th>
                        <th>Materia</th>
                        <th>Créditos</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($r = $lista->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$r['id'] ?></td>
                        <td><strong><?= htmlspecialchars($r['clave_mat']) ?></strong></td>
                        <td><?= htmlspecialchars($r['nombre_mat']) ?></td>
                        <td><?= (int)$r['creditos'] ?></td>
                        <td>
                            <span class="badge bg-success"><?= htmlspecialchars($r['estatus']) ?></span>
                        </td>
                        <td>
                            <a href="../formularios/alta.php?tipo=materia" class="btn btn-success btn-sm" title="Nueva Materia">
                                <i class="bi bi-plus-lg"></i>
                            </a>
                            <a href="../formularios/modificar.php?tipo=materia&id=<?= (int)$r['id'] ?>" class="btn btn-primary btn-sm" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="?baja=<?= (int)$r['id'] ?>" class="btn btn-danger btn-sm" title="Dar de baja" onclick="return confirm('¿Dar de baja esta materia?');">
                                <i class="bi bi-trash-fill"></i>
                            </a>
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