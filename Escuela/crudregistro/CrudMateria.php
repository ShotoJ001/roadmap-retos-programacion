<?php
require_once __DIR__ . "/../config/conexion.php";
if (isset($_GET['baja'])) {
    $id = (int)$_GET['baja'];
    $conexion->query("UPDATE materias SET estatus = IF(estatus='Activo','Inactivo','Activo') WHERE id = $id");
    header("Location: CrudMateria.php"); exit;
}
$lista = $conexion->query("SELECT * FROM materias ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>CRUD Materias</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📋 Gestión de Materias</h5>
            <a href="../formularios/alta.php?tipo=materia" class="btn btn-success btn-sm">➕ Nueva Materia</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light"><tr><th>ID</th><th>Clave</th><th>Materia</th><th>Créditos</th><th>Estatus</th><th>Acciones</th></tr></thead>
                <tbody>
                    <?php while ($r = $lista->fetch_assoc()): ?>
                    <tr>
                        <td><?= $r['id'] ?></td>
                        <td><strong><?= htmlspecialchars($r['clave_mat']) ?></strong></td>
                        <td><?= htmlspecialchars($r['nombre_mat']) ?></td>
                        <td><?= $r['creditos'] ?></td>
                        <td><span class="badge <?= $r['estatus']==='Activo'?'bg-success':'bg-secondary' ?>"><?= $r['estatus'] ?></span></td>
                        <td>
                            <a href="../formularios/modificar.php?tipo=materia&id=<?= $r['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="?baja=<?= $r['id'] ?>" class="btn btn-danger btn-sm"><?= $r['estatus']==='Activo'?'Baja':'Activar' ?></a>
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
